<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\PaginationTrait;
use App\Http\Requests\VisitorRequest;
use App\Http\Resources\VisitorResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;


class VisitorController extends Controller
{
    use TraitResponseTrait ,PaginationTrait;


    public function index(Request $request)
    {
        $query = Visitor::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('phone')) {
            $query->where('phone', 'like', '%' . $request->input('phone') . '%');
        }
        
        $data = $query->latest()->paginate($request['paginate']);

        $currentPage = $data->currentPage();
        $totalPages  = $data->lastPage();
        $paginationUrls = $this->generatePaginationUrls($currentPage, $totalPages, $request);

        $response = [
            'current_page'  => $currentPage,
            'data'          => VisitorResource::collection($data),
            'total_pages'   => $totalPages,
            'next_page_url' => $paginationUrls['next_page_url'],
            'prev_page_url' => $paginationUrls['prev_page_url'],
        ];

        return $this->sendResponse($response, "كل الزوار", 200);
    }
  


    public function show($id)
    {
        $data = Visitor::findOrFail($id);
        return $this->sendResponse(new VisitorResource($data), "تم", 200);
    }

    public function store(VisitorRequest $request)
    {
        $data = $request->validated();
        $data['created_at'] = Carbon::parse($request['created_at'])->toDateString();
        $data = Visitor::create($data);
        return $this->sendResponse($data, "تم التسجيل  ", 200);
    }


    public function update(Request $request, $id)
    {
        $data = Visitor::findOrFail($id);

        if(isset($data['created_at']) && $data['created_at'] != null){
            $data['created_at'] = Carbon::parse($request['created_at'])->toDateString();
        }
        
        $data->update($request->all());
        return $this->sendResponse($data, "تم التعديل  ", 200);
    }


    public function destroy($id)
    {
        $data = Visitor::findOrFail($id);
        $data->delete();
        return $this->sendResponse('success', "تم الحذف  ", 200);

    }
}