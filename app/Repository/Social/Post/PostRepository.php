<?php

namespace App\Repository\Social\Post;

use Exception;
use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Repository\Social\Post\PostInterface;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;

class PostRepository implements PostInterface
{
    use TraitResponseTrait, TraitImageProccessingTrait;
    public $model;

    protected $resourceCollection;

    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }



    public function store($request)
    {
        $data = new Post();
        $id = Auth::user()->id;

        if (isset($request['img']) && $request['img'] != "") {
            $imgRequest = $request['img'];
            $img = time() . '_' . $imgRequest->getClientOriginalName();
            $img_title = $request['img']->getClientOriginalName();
            $imgWithoutExtension = pathinfo($img_title, PATHINFO_FILENAME);
            $imgRequest->storeAs('Social/post/', $img, 'public');
        } else {
            $img = null;
        }

        $data->user_id = $id;
        $data->title = isset($request['title']) ? $request['title'] : null;
        $data->text = isset($request['text']) ? $request['text'] : null;
        $data->img =  $img;
        $data->save();
        return $data;
    }



    public function find($id): ?Post
    {
        $data = $this->model->findOrFail($id);
        return $data;
    }



    public function edit($request, $id)
    {
        try {
            $data = $this->model->findOrFail($id);
            if (isset($request['img']) && $request['img'] != "") {
                Storage::disk('public')->delete('Social/post/' . $data->img);
                $imgRequest = $request['img'];
                $img = time() . '_' . $imgRequest->getClientOriginalName();
                $img_title = $request['img']->getClientOriginalName();
                $imgRequest->storeAs('Social/post/', $img, 'public');
                $data->update([
                    'img'  => $img
                ]);
            } else{
                $data->update($request->all());
            }
            return $data;
        } catch (Exception $e) {
            return $e;
        }
    }



    public function delete($id)
    {
        $data = $this->model->findOrFail($id);
        Storage::disk('public')->delete('Social/post/' . $data->img);
        $data->delete();
        return true;
    }

    // start paginarion 




    public function filter(array $attributes)
    {
        return function ($q) use ($attributes) {

            !array_key_exists('main_course_id', $attributes) || $attributes['main_course_id'] == 0   ?: $q
                ->where(['main_course_id' => $attributes['main_course_id']]);

            !array_key_exists('sup_course_id', $attributes) || $attributes['sup_course_id'] == 0   ?: $q
                ->where(['sup_course_id' => $attributes['sup_course_id']]);
        };
    }



    public function forAllConditionsReturn(array $attributes, $resourceCollection)
    {
        $this->resourceCollection = $resourceCollection;

        return array_key_exists('paginate', $attributes) || array_key_exists('card', $attributes)
            || array_key_exists('table', $attributes)
            ? $this->forAllConditionsPaginate($attributes, $resourceCollection)
            : $this->forAllConditionsRandom($attributes, $resourceCollection);
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



    public function forAllConditionsRandom(array $attributes, $resourceCollection)
    {
        $this->resourceCollection = $resourceCollection;

        return
            $this->sendResponse(
                $this->resourceCollection::collection($this->forAllConditions($attributes)->inRandomOrder()
                    ->limit(array_key_exists('count', $attributes) ? $attributes['count'] : "")->get()),
                "Random data; Youssof",
                200
            );
    }
}
