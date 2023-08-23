<?php

namespace App\Repository\Wallet;

use App\Models\Wallet;
use Illuminate\Support\Collection;

interface WalletInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id): ?Wallet;

    public function edit($id, $attributes):? Wallet;

    public function delete($id);

    public function forceDelete($id);
    
    public function forAllConditionsReturn(array $attributes, $resourceCollection);






   
}
