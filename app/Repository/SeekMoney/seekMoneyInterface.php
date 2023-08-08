<?php

namespace App\Repository\SeekMoney;

use Illuminate\Support\Collection;

interface seekMoneyInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id);

    public function delete($id);

    public function forceDelete($id);

    public function forAllConditionsReturn(array $attributes, $resourceCollection);






   
}
