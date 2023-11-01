<?php
namespace App\Repository\UserWallet;
use App\Models\Userwallet;
use Illuminate\Support\Collection;

interface UserWalletInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id);

    public function edit($id, $attributes);

    public function delete($id);

    public function forceDelete($id);

    public function forAllConditionsReturn(array $attributes, $resourceCollection);






   
}
