<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class OperationType extends Model
{

    public $table = 'operationTypes';
    


    public $fillable = [
        'name',
        'id_category',
        'findme',
        'icon',
        'tags'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'id_category' => 'integer',
        'findme' => 'string',
        'icon' => 'string',
        'tags' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'id_category' => 'integer'
    ];

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'id_category');
    }
}
