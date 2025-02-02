<?php

namespace App\Http\Controllers\Api;

use App\Models\Seekmoneyupdate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SeekMoneyUpdateRequest;
use App\Http\Resources\SeekMoneyUpdateResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\PaginationTrait;

class SeekmoneyupdateController extends Controller

{
    use TraitResponseTrait, PaginationTrait;

    public function index(Request $request)
    {
        $role = Auth::user()->role;

        if (Auth::check() && ($role == "admin")) {
            $query = Seekmoneyupdate::query();
            if (isset($request['phone']) && $request['phone'] != null) {
                $query->where('phone', 'like', '%' . $request['phone'] . '%');
            }

            if (isset($request['name']) && $request['name'] != null) {
                $query->where('name', 'like', '%' . $request['name'] . '%');
            }


            $data = $query->latest()->paginate($request['paginate']);
            $currentPage = $data->currentPage();
            $totalPages  = $data->lastPage();
            $paginationUrls = $this->generatePaginationUrls($currentPage, $totalPages, $request);

            $response = [
                'current_page'  => $currentPage,
                'data'      => SeekMoneyUpdateResource::collection($data),
                'total_pages'   => $totalPages,
                'next_page_url' => $paginationUrls['next_page_url'],
                'prev_page_url' => $paginationUrls['prev_page_url'],
            ];

            return $this->sendResponse($response, "بيانات حق السعى", 200);
        } else {
            return $this->sendError('sorry', "لم يكن لديك الصلاحيه", 404);
        }
    }

    public function store(SeekMoneyUpdateRequest $request)
    {
        $data = $request->validated();

        Seekmoneyupdate::create([
            'name'        => $data['name'],
            'phone'       => $data['phone'],
            'type'        => $data['type'],
            'space'       => $data['space'],
            'advance'     => $data['advance'],
            'installment' => $data['installment'],
            'responsible' => $data['responsible'],

        ]);

        return $this->sendResponse('success', "تم التسجيل", 200);
    }


    public function update(Request $request, $id)
    {
        $role = Auth::user()->role;

        if (Auth::check() && ($role == "admin")) {
            $data = Seekmoneyupdate::findOrFail($id);
            $data->update($request->all());
            return $this->sendResponse("success", "تم تعديل بيانات حق السعى", 200);
        } else {
            return $this->sendError('sorry', "لم يكن لديك الصلاحيه", 404);
        }
    }



    public function destroy($id)
    {

        $role = Auth::user()->role;

        if (Auth::check() && ($role == "admin")) {
            Seekmoneyupdate::findOrFail($id)->delete();
            return $this->sendResponse('success', "تم حذف بيانات حق السعى", 200);
        } else {
            return $this->sendError('sorry', "لم يكن لديك الصلاحيه", 404);
        }
    }
}
