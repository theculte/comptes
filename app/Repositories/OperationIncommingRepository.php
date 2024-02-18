<?php

namespace App\Repositories;

use App\Models\OperationIncomming;
use InfyOm\Generator\Common\BaseRepository;

class OperationIncommingRepository extends BaseRepository
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
        return OperationIncomming::class;
    }
}
