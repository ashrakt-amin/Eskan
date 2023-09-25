<?php

namespace App\Repository\Job;


use Illuminate\Support\Collection;
use App\Models\Job;

interface JobInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id):?Job;

    public function edit($id,$attributes);

    public function delete($id);

    public function forAllConditionsReturn(array $attributes, $resourceCollection);






   
}
