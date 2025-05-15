<?php

namespace App\Http\Controllers\Api\Ai;

use App\Classes\ChunkReadFilter;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Jobs\ProcessExcel;
use App\Models\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExcelDataController extends Controller
{
    use TraitResponseTrait;


    public function show($id)
    {
        $uploadedFile = Excel::find($id);

        if (! $uploadedFile) {
            return $this->sendError('error', ['لم يتم العثور على الملف في قاعدة البيانات'], 404);
        }

        $fileName = $uploadedFile->file;
        $filePath = 'images/Eskan/files/' . $fileName;
        $realPath = base_path('storage/app/public/' . $filePath);

        if (Storage::disk('public')->exists($filePath)) {
            try {
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
                return $this->sendError('error', $e->getMessage(), 500);
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
            'file.mimes'    => 'يجب أن يكون الملف من نوع: :xlsx,xls,csv',
            'file.max'      => 'يجب أن لا يتعدى حجم الملف :max كيلوبايت2048.',
        ];

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:XLSX,xlsx,xls,csv|max:2048',
            'name' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return $this->sendError('false', array_values($validator->errors()->all()), 422);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $path = $file->store('public/images/Eskan/files');
            if ($path) {
                // إنشاء سجل جديد للملف الحالي وحذف أي سجلات قديمة
                $fileName = pathinfo($path, PATHINFO_BASENAME); // استخراج اسم الملف
                $uploadedFile = Excel::create([
                    'name' => $request->name,
                    'file' => $fileName,
                ]);

                //  ProcessExcel::dispatch($uploadedFile->id);

                $response = [
                    'id' => $uploadedFile->id,
                    'name' => $uploadedFile->name,
                    'file' => $uploadedFile->path,
                ];
                return $this->sendResponse($response, 'تم رفع وتخزين ومعالجه الملف بنجاح وتم حذف أي ملفات سابقة', 200);
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
            'file.mimes'    => 'يجب أن يكون الملف من نوع: :xlsx,xls,csv',
            'file.max'      => 'يجب أن لا يتعدى حجم الملف :max كيلوبايت2048.',
        ];

        $validator = Validator::make($request->all(), [
            'file' => 'nullable|mimes:XLSX,xlsx,xls,csv|max:2048',
            'name' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return $this->sendError('false', array_values($validator->errors()->all()), 422);
        }

        $uploadedFile = Excel::find($id);

        if (!$uploadedFile) {
            return $this->sendError('error', ['لم يتم العثور على الملف في قاعدة البيانات'], 404);
        }

        $uploadedFile->name = $request->name; // تحديث الاسم دائمًا

        if ($request->hasFile('file') && $request->file != null) {
            $file = $request->file('file');
            $path = $file->store('images/Eskan/files', 'public'); // تخزين في الـ Storage Link

            if ($path) {
                $fileName = basename($path);

                // حذف الملف القديم إذا كان موجود
                if ($uploadedFile->file) {
                    Storage::disk('public')->delete('images/Eskan/files/' . $uploadedFile->file);
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
}
