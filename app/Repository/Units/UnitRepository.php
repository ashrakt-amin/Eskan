<?php

namespace App\Repository\Units;

use Exception;
use App\Models\Unit;
use App\Models\UnitImage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;

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
            $attributes['advance'] = $attributes['space'] * $attributes['meter_price'] * ($attributes['advance_rate'] / 100);
            $data = $this->model->create($attributes);
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function storeCommerical(array $attributes)
    {
        try {

            $attributes['img'] = $this->setImageWithoutsize($attributes['img'], 'Units');
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



    public function edit($attributes)
    {
        try {
            $unit = $this->model->findOrFail($attributes->id);
            if ($attributes['advance_rate']) {
                $advance = $unit->space * $unit->meter_price * ($attributes['advance_rate'] / 100);
                $attributes['advance'] = $advance;
            } elseif ($attributes['space']) {
                $advance = $attributes['space'] * $unit->meter_price * ($unit->advance_rate / 100);
                $attributes['advance'] = $advance;
            } elseif ($attributes['meter_price']) {
                $advance = $unit->space * $attributes['meter_price'] * ($unit->advance_rate / 100);
                $attributes['advance'] = $advance;
            }

            $unit->update($attributes->all());
            return $unit;
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function editCommercial($attributes)
    {
        try {
            $unit = $this->model->findOrFail($attributes->id);
            if ($attributes['img']) {
               $this->deleteImage('Units', $unit->img);
                $img = $this->aspectForResize($attributes['img'], 'Units', 500, 600);
                $unit->update(['img'=>$img]);

            }else{
                $unit->update($attributes->all());

            }
            return $unit;
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }


    public function delete($id)
    {
        $user = Auth::user();
        $unit = $this->model->findOrFail($id);
        // if ($unit->unitImages != null) {
        //     foreach ($unit->unitImages as $img) {
        //         $this->deleteImage('Units', $img->img);
        //     }
        //     $unit->unitImages()->delete();
        // }

        $user = ['name' => $user->name, 'phone' => $user->phone];
        $data = ['unit number' => $unit->number];
        $log_data = ['The user who deleted the unit' => $user, 'The unit ' => $data];
        Log::channel('unit')->info('unit', $log_data);

        $unit->delete();
        return true;
    }



    public function deleteImageUnit($id)
    {
        $image = UnitImage::find($id);
        $this->deleteImage('Units', $image->img);
        $image->delete();
        return true;
    }


    public function storeImages($attributes)
    {

        $unit = $this->model->findOrFail($attributes->id);
        $unit->unitImages()->createMany($this->aspectForResizeImages($attributes['img'], 'Units', 'img', 600, 600));
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

            !array_key_exists('block_id', $attributes) || $attributes['block_id'] == 0   ?: $q
                ->where(['block_id' => $attributes['block_id']]);

            !array_key_exists('appear', $attributes)?: $q
                ->where(['appear' => $attributes['appear']]);

                $type =$attributes['type'];
            !array_key_exists('type', $attributes)?: $q
            ->whereHas('type', function ($query) use ($type) {
                $query->where('name', $type);
            });

            // !array_key_exists('commercial', $attributes) ?: $q
            //     ->where(['type_id' => 2]);
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

    public function forFilterlevel(array $attributes)
    {
        // $this->resourceCollection = $resourceCollection;

        return array_key_exists('paginate', $attributes) ? $this->forAllConditions($attributes) : NULL;
    }
}
