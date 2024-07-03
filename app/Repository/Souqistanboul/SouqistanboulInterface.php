<?php

namespace App\Repository\Souqistanboul;
use Illuminate\Support\Collection;

interface SouqistanboulInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function edit($id, $attributes);

    public function delete($id);

    public function forAllConditionsReturn(array $attributes, $resourceCollection);






   
}
