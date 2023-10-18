<?php

namespace App\Repository\Social\Post;


use Illuminate\Support\Collection;
use App\Models\Post;

interface  PostInterface
{
    public function all(): Collection;

    public function store($request);

    public function find($id):?Post;

    public function edit($attributes ,$id);

    public function delete($id);

    public function forAllConditionsReturn(array $attributes, $resourceCollection);


    





   
}
