<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class nameTest extends TestCase
{
   
    public function test_example(): void
    {
        $response = $this->get('/test');
        $data = $response->json();
        $myData = [
                [
                    'id'=>'1',
                    'name'=>'ashrakt'
                ],
                [
                    'id'=>'2',
                    'name'=>'amin'
                ]
                ];
        //$response->assertJson();
        // $this->assertEquals($myData , $data);       
         $this->assertEquals(count($myData) , count($data));


       // dd($data);
        //dd($response->json()['message']);
    }
}
