<?php

namespace App\Repository\User;


use Illuminate\Support\Collection;
use App\Models\User;

interface UserInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id);

    public function edit($id,$attributes);

    public function delete($id);

    public function forAllConditionsReturn(array $attributes, $resourceCollection);






   
}
