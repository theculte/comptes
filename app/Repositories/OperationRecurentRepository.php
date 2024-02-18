<?php

namespace App\Repositories;

use App\Models\OperationRecurent;
use InfyOm\Generator\Common\BaseRepository;

class OperationRecurentRepository extends BaseRepository
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
        return OperationRecurent::class;
    }
}
