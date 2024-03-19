<?php

namespace App\Http\Controllers;

use App\Models\Ownersystem;
use Illuminate\Http\Request;
use App\Http\Traits\PaginationTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OwnerSystemsRequest;
use App\Http\Resources\OwnerSystemsResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;


class OwnersystemController extends Controller
{
    use TraitResponseTrait , PaginationTrait;
    protected $Repository;


    
    public function index(Request $request)
    {
        $role = Auth::user()->role;
        if (Auth::check() &&  ($role == "متابعه عملاء" || $role == "admin")) {

            $courses = Ownersystem::paginate($request['paginate']);
            $currentPage = $courses->currentPage();
            $totalPages = $courses->lastPage();
            $paginationUrls = $this->generatePaginationUrls($currentPage, $totalPages, $request);

            $response = [
                'current_page'  => $currentPage,
                'data'          => OwnerSystemsResource::collection($courses),
                'total_pages'   => $totalPages,
                'next_page_url' => $paginationUrls['next_page_url'],
                'prev_page_url' => $paginationUrls['prev_page_url'],
            ];
            return $this->sendResponse($response,"data", 200);
        } else {
            return $this->sendError('sorry', "you don't have permission to access this", 404);
        }
    }



    public function store(OwnerSystemsRequest $request)
    {
        $data = Ownersystem::create($request->validated());
        return $this->sendResponse($data, "تم التسجيل ", 200);
    }



    public function show($id)
    {
        $data = Ownersystem::findOrFail($id);
        return $this->sendResponse(new OwnerSystemsResource($data), "success show", 200);
    }


    public function update(Request $request, $id)
    {
        $data = Ownersystem::findOrFail($id);
        $data->update($request->all());
        return $this->sendResponse($data,"success update", 200);
    }


    public function destroy($id)
    {
      Ownersystem::findOrFail($id)->delete();
       
        return $this->sendResponse('',"success delete", 200);

    }


}
