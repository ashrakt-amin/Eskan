<?php

namespace App\Http\Controllers\Api\Ai;

use App\Http\Controllers\Controller;
use App\Http\Resources\ai\NafieResource;
use App\Http\Traits\PaginationTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Nafie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NafieController extends Controller
{
    use PaginationTrait, ResponseTrait;

    public function index(Request $request)
    {
        $query = Nafie::query();

        if (isset($request['name']) && $request['name'] != null) {
            $query->where('name',  'LIKE', '%' .  $request['name'] . '%');
        }

        if (isset($request['phone']) && $request['phone'] != null) {
            $query->where('phone',  'LIKE', '%' .  $request['phone'] . '%');
        }

        $data = $query->latest()->paginate($request['paginate']);
        $currentPage = $data->currentPage();
        $totalPages  = $data->lastPage();
        $paginationUrls = $this->generatePaginationUrls($currentPage, $totalPages, $request);

        $response = [
            'current_page'  => $currentPage,
            'data'          => NafieResource::collection($data),
            'total_pages'   => $totalPages,
            'next_page_url' => $paginationUrls['next_page_url'],
            'prev_page_url' => $paginationUrls['prev_page_url'],
        ];

        return $this->sendResponse($response, "بيانات نافع", 200);
    }


    public function store(Request $request)
    {
        $messages = [
            'name.required'  => 'الاسم مطلوب',
            'phone.required' => 'رقم الهاتف مطلوب',
            'type.required'  => 'نوع الوحدة مطلوب',
        ];


        $validator = Validator::make($request->all(), [
            'name'   => 'required',
            'phone'  => 'required',
            'type'   => 'required',
        ], $messages);


        if ($validator->fails()) {
            return $this->sendError(array_values($validator->errors()->all()), [], 422);
        }

        $validatedData = $validator->validated();

        $data = Nafie::create([
            'name'  => $validatedData['name'],
            'phone'  => $validatedData['phone'],
            'type'   => $validatedData['type'],
        ]);

        return $this->sendResponse(new NafieResource($data), "تم التسجيل مع نافع", 200);
    }
}
