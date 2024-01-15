<?php

namespace App\Http\Controllers\Api;

use App\Models\FormSell;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FormSellRequest;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Resources\sellsProfile\FormSellerdashResource;

class FormsellsController extends Controller
{
    use TraitResponseTrait;

    public function index()
    {
        //
    }

    public function store(FormSellRequest $request)
    {
        $data = FormSell::create($request->validated());
        return $this->sendResponse(new FormSellerdashResource($data), "sells client", 200);
    }



    public function update_status(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == "admin" ||  $role == "مسؤل مبيعات") {
            $data = FormSell::findOrFail($request->client_id);
            $data->update([
                'status' => 1
            ]);
        }
        return $this->sendResponse(new FormSellerdashResource($data), "update client status", 200);

    }


    public function destroy(string $id)
    {
        //
    }
}
