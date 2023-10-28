<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PortfolioProjectRequest;
use App\Models\RealEstateProject;
use Illuminate\Support\Str;
use App\Models\Projectfile;
use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();
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
                foreach ($request->file as $file){
                    $fileName = Str::random(8) . '_' . $file->getClientOriginalName();
                    $file_title = $file->getClientOriginalName();
                    $fileWithoutExtension = pathinfo($file_title, PATHINFO_FILENAME);
                    
                    $project->files()->create([
                        'file' => $fileName,
                        'name' => $fileWithoutExtension,
                    ]);
                    $file->storeAs(Projectfile::File_PATH, $fileName, 'public');                                  
                }
            }
            DB::commit();
            return $this->sendResponse($project, "تم الحفظ" ,200);
            
        } catch (\Exception $e) {
            
            return $this->sendError($e->getMessage(), "error " ,404);

        }

    }

 
    public function show($id)
    {
        return $this->sendResponse(new projectWallet(RealEstateProject::findOrFail($id)) , " " ,200);
    }

    public function updateProject(Request $request,$id)
    {
        $data = RealEstateProject::findOrFail($id);
        if(isset($request->img)){
            $this->deleteImage(RealEstateProject::IMAGE_PATH , $data->img);
            $img = $this->aspectForResize($request->img , RealEstateProject::IMAGE_PATH, 500, 600);
            $data->update([
                'img' => $img 
            ]);

        }else{
            $data->update($request->all());
        }
        return $this->sendResponse($data, "تم التعديل" ,200);

        
    }

    public function destroy($id)
    {
        $data = RealEstateProject::findOrFail($id);
        $this->deleteImage(RealEstateProject::IMAGE_PATH , $data->img);
        $files = $data->files ;
          if($files){
            foreach($files as $file){
                $this->deleteImage( projectFile::File_PATH , $file->file);
            }
            }
        $data->delete();
        return $this->sendResponse("success", "تم الحذف" ,200);

    }

    
    public function addFile(Request $request)
    {
        $data = RealEstateProject::findOrFail($request->id);
        if($request->file){
            foreach ($request->file as $file){
                $fileName = Str::random(8) . '_' . $file->getClientOriginalName();
                $file_title = $file->getClientOriginalName();
                $fileWithoutExtension = pathinfo($file_title, PATHINFO_FILENAME);
                
                $project->files()->create([
                    'file' => $fileName,
                    'name' => $fileWithoutExtension,
                ]);
                $file->storeAs(Projectfile::File_PATH, $fileName, 'public');                                  
            }
        }
            return $this->sendResponse($data, "تم الحفظ" ,200);
       

    }


    // destroy some file in project 

    public function destroyFile($id)
    {
        $data = projectFile::findOrFail($id);
        $this->deleteImage(projectFile::File_PATH , $data->file);
        $data->delete();
        return $this->sendResponse("success", "تم الحذف" , 200);

    }

    
}
