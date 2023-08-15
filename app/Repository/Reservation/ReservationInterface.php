<?php

namespace App\Repository\Reservation;

use App\Models\Reservation;
use Illuminate\Support\Collection;

interface ReservationInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id): ?Reservation;

    public function edit($id, $attributes):? Reservation;

    public function delete($id);

    public function forceDelete($id);
    
    public function forAllConditionsReturn(array $attributes, $resourceCollection);






   
}
