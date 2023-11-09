<?php

namespace App\Repository\ParkUser;

use App\Models\Parkuser;
use Illuminate\Support\Collection;

interface ParkUserInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id);

    public function edit($id, $attributes):?Parkuser;


    public function delete($id);

    public function forceDelete($id);
    public function restore($id);


    public function forAllConditionsReturn(array $attributes, $resourceCollection);






   
}
