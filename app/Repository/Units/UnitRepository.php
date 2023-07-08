<?php

namespace App\Repository\Units;

use App\Models\Unit;
use Illuminate\Support\Collection;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;
use Exception;

class UnitRepository implements UnitInterface
{
    use TraitResponseTrait, TraitImageProccessingTrait;
    public $model;

    protected $resourceCollection;

    public function __construct(Unit $model)
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
            $attributes['img'] = $this->aspectForResize($attributes['img'], 'Units', 500, 600);
            $data = $this->model->create($attributes);
            return $data;
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }



    public function find($id): ?Unit
    {
        return $this->model->findOrFail($id);
    }



    public function edit($id, $attributes): ?Unit
    {
        $unit = $this->model->findOrFail($id);
        $data = $attributes->except('img');
        if ($attributes->hasFile('img') && $attributes->img != "") {
            $this->deleteImage(Unit::IMAGE_PATH, $unit->img);
            $data['img'] = $this->aspectForResize($attributes->img, 'Units', 500, 600);
        }
        $unit->update($data);
        return $unit;
    }


    public function delete($id)
    {
        $unit = $this->model::findOrFail($id);
        if ($unit->img) {
            $this->deleteImage(Unit::IMAGE_PATH, $unit->img);
        }
        $unit->delete();
    }


    public function filter(array $attributes)
    {
        return function ($q) use ($attributes) {

            !array_key_exists('project_id', $attributes) || $attributes['project_id'] == 0   ?: $q
                ->where(['project_id' => $attributes['project_id']]);

            !array_key_exists('type_id', $attributes) || $attributes['type_id'] == 0   ?: $q
                ->where(['type_id' => $attributes['type_id']]);

            !array_key_exists('space', $attributes) || $attributes['space'] == 0   ?: $q
                ->where(['space' => $attributes['space']]);

            !array_key_exists('level_id', $attributes) || $attributes['level_id'] == 0   ?: $q
                ->where(['level_id' => $attributes['level_id']]);
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

        return array_key_exists('paginate', $attributes) || array_key_exists('card', $attributes)
            || array_key_exists('table', $attributes) || array_key_exists('status', $attributes)
            ? $this->forAllConditionsPaginate($attributes, $resourceCollection)
            : (array_key_exists('latest', $attributes) ? $this->forAllConditionsLatest($attributes, $resourceCollection)
                : $this->forAllConditionsRandom($attributes, $resourceCollection));
    }
}
