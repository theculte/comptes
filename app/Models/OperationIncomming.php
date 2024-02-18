<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class OperationIncomming extends Model
{

    public $table = 'operationIncommings';
    


    public $fillable = [
        'id_operation_type',
        'amount',
        'amount_delta'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_operation_type' => 'integer',
        'amount' => 'float',
        'amount_delta' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_operation_type' => 'integer'
    ];

    public function operationType()
    {
        return $this->hasOne('App\Models\OperationType', 'id', 'id_operation_type');
    }

}
