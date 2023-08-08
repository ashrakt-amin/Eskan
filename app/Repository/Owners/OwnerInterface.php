<?php

namespace App\Repository\Owners;
use App\Models\Owner;
use Illuminate\Support\Collection;

interface OwnerInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id):?Owner;

    public function delete($id);

    public function forceDelete($id);

    public function forAllConditionsReturn(array $attributes, $resourceCollection);

  




   
}
