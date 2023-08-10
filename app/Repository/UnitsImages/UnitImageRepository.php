<?php

namespace App\Repository\UnitsImages;

use Illuminate\Support\Collection;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;
use App\Models\UnitsImage;


class UnitImageRepository implements UnitImageInterface
{
    use TraitResponseTrait, TraitImageProccessingTrait;
    public $model;

    protected $resourceCollection;

    public function __construct(UnitsImage $model)
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
            $unit_img = $this->aspectForResize($attributes['unit_img'], UnitsImage::Unit_PATH, 500, 600);
            $block_img = $this->aspectForResize($attributes['block_img'], UnitsImage::Block_PATH, 500, 600);
            $data =  $this->model->create([
                'unit_img' =>  $unit_img,
                'block_img' =>  $block_img,
            ]);
                return true;
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    public function find($id): ?UnitsImage
    {
        return $this->model->findOrFail($id);
    }



    public function edit($attributes)
    {
        try {
            $data = $this->model->findOrFail($attributes->id);
            if ($attributes['unit_img'] != null) {
                $this->deleteImage(UnitsImage::Unit_PATH, $data->unit_img);
                $unit_img = $this->aspectForResize($attributes['unit_img'], UnitsImage::Unit_PATH, 500, 600);
                $data->update(['unit_img' => $unit_img]);
            } elseif ($attributes['block_img']) {
                $this->deleteImage(UnitsImage::Block_PATH, $data->block_img);
                $block_img = $this->aspectForResize($attributes['block_img'], UnitsImage::Block_PATH, 500, 600);
                $data->update(['block_img' => $block_img]);
            }

            return $data;
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        $data = $this->model->findOrFail($id);
        $this->deleteImage(UnitsImage::Unit_PATH, $data->unit_img);
        $this->deleteImage(UnitsImage::Block_PATH, $data->block_img);
        $data->delete();
        return true;
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
            ->where($this->theLatest($attributes));
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
