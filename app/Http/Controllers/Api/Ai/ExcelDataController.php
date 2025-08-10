<?php

namespace App\Http\Controllers\Api\Ai;

use App\Http\Classes\ChunkReadFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExcelFiles;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Models\Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;

class ExcelDataController extends Controller
{
    use TraitResponseTrait;

    public function index()
    {
        $uploadedFiles = Excel::all();
        return $this->sendResponse(ExcelFiles::collection($uploadedFiles), 'جميع الملفات', 200);
    }

    public function show($id)
    {
        $uploadedFile = Excel::find($id);

        if (! $uploadedFile) {
            return $this->sendError('error', ['لم يتم العثور على الملف في قاعدة البيانات'], 404);
        }

        $fileName = $uploadedFile->file;
        $filePath = 'images/files/' . $fileName;
        $realPath = base_path('storage/app/public/' . $filePath);

        if (Storage::disk('public')->exists($filePath)) {
            try {
                // تأكد من مسار الملف، لو 'images/files' في الـ Model بتاعه، Path Accessor هو اللي بيحط الجزء دا.
                // أو ممكن تستخدم Storage::disk('public')->path($filePath) مباشرة
                $reader = IOFactory::createReaderForFile($realPath);
                $spreadsheet = $reader->load($realPath);
                $worksheet = $spreadsheet->getActiveSheet();

                // قراءة الهيدر بشكل منفصل
                $headerRow = $worksheet->getRowIterator(1, 1)->current();
                $headerData = [];
                $cellIterator = $headerRow->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                foreach ($cellIterator as $cell) {
                    $headerData[] = $cell->getValue();
                }
                $header = $headerData;
                Log::info('Initial Header: ' . json_encode($header));

                $chunkFilter = new ChunkReadFilter();
                $reader->setReadFilter($chunkFilter);
                $chunkSize = 1000;
                $startRow = 2; // ابدأ قراءة البيانات من الصف الثاني
                $allData = [];
                $highestDataRow = $worksheet->getHighestDataRow();

                Log::info('Highest Row: ' . $worksheet->getHighestRow());
                Log::info('Highest Data Row: ' . $highestDataRow);

                while ($startRow <= $highestDataRow) {
                    $chunkFilter->setRows($startRow, $chunkSize);
                    $spreadsheet = $reader->load($realPath); // حمل جزء تاني من الملف
                    $worksheet = $spreadsheet->getActiveSheet();
                    $rowIterator = $worksheet->getRowIterator($startRow, min($startRow + $chunkSize - 1, $highestDataRow));

                    foreach ($rowIterator as $row) {
                        $rowIndex = $row->getRowIndex();
                        Log::info('Processing Row Index: ' . $rowIndex . ', Start Row: ' . $startRow);
                        $rowData = [];
                        $cellIterator = $row->getCellIterator();
                        $cellIterator->setIterateOnlyExistingCells(false);
                        foreach ($cellIterator as $cell) {
                            $rowData[] = $cell->getValue();
                        }
                        Log::info('Row Data (' . $rowIndex . '): ' . json_encode($rowData));
                        if (!empty($header)) {
                            $combinedData = array_combine($header, $rowData);
                            Log::info('Adding to allData: ' . json_encode($combinedData));
                            $allData[] = $combinedData;
                        }
                    }
                    $startRow += $chunkSize;
                    $spreadsheet->disconnectWorksheets();
                }

                return $this->sendResponse($allData, " ", 200);
            } catch (\Exception $e) {
                Log::error('Error reading Excel file: ' . $e->getMessage() . ' for file: ' . $realPath);
                return $this->sendError('error', ['حدث خطأ أثناء قراءة الملف: ' . $e->getMessage()], 500);
            }
        } else {
            return $this->sendError('error', ['الملف غير موجود في المسار: ' . $filePath], 500);
        }
    }




    public function store(Request $request)
    {
        $messages = [
            'file.required' => 'الملف مطلوب.',
            'name.required' => 'اسم الملف مطلوب',
            'file.mimes'    => 'يجب أن يكون الملف من نوع: XLSX, XLS, CSV', // يفضل كتابة Mimes بحروف كبيرة
            'file.max'      => 'يجب أن لا يتعدى حجم الملف 20 ميجا .',
        ];

        $validator = Validator::make($request->all(), [
            'file' => 'nullable|mimes:xlsx,xls,csv|max:20480',
            'name' => 'required|string|max:255', // إضافة قواعد للاسم
        ], $messages);

        if ($validator->fails()) {
            return $this->sendError('false', array_values($validator->errors()->all()), 422);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // 1. التحقق من قابلية القراءة قبل الحفظ
            try {
                // IOFactory::createReaderForFile() بتحاول تنشئ قارئ للملف
                // لو فيه مشكلة في الملف (تالف أو مش Excel/CSV حقيقي)، هترمي Exception
                $reader = IOFactory::createReaderForFile($file->getPathname());
                // ممكن تضيف: $reader->canRead($file->getPathname()) للتحقق المسبق
                $reader->load($file->getPathname()); // محاولة تحميل الملف للتأكد من قابليته للقراءة

            } catch (ReaderException $e) {
                Log::error('Unreadable Excel file uploaded: ' . $e->getMessage());
                return $this->sendError('error', ['الملف غير قابل للقراءة أو تالف. يرجى التأكد من صلاحية ملف الإكسل.'], 400); // 400 Bad Request
            } catch (\Exception $e) { // لأي استثناءات أخرى قد تحدث أثناء القراءة
                Log::error('Unexpected error during Excel file readability check: ' . $e->getMessage());
                return $this->sendError('error', ['حدث خطأ غير متوقع أثناء التحقق من الملف: ' . $e->getMessage()], 500);
            }


            // 2. إذا كان الملف قابلاً للقراءة، أكمل عملية الحفظ
            $path = $file->store('public/images/files');
            if ($path) {
                $fileName = pathinfo($path, PATHINFO_BASENAME);

                // إنشاء سجل جديد للملف
                $uploadedFile = Excel::create([
                    'name' => $request->name,
                    'file' => $fileName,
                    // 'user_id' => auth()->id(), // <<<<< مهم جداً: مين اللي رفع الملف ده؟ (لو عندك Authentication)
                ]);


                $response = [
                    'id'   => $uploadedFile->id,
                    'name' => $uploadedFile->name,
                    'file' => $uploadedFile->path, // استخدم Storage::url() للحصول على الـ URL العام
                ];
                return $this->sendResponse($response, 'تم رفع وتخزين الملف بنجاح.', 200);
            } else {
                return $this->sendError('error', ['حدث خطأ أثناء رفع وتخزين الملف'], 500);
            }
        }
        return $this->sendError('error', ['لم يتم العثور على ملف للرفع'], 500);
    }


