<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class OperationInc extends Model
{

    public $table = 'Operationincs';
    


    public $fillable = [
        'id_operation_type',
        'name',
        'date',
        'amount',
        'id_category',
        'period'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_operation_type' => 'integer',
        'id_category' => 'integer',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_operation_type' => 'integer',
        'id_category' => 'integer',
        'date' => 'date',
        'amount' => 'required'
    ];

    public function operationType()
    {
        return $this->hasOne('App\Models\OperationType', 'id', 'id_operation_type');
    }

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'id_category');
    }
}
