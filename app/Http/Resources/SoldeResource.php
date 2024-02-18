<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\OperationInc;
//use App\Models\OperationInc;

class SoldeResource extends JsonResource
{


    public function getIncommingSolde()
    {
	return $this->amount + 999999;

    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
     // return parent::toArray($request);

	return [
            'id' => $this->id,
            'amount' => $this->name,
            'date' => $this->email,
            'incommingSolde' => 3,
            //'incommingSolde' => $this->getIncommingSolde(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
