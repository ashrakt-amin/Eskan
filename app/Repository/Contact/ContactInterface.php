<?php

namespace App\Repository\Contact;

use App\Models\ContactUs;
use Illuminate\Support\Collection;

interface ContactInterface
{
    public function all(): Collection;

    public function store(array $attributes);

    public function find($id): ?ContactUs;

    public function delete($id);

    public function forceDelete($id);
    
    public function forAllConditionsReturn(array $attributes, $resourceCollection);






   
}
