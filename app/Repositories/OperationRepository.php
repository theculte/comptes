<?php

namespace App\Repositories;

use App\Models\Operation;
use InfyOm\Generator\Common\BaseRepository;

class OperationRepository extends BaseRepository
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
        return Operation::class;
    }
}
