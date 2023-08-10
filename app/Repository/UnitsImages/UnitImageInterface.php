<?php

namespace App\Repository\UnitsImages;


use Illuminate\Support\Collection;
use App\Models\Unit;
use App\Models\UnitsImage;

interface UnitImageInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id):?UnitsImage;

    public function edit($attributes);

    public function delete($id);

    public function forAllConditionsReturn(array $attributes, $resourceCollection);






   
}
