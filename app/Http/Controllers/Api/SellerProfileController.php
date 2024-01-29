<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\FormSell;
use App\Models\Sellproject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\sellsProfile\UserResource;
use App\Http\Resources\sellsProfile\ProjectResource;
use App\Http\Resources\sellsProfile\SellsSiteResource;
use App\Http\Resources\sellsProfile\SellerdashResource;
use App\Http\Resources\sellsProfile\parentSellsResource;
use App\Http\Resources\sellsProfile\ShowProjectResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Resources\sellsProfile\FormSellerdashResource;
use App\Http\Resources\sellsProfile\SellswithClientsResource;

class SellerProfileController extends Controller
{
    use TraitResponseTrait;

    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     $user = Auth::user();
        //     if (($user->role == 'مسؤل مبيعات'  || $user->role == 'sells admin' )) {
        //         return $next($request);
        //     }
        //     return $this->sendError("Unauthorized", "you must be sells admin or sells", 404);
        // });
    }

    public function sells_project() //all sells project for sells admin
    {
        $user = Auth::user()->role;
        if ($user == "sells admin") {
            $sells = Sellproject::all();
            return $this->sendResponse(ProjectResource::collection($sells), "sells admin", 200);
        } else {
            return $this->sendError("Unauthorized", "you must be sells admin ", 404);
        }
    }

    /*seller or sells admin dash which return in data of user admin if
  role sells admin or all sells with them projects */
    public function show_user($id = null)
    {
        if ($id == null && Auth::user()->role == "sells admin") {
            $user = Auth::user();
            $sells = User::whereHas('children')->get();
            $data =  [
                'sells_admin'   => new SellerdashResource($user),
                'sells'         => parentSellsResource::collection($sells)
            ];
            return $this->sendResponse($data, "sells admin profile dash with all sells", 200);
        } elseif ($id == null && Auth::user()->role == "مسؤل مبيعات") {
            $user = Auth::user();
            return $this->sendResponse(new SellerdashResource($user), "sells profile dash", 200);
        } elseif ($id != null && (Auth::user()->role == "sells admin" || Auth::user()->role == "مسؤل مبيعات")) {
            $user = User::findOrFail($id);
            return $this->sendResponse(new SellerdashResource($user), "sells profile dash", 200);
        }
    }

    public function index() //all sells dash
    {
        $user = Auth::user()->role;
        if ($user == "sells admin") {
            $sells = User::whereHas('children')->get();
            return $this->sendResponse(parentSellsResource::collection($sells), "sells admin", 200);
        } else {
            return $this->sendError("Unauthorized", "you must be sells admin ", 404);
        }
    }

    public function sells_project_client(Request $request)
    {
        $user = Auth::user();
        $projectId = $request->query('project_id');
        $userId = $request->query('user_id');
        if (($user->role == 'مسؤل مبيعات' || $user->role == 'sells admin') && ($user->parent_id == NULL || $user->id == $userId)) {
            $seller = User::findOrFail($userId);
            $clients = FormSell::where('user_id', $userId)
                ->where('sellproject_id', $projectId)
                ->get();
            // return $clients ;
            // $clients =  User::whereHas('Sellprojects', function ($query) use ($projectId) {
            //     $query->where('sellproject_id', $projectId);
            // })->with('clients')->where('id', $userId)->first();


            $data =  [
                'user'        => new UserResource($seller),
                'clients'     => FormSellerdashResource::collection($clients)
            ];
            // return $clients->clients ;
            return $this->sendResponse($data, "seller with clints", 200);
        }
    }

    public function sells_project_sells(Request $request)
    {
        $projectId = $request->query('project_id');
        $userId = $request->query('user_id');
        $parent = User::findOrFail($userId);
        $user = Auth::user();

        if (($user->role == 'مسؤل مبيعات'  || $user->role == 'sells admin') && ($user->parent_id == NULL || $user->id == $userId)) {
            $users = User::whereHas('Sellprojects', function ($query) use ($projectId) {
                $query->where('sellproject_id', $projectId);
            })->where('parent_id', $userId)->get();

            return $this->sendResponse(UserResource::collection($users), "sells of $parent->name", 200);
        }
    }

    public function show_project($id)
    {
        $project = Sellproject::with('users')->findOrFail($id);
        return $this->sendResponse(new ShowProjectResource($project), "sells user", 200);
    }

    public function sells_site(Request $request)
    {

        $projectId = $request->query('project_id');
        $userId = $request->query('user_id');
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
