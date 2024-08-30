<?php


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Operation;
use App\Models\Type;
use App\Models\OperationType;
use App\Models\OperationInc;
use Carbon\Carbon;

class OperationResource extends JsonResource
{

    protected $operation;

    public function __construct(Operation $operation)
    {
	$this->operation = $operation;
    }

    public static function parseIncommings()
    {
        $incs = OperationInc::where('period', 'none')->get();

        foreach ($incs as $inc) {
		
		$date = Carbon::createFromFormat('Y-m-d', $inc->date);	
		$operations = Operation::where('date', '>=', $date->subDays(15)->toDateTimeString())
				->where('date', '<=', $date->addDays(30)->toDateTimeString())
				->where('checked', 0)
				->where('amount', '>=',$inc->amount - (($inc->amount/100) * $inc->delta))
				->where('amount', '<=',$inc->amount + (($inc->amount/100) * $inc->delta))
				->get();
                foreach ($operations as $operation) {
			$delete = false;
			if ($inc->id_operation_type > 0 && $inc->id_operation_type == $operation->operation_type) {
				$delete = true;
			} else if (strpos(strtolower($operation->detail), strtolower($inc->name) . ' ') !== false) {
				$delete = true;
			}

			if ($delete == true) {
				$inc->delete();
				$operation->checked = 1;
				$operation->save();
				break;
			}
                }
        }

	// pointage des recurrents
	$incs = OperationInc::where('period', '!=', 'none')->get();
	
	foreach ($incs as $inc) {
		
		$date = Carbon::createFromFormat('Y-m-d', $inc->date);
                $operations = Operation::whereBetween('date', [$date->subDays(15)->toDateTimeString(), $date->addDays(30)->toDateTimeString()])
                                ->where('checked', 0)
                                ->whereBetween('amount', [$inc->amount - (($inc->amount/100) * $inc->delta), $inc->amount + (($inc->amount/100) * $inc->delta)])
                                ->get();
		foreach ($operations as $operation) {

                        if ($inc->id_operation_type > 0 && $inc->id_operation_type == $operation->operation_type) {
                                if ($inc->period == 'month') {
					$inc->date = Carbon::createFromFormat('Y-m-d', $inc->date)->addMonth()->toDateTimeString();
				} else if ($inc->period == 'year') {
                                	$inc->date = Carbon::createFromFormat('Y-m-d', $inc->date)->addYear()->toDateTimeString();
				}
				$inc->save();
                                $operation->checked = 1;
                                $operation->save();

                                break;
                        }
                }

	}

    }

    public static function parseNewOperations()
    {

	$operations = Operation::where('type_id', 0)->get();
	$types = Type::all();
	foreach ($operations as $operation) {

		foreach ($types as $type) {
			
			if (strpos(strval($operation->detail), strval($type->findme)) !== false) {
				$operation->type_id = $type->id;
				break;
			}
		}
		$operation->save();
	}

	$operations = Operation::where('operation_type', 0)->get();
        $types = OperationType::all();
        foreach ($operations as $operation) {

		foreach ($types as $type) {
			if (strlen($type->findme)){
                        if (strpos(strval($operation->detail), strval($type->findme)) !== false) {
                                $operation->operation_type = $type->id;
                                break;
                        }
                        }
                }
                $operation->save();
        }	
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
