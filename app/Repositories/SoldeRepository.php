<?php

namespace App\Repositories;

use App\Models\Solde;
use InfyOm\Generator\Common\BaseRepository;

class SoldeRepository extends BaseRepository
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
        return Solde::class;
    }
}
