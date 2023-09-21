<?php

namespace App\Repository\Bazar;


use Illuminate\Support\Collection;
use App\Models\Bazar;

interface BazarInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id):?Bazar;

    public function edit($attributes);

    public function delete($id);

    public function forAllConditionsReturn(array $attributes, $resourceCollection);






   
}
