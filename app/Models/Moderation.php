<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moderation extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_moderation',
        'id_comment_fk',
        'id_moderator_fk',
        'status',
        'motif'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public $timestamps = false;
}
