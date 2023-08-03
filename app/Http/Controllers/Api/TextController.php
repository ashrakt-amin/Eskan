<?php

namespace App\Http\Controllers\Api;

use App\Models\Text;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TextResource;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;

class TextController extends Controller
{
    use TraitResponseTrait ;

    public function index()
    {
        $text = Text::all();
        return $this->sendResponse(TextResource::collection($text), "all text", 200);


    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description'  => 'required'
        ]);

        $data = Text::create([
            'name' => $request->name,
            'description'  =>  $request->description
        ]);
        return $this->sendResponse($data, "success", 200);
    }

    public function show($name)
    {
        $data = Text::where('name',$name)->get();
        return $this->sendResponse(TextResource::collection($data), "success", 200);
    }

    public function update(Request $request ,$id)
    {
        $data = Text::findOrFail($id);
        $request->validate([
            'description'         => 'required'
        ]);
        $data->update([
            'description'  =>  $request->description
        ]);

        return $this->sendResponse($data, "update", 200);
    }


    public function destroy($id)
    {
        $data = Text::findOrFail($id);
        $data->delete();
        return $this->sendResponse('', "delete", 200);

    }
}
