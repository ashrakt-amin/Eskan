<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){

        $data =[
            [
                'id'=>'1',
                'name'=>'ashrakt'
            ],
            [
                'id'=>'2',
                'name'=>'amin'
            ]
            ];

            return response()->json($data);
    }

}
