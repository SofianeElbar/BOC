<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Comment;
use App\Models\Subscriber;
use App\Models\Film;
use App\Models\Moderation;

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

    static function translateIntoArrayofObjects($array)
    {
        $result = [];

        foreach ($array as $key => $data) {
            $resultObject = new Comment();

            $resultObject->id = $data->id_comment;
            $resultObject->title = $data->title;
            $resultObject->content = $data->content;
            $resultObject->created_at = $data->created_at;

            $subscriber = new Subscriber();
            $subscriber->id = $data->id_subscriber;
            $subscriber->id_kinow = $data->id_kinow;
            $subscriber->email = $data->email;
            $subscriber->pseudo = $data->pseudo;
            $resultObject->subscriber = $subscriber;

            $film = new Film();
            $film->id = $data->id_film;
            $film->title = $data->film_title;
            $resultObject->film = $film;

            $moderation = new Moderation();
            $moderation->id = $data->id_moderation;
            $moderation->status = $data->status;
            $moderation->reason = $data->motif;
            $resultObject->moderation = $moderation;

            $result[] = $resultObject;
        }

        return $result;
    }
}
