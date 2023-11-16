<?php

namespace App\Repository\Project;


use Illuminate\Support\Collection;
use App\Models\Project;

interface ProjectInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id):?Project;

    public function edit($id, $attributes):?Project;

    public function editImage($id, $attributes);

    public function delete($id);

    public function delete_Image($id);

    
    





   
}
