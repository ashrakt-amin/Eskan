<?php

namespace App\Repository\Social\Comment;

use App\Models\Comment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Repository\Social\Comment\CommentInterface;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use App\Http\Traits\ImageProccessingTrait as TraitImageProccessingTrait;
use App\Events\CommentNotification;

class CommentRepository implements CommentInterface
{
    use TraitResponseTrait, TraitImageProccessingTrait;
    public $model;

    protected $resourceCollection;

    public function __construct(Comment $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }



    public function store($request)
    {
       
        $data = new Comment();
        if ($request->number) {
            $token = \Laravel\Sanctum\PersonalAccessToken::findToken($request->number);
            $user = $token->tokenable;
            $data->user_id = $user->id;
        }else{
            $data->user_id =NULL;
        }
        $data->comment = $request['comment'];
        $data->post_id = $request['post_id'];
        $data->comment_id=  isset($request['comment_id']) ? $request['comment_id'] : null ;
        $data->save();

        // $notification = [
        //     //'title' => "ggg",
        //     'comment_id' =>$data->id,
        //     'user_id' => $data->user_id ,

        // ];
        // event(new CommentNotification($notification));

        return $data; 
    }



    public function find($id): ?Comment
    {
        $data = $this->model->findOrFail($id);
        return $data;
    }

    public function edit($request, $id)
    {
        $data = $this->model->findOrFail($id);
        $data->update($request->all());
        return $data;
    }



    public function delete($id)
    {
        $data = $this->model->findOrFail($id);
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
