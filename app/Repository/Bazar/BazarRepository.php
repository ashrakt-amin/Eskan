<?php

namespace App\Repository\Bazar;

use Exception;
use App\Models\Bazar;
use Illuminate\Support\Collection;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;

class BazarRepository implements BazarInterface
{
    use TraitResponseTrait, TraitImageProccessingTrait;
    public $model;

    protected $resourceCollection;

    public function __construct(Bazar $model)
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
            $percentage = 25;
            $numberOfMonths = 12;

            if ($attributes['section'] == "مطاعم") {
                $attributes['revenue'] = null;
            }elseif ($attributes['section'] == "بازار") {
                $attributes['revenue'] = FLOOR(($attributes['space'] * $attributes['meter_price'] * ($percentage / 100)) / $numberOfMonths);
            }else{
                $attributes['revenue'] = FLOOR(($attributes['space'] * $attributes['meter_price'] * .21) / 12);
            }

            $attributes['img'] = $this->aspectForResize($attributes['img'], 'Bazar', 500, 600);
            $this->model->create($attributes);
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    public function find($id): ?Bazar
    {
        return $this->model->findOrFail($id);
    }



    public function edit($attributes)
    {
        try {
            $data = $this->model->findOrFail($attributes->id);
            $percentage = 25;
            $numberOfMonths = 12;
            if ($attributes['img']) {
                $this->deleteImage(Bazar::IMAGE_PATH, $data->img);
                $img = $this->aspectForResize($attributes['img'], Bazar::IMAGE_PATH, 500, 600);
                $data->update(['img' => $img]);
            } elseif ($attributes['space'] && $data->section == "بازار") {
                $revenue = FLOOR(($attributes['space'] * $data->meter_price * ($percentage / 100)) / $numberOfMonths);
                $data->update([
                    'revenue' => $revenue,
                    'space' => $attributes['space']
                ]);
            } elseif ($attributes['meter_price']&& $data->section == "بازار") {
                $revenue = FLOOR(($data->space * $attributes['meter_price'] * ($percentage / 100)) / $numberOfMonths);
                $data->update([
                    'revenue' => $revenue,
                    'meter_price' => $attributes['meter_price']
                ]);
            } elseif ($attributes['section'] == "مطاعم") {
                $data->update([
                    'revenue' => null,
                ]);
            } else {
                 if($attributes['space']) {
                $revenue = FLOOR(($attributes['space'] * $data->meter_price * .21) / 12);
                $data->update([
                    'revenue' => $revenue,
                    'space' => $attributes['space']
                ]);
                } elseif($attributes['meter_price']){
                    $revenue = FLOOR(($attributes['meter_price'] * $data->space * .21) / 12);
                    $data->update([
                        'revenue' => $revenue,
                        'space' => $attributes['space']
                    ]);
                }else{
                    $data->update($attributes->all());
                }
            }
            return true;
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        $data = $this->model->findOrFail($id);
        $this->deleteImage(Bazar::IMAGE_PATH, $data->img);
        $data->delete();
        return true;
    }

    public function filter(array $attributes)
    {
        return function ($q) use ($attributes) {

            !array_key_exists('number', $attributes) || $attributes['number'] == 0 ?: $q
                ->where(['number' => $attributes['number']]);

            !array_key_exists('space', $attributes) || $attributes['space'] == 0   ?: $q
                ->where(['space' => $attributes['space']]);

            !array_key_exists('meter_price', $attributes) || $attributes['meter_price'] == 0   ?: $q
                ->where(['meter_price' => $attributes['meter_price']]);

            !array_key_exists('revenue', $attributes) || $attributes['revenue'] == 0   ?: $q
                ->where(['revenue' => $attributes['revenue']]);

            !array_key_exists('contract', $attributes) || $attributes['contract'] == null ?: $q
                ->where(['contract' => $attributes['contract']]);

            !array_key_exists('section', $attributes) || $attributes['section'] == null ?: $q
                ->where(['section' => $attributes['section']]);

            !array_key_exists('appear', $attributes) || $attributes['appear'] == null ?: $q
                ->where(['appear' => $attributes['appear']]);
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
            ->where($this->filter($attributes))
            ->orderByRaw('(contract)ASC');
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
