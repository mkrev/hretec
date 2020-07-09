<?php

namespace App\Services\Contents;

use App\Services\CRUDService as BaseCRUDService;
use App\Models\Contents\{Comment};
use App\Models\Contents\Parts\Like;
use App\Events\CommentAdded;

class CRUDService extends BaseCRUDService
{

    public function create($request, $user_id = null, $file = null)
    {
        return parent::create($request, $request->user()->id, $file);
    }

    public function userAll($request)
    {
        return $this->class::where('user_id', $request->user()->id)->get();
    }

    public function get($id)
    {
        return $this->class::with(['comments', 'user'])->where('id', $id)->first();
    }

    public function edit($id)
    {
        return  parent::get($id);
    }

    public function addComment($request, $id)
    {
        $model = $this->class::find($id);
        if (!$model) {
            return false;
        }
        $user = $request->user();

        $comment = $model->comments()->create(array_merge($request->all(), ['user_id' => $user->id]));
        if ($comment instanceof Comment) {
            event(new CommentAdded($comment));
            $comment->load('user');
            return $comment;
        } else return false;
    }

    public function addLike($request, $id)
    {
        $model = $this->class::find($id);
        if (!$model) {
            return false;
        }
        $is_like = $request->is_like;
        [$likes_type, $likes_other_type] = $is_like ? ['count_likes', 'count_dislikes'] : ['count_dislikes', 'count_likes'];
        $user = $request->user();
        $like = $model->likes()->where('user_id', $user->id)->first();

        if ($like instanceof Like) {
            $already_like =  $like->is_like;
            if ($already_like == $is_like) {
                $like->delete();
                $like = null;
                $model->decrement($likes_type);
                $model->save();
            } else {
                $like->is_like = $is_like;
                $like->save();
                $model->increment($likes_type);
                $model->decrement($likes_other_type);
                $model->save();
            }
        } else {
            $like = $model->likes()->create([
                'user_id' => $user->id,
                'is_like' => $is_like,
            ]);
            if (!$like instanceof Like) {
                return false;
            }
            $model->increment($likes_type, 1);
            $model->save();
        }

        //$user->load('likes');
        $model->load('user');

        //return ['likes' => $user->likes->where('likeable_type', get_class($model))->values(), 'model' => $model];
        return ['like' => $like, 'model' => $model];
    }

    public function getLike($request, $id)
    {
        $model = $this->class::find($id);
        if (!$model) {
            return false;
        }
        return $model->likes()->where('user_id', $request->user()->id)->where('')->first();
    }
}
