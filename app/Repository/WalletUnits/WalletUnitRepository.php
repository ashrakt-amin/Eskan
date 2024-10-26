<?php

namespace App\Repository\WalletUnits;

use Exception;
use App\Models\Walletunit;
use Illuminate\Support\Collection;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;

class WalletUnitRepository implements WalletUnitInterface
{
    use TraitResponseTrait, TraitImageProccessingTrait;
    public $model;

    protected $resourceCollection;

    public function __construct(Walletunit $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }


    public function store(array $attributes)
    {
        try {
            $attributes['img'] = $this->aspectForResize($attributes['img'],Walletunit::IMAGE_PATH, 500, 600);
            $data = $this->model->create($attributes);
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    public function find($id): ?Walletunit
    {
        return $this->model->findOrFail($id);
    }



    public function edit($id,$attributes)
    {
        try {
            $unit = $this->model->findOrFail($id);
            if ($attributes['img']) {
                $this->deleteImage(Walletunit::IMAGE_PATH, $unit->img);
                $img = $this->aspectForResize($attributes['img'],Walletunit::IMAGE_PATH, 500, 600);
                $unit->update([
                    'img'=>$img
                ]);
                return $unit;

            } else{
            $unit->update($attributes->all());
            return $unit;
            }
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        $unit = $this->model->findOrFail($id);
        $this->deleteImage(Walletunit::IMAGE_PATH, $unit->img);
        $unit->delete();
        return true;
    }



    public function filter(array $attributes)
    {
        return function ($q) use ($attributes) {

            !array_key_exists('project_id', $attributes) || $attributes['project_id'] == 0   ?: $q
                ->where(['project_id' => $attributes['project_id']]);

            !array_key_exists('number', $attributes) || $attributes['number'] == 0   ?: $q
                ->where(['number' => $attributes['number']]);

            !array_key_exists('type_id', $attributes) || $attributes['type_id'] == 0   ?: $q
                ->where(['type_id' => $attributes['type_id']]);

            !array_key_exists('space', $attributes) || $attributes['space'] == 0   ?: $q
                ->where(['space' => $attributes['space']]);

            !array_key_exists('level_id', $attributes) || $attributes['level_id'] == 0   ?: $q
                ->where(['level_id' => $attributes['level_id']]);

            !array_key_exists('meter_price', $attributes) || $attributes['meter_price'] == 0   ?: $q
                ->where(['meter_price' => $attributes['meter_price']]);

            !array_key_exists('contract', $attributes) ?: $q
                ->where('contract', '<>', null);
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
