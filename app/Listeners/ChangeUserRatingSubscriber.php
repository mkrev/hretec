<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\CommentAdded;
use App\Models\Quest;

class ChangeUserRatingSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handleComments($event)
    {
        $user = request()->user();
        $comment = $event->comment;
        $commentable = $comment->commentable;
        $author = $commentable->user;
        if ($user->id == $author->id) {
            return false;
        }
        $amount = $commentable->comments->count();
        $quests = $author->quests;
        $questsName = $quests->pluck('key');


        $questCompleted = false;

        if ($amount == 1 && !$questsName->contains('first_comment')) {
            $questCompleted = 'first_comment';
        } else if ($amount == 100 && !$questsName->contains('hundredth_comment')) {
            $questCompleted = 'hundredth_comment';
        } else if ($amount == 1000 && !$questsName->contains('thousandth_comment')) {
            $questCompleted = 'thousandth_comment';
        }

        if ($questCompleted !== false) {
            $quest = Quest::where('key', $questCompleted)->first();
            $author->quests()->attach($quest->id);
            $author->increment('rating', $quest->points);
            $author->save();
            return true;
        }

        return false;
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            CommentAdded::class,
            'App\Listeners\ChangeUserRatingSubscriber@handleComments'
        );
    }
}
