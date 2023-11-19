<?php

namespace App\Repository\Units;


use Illuminate\Support\Collection;
use App\Models\Unit;

interface UnitInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id):?Unit;

    public function edit($attributes);

    public function storeImages($attributes);

    public function deleteImageUnit($id);

    public function delete($id);

    public function forAllConditionsReturn(array $attributes, $resourceCollection);

    public function forFilterlevel(array $attributes);







   
}
