<?php

namespace App\Repositories;

use App\Models\OperationInc;
use InfyOm\Generator\Common\BaseRepository;

class OperationIncRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return OperationInc::class;
    }
}
