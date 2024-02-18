<?php

namespace App\Repositories;

use App\Models\OperationType;
use InfyOm\Generator\Common\BaseRepository;

class OperationTypeRepository extends BaseRepository
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
        return OperationType::class;
    }
}
