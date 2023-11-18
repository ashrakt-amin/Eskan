<?php

namespace App\Repository\Reservation;

use App\Models\Reservation;
use Illuminate\Support\Collection;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Jobs\SendEmailJob;


class ReservationRepository implements ReservationInterface
{
    use TraitResponseTrait;
    public $model;

    protected $resourceCollection;

    public function __construct(Reservation $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }


    public function store(array $attributes)
    {
        $data = $this->model->create($attributes);
        $mailData = [
            'title' => 'Dear ziad',
            'name' => 'new reservation from ' . $attributes['name'],
            'phone' => ' phone : ' . $attributes['phone'],
            'job' => 'job : ' . $attributes['job'],
            'unit' => 'unit numer : ' . $data->unit->number,
            'project' => 'project name : ' . $data->project->name,
        ];
        SendEmailJob::dispatch($mailData);
        return $data;
    }



    public function find($id): ?Reservation
    {
        return $this->model->findOrFail($id);
    }

    public function edit($id,  $attributes): ?Reservation
    {
        $data = $this->model->findOrFail($id);
        if ($attributes['feedback'] != null) {
            $data->update([
                'feedback' => $attributes['feedback']
            ]);
        }
        return $data;
    }


    public function delete($id)
    {
        return  $this->model::findOrFail($id)->delete();
    }



    public function forceDelete($id)
    {
        $data = $this->model->onlyTrashed()->findOrFail($id);
        $data->forceDelete();
        return true;
    }


    public function filter(array $attributes)
    {
        return function ($q) use ($attributes) {

            !array_key_exists('project_id', $attributes) || $attributes['project_id'] == 0   ?: $q
                ->where(['project_id' => $attributes['project_id']]);

            !array_key_exists('unit_id', $attributes) || $attributes['unit_id'] == 0   ?: $q
                ->where(['unit_id' => $attributes['unit_id']]);
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

        return array_key_exists('paginate', $attributes) || array_key_exists('elbadry', $attributes)
            || array_key_exists('elmadina', $attributes) || array_key_exists('status', $attributes)
            ? $this->forAllConditionsPaginate($attributes, $resourceCollection)
            : (array_key_exists('latest', $attributes) ? $this->forAllConditionsLatest($attributes, $resourceCollection)
                : $this->forAllConditionsRandom($attributes, $resourceCollection));
    }
}
