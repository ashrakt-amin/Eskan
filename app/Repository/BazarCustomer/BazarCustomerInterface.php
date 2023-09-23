<?php
namespace App\Repository\BazarCustomer;
use App\Models\BazarCustomer;
use Illuminate\Support\Collection;

interface BazarCustomerInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id);

    public function edit($id, $attributes);

    public function delete($id);

    public function forceDelete($id);

    public function forAllConditionsReturn(array $attributes, $resourceCollection);






   
}
