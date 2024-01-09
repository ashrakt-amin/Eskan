<?php

namespace App\Repository\User;

use Exception;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;

class UserRepository implements UserInterface
{
    use TraitResponseTrait, TraitImageProccessingTrait;
    public $model;

    protected $resourceCollection;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }


    public function store(array $request)
    {
        $data =  $this->model->create([
            'name'      => $request['name'],
            'phone'     => $request['phone'],
            'password'  => bcrypt($request['password']),
        ]);

        return $data;
    }


    public function find($id)
    {
    }

    public function edit($id, $request)
    {
        try {
            $data = User::findOrFail($id);
            if (isset($request->password)) {
                $data->update([
                    'password'  => bcrypt($request['password']),
                ]);
                return $data;
            } else {
                $data->update($request);
                return $data;
            }
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
        return true;
    }
    public function filter(array $attributes)
    {
        return function ($q) use ($attributes) {
            !array_key_exists('sells', $attributes) ?: $q
                ->where(['role' => 'مسؤل مبيعات']);
        };
    }



    public function theLatest(array $attributes)
    {
        return function ($q) use ($attributes) {
            !array_key_exists('latest', $attributes) ?: $q
                ->latest();
        };
    }



    public function forAllConditions(array $attributes)
    {
        return $this->model
            ->where($this->theLatest($attributes))
            ->where($this->filter($attributes));
    }


    public function forAllConditionsPaginate(array $attributes, $resourceCollection)
    {
        $this->resourceCollection = $resourceCollection;

        return
            $this->paginateResponse(
                $this->resourceCollection::collection($this->forAllConditions($attributes)
                    ->paginate(array_key_exists('count', $attributes) ? $attributes['count'] : "")),
                $this->forAllConditions($attributes)->paginate(array_key_exists('count', $attributes) ? $attributes['count'] : ""),
                "paginate data; Youssof",
                200
            );
    }


    public function forAllConditionsLatest(array $attributes, $resourceCollection)
    {
        $this->resourceCollection = $resourceCollection;

        return
            $this->paginateResponse(
                $this->resourceCollection::collection($this->forAllConditions($attributes)
                    ->latest()->limit(array_key_exists('limit', $attributes) ? $attributes['limit'] : "")
                    ->paginate(array_key_exists('count', $attributes) ? $attributes['count'] : "")),
                $this->forAllConditions($attributes)->latest()->limit(array_key_exists('limit', $attributes) ? $attributes['limit'] : "")
                    ->paginate(array_key_exists('count', $attributes) ? $attributes['count'] : ""),
                "Latest data; Youssof",
                200
            );
    }



    public function forAllConditionsRandom(array $attributes, $resourceCollection)
    {
        $this->resourceCollection = $resourceCollection;

        return
            $this->sendResponse(
                $this->resourceCollection::collection($this->forAllConditions($attributes)->inRandomOrder()->limit(array_key_exists('count', $attributes) ? $attributes['count'] : "")->get()),
                "Random data; Youssof",
                200
            );
    }



    public function forAllConditionsReturn(array $attributes, $resourceCollection)
    {
        $this->resourceCollection = $resourceCollection;

        return array_key_exists('paginate', $attributes) || array_key_exists('card', $attributes) ||
            array_key_exists('table', $attributes) || array_key_exists('status', $attributes)
            ? $this->forAllConditionsPaginate($attributes, $resourceCollection)
            : (array_key_exists('latest', $attributes) ? $this->forAllConditionsLatest($attributes, $resourceCollection)
                : $this->forAllConditionsRandom($attributes, $resourceCollection));
    }
}
