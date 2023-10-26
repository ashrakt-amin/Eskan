<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PortfolioProjectRequest;
use App\Models\RealEstateProject;
use App\Models\Projectfile;
use App\Http\Resources\Project\projectWallet;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;



class RealEstateProjectController extends Controller
{
use TraitImageProccessingTrait , TraitResponseTrait ;

  
    public function index()
    {
        $data = RealEstateProject::all();
        return $this->sendResponse(projectWallet::collection($data) , " " ,200);
    }

  
    public function store(PortfolioProjectRequest $request)
    {
        try {

            $data = new RealEstateProject();
            $img = $this->aspectForResize($request->img , RealEstateProject::IMAGE_PATH, 500, 600);
            $project = $data->create([
                'name'    =>  $request->name,
                'img'     =>  $img,
                'address' =>  $request->address,
                'resale'  =>  $request->resale,
                'link'    =>  $request->link == null ? null : $request->link ,
                'description' => $request->description,
                'detalis'  =>  $request->detalis,
                'features' =>  $request->features == null ? null : $request->features,
            ]);                

            if($request->file){
            $project->files()->createMany($this->setImages($request->file,Projectfile::File_PATH,'file' , 500, 600));
            }
            return $this->sendResponse($project, "تم الحفظ" ,200);
            
        } catch (\Exception $e) {
            return $this->sendError($e, "error " ,404);

        }

    }

 
    public function show($id)
    {
        return $this->sendResponse(new projectWallet(RealEstateProject::findOrFail($id)) , " " ,200);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy($id)
    {
        $data = RealEstateProject::findOrFail($id);
        $this->deleteImage(RealEstateProject::IMAGE_PATH , $data->img);
        $data->delete();
        return $this->sendResponse("success", "تم الحذف" ,200);

    }
}
