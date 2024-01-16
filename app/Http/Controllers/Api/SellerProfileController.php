<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\FormSell;
use App\Models\Sellproject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\sellsProfile\ProjectResource;
use App\Http\Resources\sellsProfile\SellsSiteResource;
use App\Http\Resources\sellsProfile\SellerdashResource;
use App\Http\Resources\sellsProfile\ShowProjectResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Resources\sellsProfile\FormSellerdashResource;

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


    public function show_user() //seller dash
    {
        $user = Auth::user();
        //  return $user ;
        if ($user->role == "مسؤل مبيعات") {
            return $this->sendResponse(new SellerdashResource($user), "sells user", 200);
        }
    }

    public function sells_project_client(Request $request)
    {

        $projectId = $request->query('project_id');
        $userId = $request->query('user_id');
        //  return $user ;
        $clients = FormSell::with('user', 'sellproject')
        ->where('user_id', $userId)
        ->where('sellproject_id', $projectId)
        ->get();

        return $this->sendResponse(FormSellerdashResource::collection($clients), "clints", 200);
    }

    public function show_project($id)
    {
        $user = Auth::user();
        if ($user->role == "مسؤل مبيعات") {
            $project = Sellproject::with('users')->findOrFail($id);
            // return $project ;
            return $this->sendResponse(new ShowProjectResource($project), "sells user", 200);
        }
    }

    public function sells_site(Request $request)
    {

        $projectId = $request->query('project_id');
        $userId = $request->query('user_id');

        // $user = User::with('Sellprojects')->get();

        $user = User::where('id', $userId)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $sellproject = $user->sellprojects()->where('sellprojects.id', $projectId)->first();
        $data =  [
            'user'        => new SellsSiteResource($user),
            'sellproject' => new ShowProjectResource($sellproject)
        ];

        return $this->sendResponse($data, "sells site", 200);
    }
}
