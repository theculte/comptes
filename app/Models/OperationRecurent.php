<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class OperationRecurent extends Model
{

    public $table = 'operationRecurents';
    


    public $fillable = [
        'title',
        'detail',
        'findme',
        'date_start',
        'every',
        'checked',
        'last_reboot',
        'amount',
        'amount_delta'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'detail' => 'string',
        'findme' => 'string',
        'every' => 'string',
        'checked' => 'boolean',
        'amount' => 'float',
        'amount_delta' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'date_start' => 'date',
        'last_reboot' => 'date',
        'amount_delta' => 'integer'
    ];
}
