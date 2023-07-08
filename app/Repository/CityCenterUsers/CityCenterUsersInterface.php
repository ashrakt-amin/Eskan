<?php

namespace App\Repository\CityCenterUsers;

use Illuminate\Support\Collection;

interface CityCenterUsersInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id);

    public function delete($id);

    public function forAllConditionsReturn(array $attributes, $resourceCollection);






   
}