    public function update(Request $request, $id)
    {
        $messages = [
            'name.required' => 'اسم الملف مطلوب',
            'file.mimes'    => 'يجب أن يكون الملف من نوع: XLSX, XLS, CSV',
            'file.max'      => 'يجب أن لا يتعدى حجم الملف 20 ميجا .',
        ];

        $validator = Validator::make($request->all(), [
            'file' => 'nullable|mimes:xlsx,xls,csv|max:20480',
            'name' => 'required|string|max:255',
        ], $messages);

        if ($validator->fails()) {
            return $this->sendError('false', array_values($validator->errors()->all()), 422);
        }

        $uploadedFile = Excel::find($id);

        if (!$uploadedFile) {
            return $this->sendError('error', ['لم يتم العثور على الملف في قاعدة البيانات'], 404);
        }

        $uploadedFile->name = $request->name; // تحديث الاسم دائمًا

        if ($request->hasFile('file') && $request->file('file') != null) { // استخدم file() بدل property الوصول المباشر
            $file = $request->file('file');

            // التحقق من قابلية القراءة للملف الجديد قبل التحديث
            try {
                $reader = IOFactory::createReaderForFile($file->getPathname());
                $reader->load($file->getPathname());
            } catch (ReaderException $e) {
                Log::error('Unreadable Excel file during update: ' . $e->getMessage());
                return $this->sendError('error', ['الملف الجديد غير قابل للقراءة أو تالف. يرجى التأكد من صلاحية ملف الإكسل.'], 400);
            } catch (\Exception $e) {
                Log::error('Unexpected error during Excel file update readability check: ' . $e->getMessage());
                return $this->sendError('error', ['حدث خطأ غير متوقع أثناء التحقق من الملف الجديد: ' . $e->getMessage()], 500);
            }


            $path = $file->store('images/files', 'public'); // تخزين في الـ Storage Link

            if ($path) {
                $fileName = basename($path);

                // حذف الملف القديم إذا كان موجود
                if ($uploadedFile->file && Storage::disk('public')->exists('images/files/' . $uploadedFile->file)) {
                    Storage::disk('public')->delete('images/files/' . $uploadedFile->file);
                }

                $uploadedFile->file = $fileName; // تحديث اسم الملف
            } else {
                return $this->sendError('error', ['حدث خطأ أثناء رفع وتخزين الملف'], 500);
            }
        }

        $uploadedFile->save(); // حفظ التغييرات في قاعدة البيانات

        $response = [
            'id' => $uploadedFile->id,
            'name' => $uploadedFile->name,
            'file' => $uploadedFile->path, // استخدام الـ Accessor للحصول على مسار الـ URL
        ];

        return $this->sendResponse($response, 'تم تحديث معلومات الملف بنجاح', 200);
    }



    public function destroy($id)
    {
        $uploadedFile = Excel::find($id);

        if (!$uploadedFile) {
            return $this->sendError('error', ['لم يتم العثور على الملف في قاعدة البيانات'], 404);
        }

        $filePath = 'images/files/' . $uploadedFile->file; // تأكد من المسار الصحيح للحذف
        // لو كانت بتستخدم 'images/files' في الـ update، يبقى لازم يكون نفس المسار هنا.
        // يفضل توحيد المسار في كل العمليات: 'images/files' أو 'images/files'

        // حذف الملف من الـ storage
        if (Storage::disk('public')->exists($filePath)) {
            try {
                Storage::disk('public')->delete($filePath);
                Log::info('Excel file deleted from storage: ' . $filePath . ' by user: ' . (auth()->check() ? auth()->id() : 'Guest'));
            } catch (\Exception $e) {
                Log::error('Failed to delete Excel file from storage: ' . $filePath . '. Error: ' . $e->getMessage());
                return $this->sendError('error', ['فشل حذف الملف من التخزين: ' . $e->getMessage()], 500);
            }
        } else {
            // لو الملف مش موجود في الـ storage بس موجود في DB، ممكن تسجل ده كـ warning وتكمل حذف من DB
            Log::warning('Excel file not found in storage, but trying to delete from DB: ' . $filePath);
        }

        // حذف السجل من قاعدة البيانات
        try {
            $uploadedFile->delete();
            Log::info('Excel file record deleted from database: ID ' . $id . ' by user: ' . (auth()->check() ? auth()->id() : 'Guest'));
            return $this->sendResponse([], 'تم حذف الملف بنجاح.', 200);
        } catch (\Exception $e) {
            Log::error('Failed to delete Excel file record from database: ID ' . $id . '. Error: ' . $e->getMessage());
            return $this->sendError('error', ['فشل حذف سجل الملف من قاعدة البيانات: ' . $e->getMessage()], 500);
        }
    }
}
