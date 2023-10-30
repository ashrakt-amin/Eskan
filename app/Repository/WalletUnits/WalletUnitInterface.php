<?php

namespace App\Repository\WalletUnits;


use Illuminate\Support\Collection;
use App\Models\Walletunit;

interface WalletUnitInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id):?Walletunit;

    public function edit($attributes);

    public function storeImages($attributes);

    public function deleteImageUnit($id);

    public function delete($id);

    public function forAllConditionsReturn(array $attributes, $resourceCollection);






   
}
