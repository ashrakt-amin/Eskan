<?php

namespace App\Repository\SellProject;


use Illuminate\Support\Collection;
use App\Models\Sellproject;

interface SellProjectInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id):?Sellproject;

    public function edit($attributes ,$id):?Sellproject;


    public function delete($id);


    
    





   
}
