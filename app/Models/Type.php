<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Type extends Model
{

    public $table = 'types';
    


    public $fillable = [
        'title',
        'findme',
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'findme' => 'string',
        'image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required'
    ];
}
