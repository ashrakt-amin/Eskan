<?php

namespace App\Repository\Social\Comment;


use Illuminate\Support\Collection;
use App\Models\Comment;

interface  CommentInterface
{
    public function all(): Collection;

    public function store($request);

    public function find($id):?Comment;

    public function edit($attributes ,$id);

    public function delete($id);

    public function forAllConditionsReturn(array $attributes, $resourceCollection);


    





   
}
