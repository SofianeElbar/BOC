<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    static function translateIntoObject($array)
    {
        $result = [];

        foreach ($array as $key => $comment) {
            $subresult = [];

            $subresult['id'] = $comment->id_comment;
            $subresult['title'] = $comment->title;
            $subresult['content'] = $comment->content;
            $subresult['created_at'] = $comment->created_at;

            $subresult['subscriber'] = ["id" => $comment->id_subscriber, "email" => $comment->email, "pseudo" => $comment->pseudo, "id_kinow" => $comment->id_kinow];

            $subresult['film'] = ["id" => $comment->id_film, "title" => $comment->film_title];

            $subresult['moderation'] = ["id" => $comment->id_moderation, "status" => $comment->status, "reason" => $comment->motif];

            $result[] = $subresult;
        }

        return $result;
    }
}
