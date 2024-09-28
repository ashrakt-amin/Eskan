<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Souqistanboulform;
use App\Http\Controllers\Controller;
use App\Http\Traits\PaginationTrait;
use App\Http\Requests\SouqistaboulformRequest;
use App\Http\Resources\SouqistanboulformResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;



class SouqistanboulformController extends Controller
{
    use TraitResponseTrait, PaginationTrait;

    public function index(Request $request)
    {

        $query = Souqistanboulform::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('phone')) {
            $query->where('phone', 'like', '%' . $request->input('phone') . '%');
        }

        if ($request->has('region')) {
            $query->where('region', 'like', '%' . $request->input('region') . '%');
        }

        if ($request->has('shop_number')) {
            $query->where('shop_number', 'like', '%' . $request->input('shop_number') . '%');
        }


        $data = $query->latest()->paginate($request['paginate']);

        $currentPage = $data->currentPage();
        $totalPages  = $data->lastPage();
        $paginationUrls = $this->generatePaginationUrls($currentPage, $totalPages, $request);

        $response = [
            'current_page'  => $currentPage,
            'data'          => SouqistanboulformResource::collection($data),
            'total_pages'   => $totalPages,
            'next_page_url' => $paginationUrls['next_page_url'],
            'prev_page_url' => $paginationUrls['prev_page_url'],
        ];

        return $this->sendResponse($response, "كل البيانات", 200);
    }


    public function show($id)
    {
        $data = Souqistanboulform::findOrFail($id);
        return $this->sendResponse(new SouqistanboulformResource($data), "تم", 200);
    }

    public function store(SouqistaboulformRequest $request)
    {
        $data = Souqistanboulform::create($request->validated());
        return $this->sendResponse($data, "تم التسجيل  ", 200);
    }


    public function update(Request $request, $id)
    {
        $data = Souqistanboulform::findOrFail($id);
        $data->update($request->all());
        return $this->sendResponse($data, "تم التعديل  ", 200);
    }


    public function destroy($id)
    {
        $data = Souqistanboulform::findOrFail($id);
        $data->delete();
        return $this->sendResponse('success', "تم الحذف  ", 200);
    }
}
