<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Operation extends Model
{

    public $table = 'operations';
    


    public $fillable = [
        'date',
        'title',
        'detail',
        'amount',
        'currency',
        'checked'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'detail' => 'string',
        'amount' => 'float',
        'currency' => 'string',
        'checked' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'date' => 'date',
        'title' => 'required',
        'amount' => 'required',
        'currency' => 'required',
        'checked' => 'boolean'
    ];

    public function type()
    {
        return $this->hasOne('App\Models\Type', 'id', 'type_id');
    }

    public function operationType()
    {
        return $this->hasOne('App\Models\OperationType', 'id', 'operation_type');
    }

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'id_category');
    }
}
