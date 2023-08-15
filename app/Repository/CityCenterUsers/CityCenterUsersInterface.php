<?php

namespace App\Repository\CityCenterUsers;

use App\Models\CityCenterUsers;
use Illuminate\Support\Collection;

interface CityCenterUsersInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id);

    public function edit($id, $attributes):?CityCenterUsers;


    public function delete($id);

    public function forceDelete($id);

    public function forAllConditionsReturn(array $attributes, $resourceCollection);






   
}
