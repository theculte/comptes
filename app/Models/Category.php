<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{
    use SoftDeletes;

    public $table = 'categories';
    
    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'id_parent',
        'color',
        'icon'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'id_parent' => 'integer',
        'color' => 'string',
        'icon' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'id_parent' => 'integer'
    ];

    public function parent()
    {
        return $this->hasOne('App\Models\Category', 'id', 'id_parent');
    }
    public function childs()
    {
        return $this->hasMany('App\Models\Category', 'id_parent', 'id');
    }
}
