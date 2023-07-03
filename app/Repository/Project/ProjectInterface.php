<?php

namespace App\Repository\Project;


use Illuminate\Support\Collection;
use App\Models\Project;

interface ProjectInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id):?Project;

    public function edit($id, array $attributes):?Project;

    public function delete($id);

    





   
}
