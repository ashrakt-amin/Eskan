<?php

namespace App\Http\Controllers\Api;

use App\Models\Sellproject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\sellsProfile\ProjectResource;
use App\Http\Resources\sellsProfile\SellerdashResource;
use App\Http\Resources\sellsProfile\ShowProjectResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;

class SellerProfileController extends Controller
{
   use TraitResponseTrait;
    public function index()
    {
        //
    }

   
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show_user()
    {
        $user = Auth::user();
        //  return $user ;
        if($user->role == "مسؤل مبيعات"){
            return $this->sendResponse(new SellerdashResource($user), "sells user", 200);
        }        
    }

    public function show_project($id)
    {
        $user = Auth::user();
        if($user->role == "مسؤل مبيعات"){
        $project = Sellproject::with('users')->findOrFail($id);
        // return $project ;
            return $this->sendResponse(new ShowProjectResource($project), "sells user", 200);
        }        
    }

    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
