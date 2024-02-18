<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Solde extends Model
{

    public $table = 'soldes';
    


    public $fillable = [
        'amount',
        'date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'date' => 'date'
    ];
}
