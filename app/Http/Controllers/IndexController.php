<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Operation;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Resources\OperationResource;
use App\Http\Resources\SoldeResource;
use App\Http\Requests;
use App\Http\Requests\CreateOperationIncRequest;
use App\Models\OperationInc;
use Flash;
use App\Repositories\OperationIncRepository;
use Carbon\Carbon;
use App\Models\File;
use App\Http\Requests\FileUploadRequest;
use Illuminate\Support\Facades\URL;
use Response;
use stdClass;
use Charts;
use OperationsSeeder;
use App\Models\Solde;
use App\Models\Category;
use App\Models\OperationIncomming;
use App\Models\OperationType;


class IndexController extends Controller
{
    /** @var  OperationIncRepository */
    private $operationIncRepository;

    public function __construct(OperationIncRepository $operationIncRepo)
    {
        $this->operationIncRepository = $operationIncRepo;
    }

 public function home()
    {
        OperationResource::parseNewOperations();
        OperationResource::parseIncommings();

	$solde = Solde::find(1);
	$incommingSolde = array();

	$date = Carbon::createFromFormat('Y-m-d H:i:s', $solde->updated_at);

	$dates = array();
	$soldes = array();


	for ($i=0;$i<31;$i++) {

		$operationIncs = OperationInc::where('date', '<=', $date->addDay(1)->format('Y-m-d'))->get();

		$incommingSolde[$date->format('Y-m-d')] = ['mois' => $date->format('F'), 'jour' => $date->format('j'), 'amount' => $solde->amount];
		
		$incommingSolde[$date->format('Y-m-d')]['amount'] = $solde->amount;

		foreach ($operationIncs as $inc) {
			$incommingSolde[$date->format('Y-m-d')]['amount'] = $incommingSolde[$date->format('Y-m-d')]['amount'] + $inc->amount;
			//echo $inc->operationType->name . ' --> ' . $inc->amount . "<br/>";
		}

		$dates[] = $date->format('j M');
		if ($incommingSolde[$date->format('Y-m-d')]['amount'] > 0) {
			$soldesplus[] = $incommingSolde[$date->format('Y-m-d')]['amount'];
			$soldesmoins[] = 0;
		} else {
			$soldesmoins[] = $incommingSolde[$date->format('Y-m-d')]['amount'];
			$soldesplus[] = 0;
		}

		if ($date->format('j') == 3) {
			$soldeEndMonth = $incommingSolde[$date->format('Y-m-d')]['amount'];
			$dateEndMonth = $date->format('j F');
		}
		//echo "------- SOLDE : " . $incommingSolde[$date->format('Y-m-d')]['amount'] . " ------- <br/>";
		//echo "--------------------------------<br/>";
		//echo "--------------------------------<br/>";
		//echo "--------------------------------<br/>";
	}	

	$solde->incomming = $incommingSolde;	
	$operationTypes = OperationType::all();

	$categories = Category::where('id_parent', '0')->get();
        
	$bar = Charts::multi('bar', 'material')
            ->title("Solde des prochains jours")
            ->dimensions(0, 400) // Width x Height
            ->template("material")
            ->dataset('Solde :)', $soldesplus, 'bar')
            ->dataset('Solde :(', $soldesmoins, 'bar')
	    ->colors(['green', 'red'])
//            ->responsive(true)
            // Setup what the values mean
            ->labels($dates);
/*
	$bar = Charts::create('bar', 'highcharts')
			      ->title("Solde à venir")
			      ->elementLabel("Solde")
			      ->labels($dates)
			      ->values($soldes)
			      ->responsive(true);
*/
	return view('index')->withSolde($solde)->withOperationTypes($operationTypes)->withCategories($categories)->withBar($bar)->withSoldeEndMonth($soldeEndMonth)->withDateEndMonth($dateEndMonth);
    }

    public function month()
    {

	    $ins = Operation::whereMonth('date', '3')
		    		->where('amount', '>', 0)
		    		->get();

	return view('month')->withIns($ins);
    }

    public function stats()
    {
	$categories = Category::where('id_parent', '0')->get();

	$date = Carbon::now();
/*
	$operations = Operation::selectRaw('MONTH(date) as month, id_category, sum(amount) as total')
        ->where('date', '>', '2019-01-01')
        ->groupBy('id_category', 'month')
        ->orderBy('date')
        ->get();
	$total = DB::select( DB::raw(" SELECT * FROM operationsome_t"));
*/
	$line = Charts::multi('line', 'highcharts')
            ->title("My Cool Chart")
            ->dimensions(0, 400) // Width x Height
            ->template("material");

	$colors = [];
	$months = array();
	$i=0;
	$date = Carbon::now()->subYears(1);
	foreach ($categories as $category) {

		$catList = [$category->id];
		$colors[] = $category->color;
		$typeList = [];
		$categoryChilds  = Category::where('id_parent', $category->id)->get();

		foreach ($categoryChilds as $child) {
			$catList[] = $child->id;
		}
		
		$operationTypes = operationType::whereIn('id_category', $catList)->get();
		foreach ($operationTypes as $opType) {
			$typeList[] = $opType->id;
		}
		$operations = Operation::selectRaw('MONTH(date) as month,date,  sum(amount) as total')
		->where('date', '>=', $date->format('Y-m-01'))
		->where('amount', '<', 0)
		->whereIn('operation_type', $typeList)->orWhereIn('id_category', $catList)
        	->groupBy( 'month')
        	->orderBy('date')
        	->get();
		$total = [];
		foreach ($operations as $op) {
			$total[] = abs($op->total);
			$dateOp = Carbon::createFromFormat('Y-m-d',$op->date);
			$months[$dateOp->format('Y-m-01')] = $dateOp->format('M y');
		}

		$line->dataset($category->name,$total);
//		var_dump($operation->month, $operation->id_category, $operation->total);

		$i++;
	}
		$operations = Operation::selectRaw('MONTH(date) as month,date,  sum(amount) as total')
                ->where('date', '>=', $date->format('Y-m-01'))
                ->where('amount', '<', 0)
                ->where('operation_type', 0)->where('id_category', 0)
                ->groupBy( 'month')
                ->orderBy('date')
                ->get();
                $total = [];
                foreach ($operations as $op) {
                        $total[] = abs($op->total);
                        $dateOp = Carbon::createFromFormat('Y-m-d',$op->date);
                        $months[$dateOp->format('Y-m-01')] = $dateOp->format('M y');
                }

                $line->dataset('Sans categorie',$total);
//            ->responsive(true)
            // Setup what the values mean
            $line->labels($months);
	    $line->colors($colors);


	return view('stats', ['line' => $line])->withCategories($categories);
    }

	public function monthIns()
	{

	$operations = Operation::select(['id', 'date', 'title', 'detail', 'amount'])->where('amount', '>', 0)->whereMonth('date', 3)->whereYear('date', 2024);
    
        return DataTables::of($operations)
            ->editColumn('date', function ($operations) {
                Carbon::setLocale('FR');
                return Carbon::createFromFormat('Y-m-d', $operations->date)->format('d M');
            })
            ->editColumn('amount', function ($operations) {
                if ($operations->amount > 0) {
                        return '<span style="color:green;font-weight:bold">+'.$operations->amount.'</span>';
                } else {
                        return '<span style="color:red;font-weight:bold">'.$operations->amount.'</span>';
                }
            })
            ->addColumn('superDetail', function ($operations) {
                $operation = Operation::find($operations->id);

                $return = "";

                if ($operation->operation_type > 0) {
                        if ($operation->operationType->category->id_parent > 0) {

                                if (strlen($operation->operationType->category->parent->icon)) {
                                        $return .= '<span data-toggle="modal" class="typeOp" data-target="#catModal" name="'.$operation->id.'" style="color:'.$operation->operationType->category->parent->color.'">' . $operation->operationType->category->parent->icon . '</span> ';
                                } else {
                                        $return .= $operation->operationType->category->parent->name . ' - ';
                                }
                        }
			if (strlen($operation->operationType->category->icon)) {
                                $return .= '<span data-toggle="modal" data-target="#catModal" name="'.$operation->id.'" class="typeOp" style="color:'.$operation->operationType->category->color.'">' . $operation->operationType->category->icon . '</span> ';
                        } else {
                                $return .= $operation->operationType->category->name . '-';
                        }

                        $return .= $operation->operationType->name;

                        return $return;

                } else if ($operation->id_category > 0) {

                        if ($operation->category->id_parent > 0) {
                                if (strlen($operation->category->parent->icon)) {
                                        $return .= '<span data-toggle="modal" class="typeOp" data-target="#catModal" name="'.$operation->id.'" style="color:'.$operation->category->parent->color.'">' . $operation->category->parent->icon . '</span> ';
                                } else {
                                        $return .= $operation->category->parent->name . ' - ';
                                }
                        }
                        if (strlen($operation->category->icon)) {
                                $return .= '<span data-toggle="modal" data-target="#catModal" name="'.$operation->id.'" class="typeOp" style="color:'.$operation->category->color.'">' . $operation->category->icon . '</span> ';
                        } else {
                                $return .= $operation->category->name . '-';
                        }
                        $return .= $operation->detail;
                        return $return;
                } else {
                        return $operation->detail .'<span><button data-toggle="modal" data-target="#catModal" name="'.$operation->id.'" class="typeOp">Quésako <i class="fas fa-question"></i></button></span>';
                }
            })
            ->removeColumn('id')
            ->rawColumns(['amount', 'superDetail'])
            ->setRowClass(function ($operations) {
                return '';
                return $operations->id % 2 == 0 ? 'alert-info' : 'alert-warning';
            })
            ->make(true);
    }

    public function monthDep()
        {

        $operations = Operation::select(['id', 'date', 'title', 'detail', 'amount'])->where('amount', '<', 0)->whereMonth('date', 3)->whereYear('date', 2024);

        return DataTables::of($operations)
            ->editColumn('date', function ($operations) {
                Carbon::setLocale('FR');
                return Carbon::createFromFormat('Y-m-d', $operations->date)->format('d M');
            })
            ->editColumn('amount', function ($operations) {
                if ($operations->amount > 0) {
                        return '<span style="color:green;font-weight:bold">+'.$operations->amount.'</span>';
                } else {
                        return '<span style="color:red;font-weight:bold">'.$operations->amount.'</span>';
                }
            })
            ->addColumn('superDetail', function ($operations) {
                $operation = Operation::find($operations->id);

                $return = "";

                if ($operation->operation_type > 0) {
                        if ($operation->operationType->category->id_parent > 0) {

                                if (strlen($operation->operationType->category->parent->icon)) {
                                        $return .= '<span data-toggle="modal" class="typeOp" data-target="#catModal" name="'.$operation->id.'" style="color:'.$operation->operationType->category->parent->color.'">' . $operation->operationType->category->parent->icon . '</span> ';
                                } else {
                                        $return .= $operation->operationType->category->parent->name . ' - ';
                                }
                        }
                        if (strlen($operation->operationType->category->icon)) {
                                $return .= '<span data-toggle="modal" data-target="#catModal" name="'.$operation->id.'" class="typeOp" style="color:'.$operation->operationType->category->color.'">' . $operation->operationType->category->icon . '</span> ';
                        } else {
                                $return .= $operation->operationType->category->name . '-';
                        }

                        $return .= $operation->operationType->name;

                        return $return;
		} else if ($operation->id_category > 0) {

                        if ($operation->category->id_parent > 0) {
                                if (strlen($operation->category->parent->icon)) {
                                        $return .= '<span data-toggle="modal" class="typeOp" data-target="#catModal" name="'.$operation->id.'" style="color:'.$operation->category->parent->color.'">' . $operation->category->parent->icon . '</span> ';
                                } else {
                                        $return .= $operation->category->parent->name . ' - ';
                                }
                        }
                        if (strlen($operation->category->icon)) {
                                $return .= '<span data-toggle="modal" data-target="#catModal" name="'.$operation->id.'" class="typeOp" style="color:'.$operation->category->color.'">' . $operation->category->icon . '</span> ';
                        } else {
                                $return .= $operation->category->name . '-';
                        }
                        $return .= $operation->detail;
                        return $return;
                } else {
                        return $operation->detail .'<span><button data-toggle="modal" data-target="#catModal" name="'.$operation->id.'" class="typeOp">Quésako <i class="fas fa-question"></i></button></span>';
                }
            })
            ->removeColumn('id')
            ->rawColumns(['amount', 'superDetail'])
            ->setRowClass(function ($operations) {
                return '';
                return $operations->id % 2 == 0 ? 'alert-info' : 'alert-warning';
            })
            ->make(true);
    }

    public function monthRec()
        {

		$operations = OperationInc::select(['id', 'date', 'amount'])->where('amount', '<', 0)->where('period', '=', 'month');
// ajouter restriction sur date depart de l operation
        return DataTables::of($operations)
            ->editColumn('date', function ($operations) {
                Carbon::setLocale('FR');
                return Carbon::createFromFormat('Y-m-d', $operations->date)->format('d M');
            })
            ->editColumn('amount', function ($operations) {
                if ($operations->amount > 0) {
                        return '<span style="color:green;font-weight:bold">+'.$operations->amount.'</span>';
                } else {
                        return '<span style="color:red;font-weight:bold">'.$operations->amount.'</span>';
                }
            })
            ->addColumn('superDetail', function ($operations) {
                $operation = OperationInc::find($operations->id);

                $return = "";

                if ($operation->id_operation_type > 0) {
                        if ($operation->operationType->category->id_parent > 0) {

                                if (strlen($operation->operationType->category->parent->icon)) {
                                        $return .= '<span data-toggle="modal" class="typeOp" data-target="#catModal" name="'.$operation->id.'" style="color:'.$operation->operationType->category->parent->color.'">' . $operation->operationType->category->parent->icon . '</span> ';
                                } else {
                                        $return .= $operation->operationType->category->parent->name . ' - ';
                                }
                        }
                        if (strlen($operation->operationType->category->icon)) {
                                $return .= '<span data-toggle="modal" data-target="#catModal" name="'.$operation->id.'" class="typeOp" style="color:'.$operation->operationType->category->color.'">' . $operation->operationType->category->icon . '</span> ';
                        } else {
                                $return .= $operation->operationType->category->name . '-';
                        }

                        $return .= $operation->operationType->name;

                        return $return;
		} else if ($operation->id_category > 0) {

                        if ($operation->category->id_parent > 0) {
                                if (strlen($operation->category->parent->icon)) {
                                        $return .= '<span data-toggle="modal" class="typeOp" data-target="#catModal" name="'.$operation->id.'" style="color:'.$operation->category->parent->color.'">' . $operation->category->parent->icon . '</span> ';
                                } else {
                                        $return .= $operation->category->parent->name . ' - ';
                                }
                        }
                        if (strlen($operation->category->icon)) {
                                $return .= '<span data-toggle="modal" data-target="#catModal" name="'.$operation->id.'" class="typeOp" style="color:'.$operation->category->color.'">' . $operation->category->icon . '</span> ';
                        } else {
                                $return .= $operation->category->name . '-';
                        }
                        $return .= $operation->name;
                        return $return;
                } else {
                        return $operation->name .'<span><button data-toggle="modal" data-target="#catModal" name="'.$operation->id.'" class="typeOp">Quésako <i class="fas fa-question"></i></button></span>';
                }
            })
            ->removeColumn('id')
            ->rawColumns(['amount', 'superDetail'])
            ->setRowClass(function ($operations) {
                return '';
                return $operations->id % 2 == 0 ? 'alert-info' : 'alert-warning';
            })
            ->make(true);
    }


	public function data()
    {
       	$operations = Operation::select(['id', 'date', 'title', 'detail', 'amount', 'checked', 'operation_type']);
       // $operations = Operation::select(['id', 'date', 'title', 'detail', 'amount', 'checked', 'operation_type'])->orderBy('date', 'desc');
        //$operations = Operation::select(['id', 'date', 'title', 'detail', 'amount', 'checked', 'operation_type'])->where('operation_type', 0)->where('id_category', 0)->where('detail', 'not like', '%CHEQUE%')->orderBy('amount', 'asc');
    
	return DataTables::of($operations)
	    ->editColumn('date', function ($operations) {
		Carbon::setLocale('FR');
		return Carbon::createFromFormat('Y-m-d', $operations->date)->format('d M');
	    })
	    ->editColumn('amount', function ($operations) {
                if ($operations->amount > 0) {
			return '<span style="color:green;font-weight:bold">+'.$operations->amount.'</span>';
		} else {
			return '<span style="color:red;font-weight:bold">'.$operations->amount.'</span>';
		}
            })	   	 
	    ->addColumn('superDetail', function ($operations) {
		$operation = Operation::find($operations->id);
		
		$return = "";

		if ($operation->operation_type > 0) {
			if ($operation->operationType->category->id_parent > 0) {
			
				if (strlen($operation->operationType->category->parent->icon)) {	
					$return .= '<span data-toggle="modal" class="typeOp" data-target="#catModal" name="'.$operation->id.'" style="color:'.$operation->operationType->category->parent->color.'">' . $operation->operationType->category->parent->icon . '</span> ';
				} else {
					$return .= $operation->operationType->category->parent->name . ' - ';
				}
			}
			
			if (strlen($operation->operationType->category->icon)) {
				$return .= '<span data-toggle="modal" data-target="#catModal" name="'.$operation->id.'" class="typeOp" style="color:'.$operation->operationType->category->color.'">' . $operation->operationType->category->icon . '</span> ';
			} else {
				$return .= $operation->operationType->category->name . '-';
			}
			
			$return .= $operation->operationType->name;
			
			return $return;
			
		} else if ($operation->id_category > 0) {

			if ($operation->category->id_parent > 0) {
				if (strlen($operation->category->parent->icon)) {
					$return .= '<span data-toggle="modal" class="typeOp" data-target="#catModal" name="'.$operation->id.'" style="color:'.$operation->category->parent->color.'">' . $operation->category->parent->icon . '</span> ';
				} else {
					$return .= $operation->category->parent->name . ' - ';
				}
			}
			if (strlen($operation->category->icon)) {
				$return .= '<span data-toggle="modal" data-target="#catModal" name="'.$operation->id.'" class="typeOp" style="color:'.$operation->category->color.'">' . $operation->category->icon . '</span> ';
			} else {
				$return .= $operation->category->name . '-';
			}
			$return .= $operation->detail;
			return $return;
		} else {
			return $operation->detail .'<span><button data-toggle="modal" data-target="#catModal" name="'.$operation->id.'" class="typeOp">Quésako <i class="fas fa-question"></i></button></span>';
		}
	    })
	    ->addColumn('type', function ($operations) {
		$operation = Operation::find($operations->id);
		if (strlen($operation->type->image)) {
			$return = $operation->type->image;
		} else {
			$return = $operation->type->title;
		}
		return $return;
	    })
	    ->addColumn('pointe', function ($operations) {
		if (!$operations->checked) {
                	return '<a href="#edit-'.$operations->id.'" id="pointe-'.$operations->id.'" class="pointage"><i class="fas fa-2x fa-check-square level-empty"></i></a>';
		} else {
                	return '<a href="#edit-'.$operations->id.'" id="pointe-'.$operations->id.'" class="pointage"><i class="fas fa-2x fa-check-square success"></i></a>';
		}
            })
	//    ->addColumn('action', function ($operations) {
        //        return '<a href="#edit-'.$operations->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
        //    })
            ->removeColumn('id')
            ->rawColumns(['type','amount',  'pointe', 'superDetail'])
	    ->setRowClass(function ($operations) {
		return '';
                return $operations->id % 2 == 0 ? 'alert-info' : 'alert-warning';
            })
            ->make(true);
    }

    public function dataInc()
    {
        $operations = OperationInc::select(['id', 'date', 'name', 'id_operation_type', 'amount', 'period', 'delta', 'id_category'])->orderBy('date', 'asc');
        //$operations = Operation::select(['id', 'date', 'title', 'detail', 'amount', 'checked', 'operation_type'])->where('operation_type', 0)->where('id_category', 0)->orderBy('date', 'desc');

        return DataTables::of($operations)
            ->editColumn('date', function ($operations) {
                Carbon::setLocale('FR');
                return Carbon::createFromFormat('Y-m-d', $operations->date)->format('d M');
            })
            ->editColumn('amount', function ($operations) {
		$return = "";
		$delta = "";
		if ($operations->delta > 0) {
			$delta = '<span class="deltaInc"> à '.$operations->delta.'%</span>';
		}
                if ($operations->amount > 0) { 
                        $return .= '<span style="color:green;font-weight:bold">+'.(float)$operations->amount.'</span>';
                } else {
                        $return .= '<span style="color:red;font-weight:bold">'.(float)$operations->amount.'</span>';
                }

		$return .= $delta;
		return $return;
            })
	    ->editColumn('name', function ($operation) {

		$return = "";
		if ($operation->id_operation_type > 0) {
                        if ($operation->operationType->category->id_parent > 0) {

                                if (strlen($operation->operationType->category->parent->icon)) {
                                        $return .= '<span data-toggle="modal" data-target="#catModal" name="'.$operation->id.'"  class="typeOpInc" style="color:'.$operation->operationType->category->parent->color.'">' . $operation->operationType->category->parent->icon . '</span> ';
                                } else {
                                        $return .= $operation->operationType->category->parent->name . ' - ';
                                }
                        }

                        if (strlen($operation->operationType->category->icon)) {
                                $return .= '<span data-toggle="modal" data-target="#catModal" name="'.$operation->id.'"  class="typeOpInc" style="color:'.$operation->operationType->category->color.'">' . $operation->operationType->category->icon . '</span> ';
                        } else {
                                $return .= $operation->operationType->category->name . '-';
                        }

                        $return .= $operation->operationType->name;

                        return $return;
		} else if ($operation->id_category > 0) {

			if ($operation->category->id_parent > 0) {

                                if (strlen($operation->category->parent->icon)) {
                                        $return .= '<span data-toggle="modal" data-target="#catModal" name="'.$operation->id.'"  class="typeOpInc" style="color:'.$operation->category->parent->color.'">' . $operation->category->parent->icon . '</span> ';
                                } else {
                                        $return .= $operation->category->parent->name . ' - ';
                                }
                        }

                        if (strlen($operation->category->icon)) {
                                $return .= '<span data-toggle="modal" data-target="#catModal" name="'.$operation->id.'"  class="typeOpInc" style="color:'.$operation->category->color.'">' . $operation->category->icon . '</span> ';
                        } else {
                                $return .= $operation->category->name . '-';
                        }

                        $return .= $operation->name;

			return $return;
                } else {    
                        return $operation->name .'<span><button data-toggle="modal" data-target="#catModal" name="'.$operation->id.'"  class="typeOpInc">Quésako <i class="fas fa-question"></i></button></span>';
                }
	        })
	    ->addColumn('misc', function ($operation) {
		
		$return  = '<a class="editInc" data-toggle="modal" data-target="#myModal" name="'.$operation->id.'"><i class="fas fa-edit"></i></a>';
		if ($operation->period != 'none') {
			$return .= '<a class="renewInc" name="'.$operation->id.'"><i class="fas fa-redo"></i>';
		} else {
			$return .= '<a class="deleteInc" name="'.$operation->id.'"><i class="fas fa-trash"></i></a>';
		}

		return $return;
            })
        //    ->addColumn('action', function ($operations) {
        //        return '<a href="#edit-'.$operations->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
        //    })
            ->removeColumn('id')
            ->removeColumn('period')
            ->removeColumn('delta')
            ->rawColumns(['type','amount',  'name', 'misc'])
            ->setRowClass(function ($operations) {
                return '';
                return $operations->id % 2 == 0 ? 'alert-info' : 'alert-warning';
            })
            ->make(true);
	}


    public function pointe(Request $request)
    {

	if ( ! $request->ajax())
            abort(405, 'Method Not Allowed');

        $id_operation = str_replace("pointe-", "", $request->get('id_operation'));

	$operation = Operation::find($id_operation);
	$operation->checked = ($operation->checked == 1) ? 0 : 1;
	$operation->save();	

        return response()->json([
            'result' => $operation->checked 
        ]);

    }

    public function deleteInc(Request $request)
    {

        if ( ! $request->ajax())
            abort(405, 'Method Not Allowed');

        $id_operation = $request->get('id_operation_inc');

        $operationInc = OperationInc::find($id_operation);



        $operationInc->delete();

        return response()->json([
            'result' => 1
        ]);

    }

    public function renewInc(Request $request)
    {

        if ( ! $request->ajax())
            abort(405, 'Method Not Allowed');

        $id_operation = $request->get('id_operation_inc');

        $operationInc = OperationInc::find($id_operation);

	if ($operationInc->period == 'month') {
	        $operationInc->date = Carbon::createFromFormat('Y-m-d', $operationInc->date)->addMonth(1)->format('Y-m-d');
	} else if ($operationInc->period == 'year') {
	        $operationInc->date = Carbon::createFromFormat('Y-m-d', $operationInc->date)->addYear(1)->format('Y-m-d');
	}
	$operationInc->save();

        return response()->json([
            'result' => 1
        ]);

    }

    public function getOperationInc(Request $request)
    {

        /*if ( ! $request->ajax())
            abort(405, 'Method Not Allowed');
*/
        $id_operation = $request->get('id_operation_inc');

	if ($id_operation == 0) {
		return response()->json([
            'id_operation_inc' => 0
        ]);
	}
        $operationInc = OperationInc::find($id_operation);

        return response()->json([
            'id_operation_inc' => $operationInc->id,
            'id_operation_type' => $operationInc->id_operation_type,
            'operation_type_name' => $operationInc->operationType->name,
            'name' => $operationInc->name,
            'date' => $operationInc->date,
            'sign' => ($operationInc->amount > 0) ? '+': '-',
            'amount' => abs($operationInc->amount),
            'period' => $operationInc->period,
            'delta' => $operationInc->delta
        ]);

    }

    public function addOperation(CreateOperationIncRequest $request)
    {
        $input = $request->all();
	if ($input['sign'] == '-' ) {
		$input['amount'] = -abs($input['amount']);
	} else {
		$input['amount'] = abs($input['amount']);
	}
	if ($input['id_operation_inc'] > 0) {

		$operationInc = OperationInc::find($input['id_operation_inc']);
		$operationInc->id_operation_type = $input['id_operation_type'];
		$operationInc->name = $input['name'];
		$operationInc->date = $input['date'];
		$operationInc->amount = str_replace(',', '.', str_replace('.', '', $input['amount']));
		$operationInc->period = $input['period'];
		$operationInc->delta = $input['delta'];
		$operationInc->save();

	} else {
        	$operationInc = $this->operationIncRepository->create($input);
	}
        Flash::success('L\'opération a bien été enregistrée, elle sera pointée automatiquement');
        return redirect(route('home'));
    }

    public function getOperationToFill(Request $request)
    {
        $input = $request->all();
       
	$result = array();
	$result['id_category'] = 0;
	$result['id_parent'] = 0;
	$result['name'] = '';
	$result['findme'] = '';
	$result['detail'] = '';
	
	if ($input['id_operation'] > 0) {

                $operation = Operation::find((int)$input['id_operation']);
		if ($operation->operation_type > 0) {

			$result['id_category'] = $operation->operationType->id_category;
			$result['id_parent'] = $operation->operationType->category->id_parent;
			$result['name'] = $operation->operationType->name;
			$result['findme'] = $operation->operationType->findme;
		}
			$result['detail'] = $operation->detail;
        }
        Flash::success('L\'opération a bien été enregistrée, elle sera pointée automatiquement');
	return response()->json([
           'result' => $result
       ]);       
    }

    public function getOperationIncToFill(Request $request)
    {
        $input = $request->all();

        $result = array();
        $result['id_category'] = 0;
        $result['id_parent'] = 0;
        $result['name'] = '';
        $result['findme'] = '';
        $result['detail'] = '';

        if ($input['id_operation_inc'] > 0) {

                $operationInc = OperationInc::find((int)$input['id_operation_inc']);
                if ($operationInc->id_operation_type > 0) {

                        $result['id_category'] = $operationInc->operationType->id_category;
                        $result['id_parent'] = $operationInc->operationType->category->id_parent;
                        $result['name'] = $operationInc->operationType->name;
                        $result['findme'] = $operationInc->operationType->findme;
                        $result['detail'] = $operationInc->name;
                }
        }
        Flash::success('L\'opération a bien été enregistrée, elle sera pointée automatiquement');
        return response()->json([
           'result' => $result
       ]);
    }

    public function addCategory(Request $request)
    {
       $input = $request->all();

       $category = new Category();
       $category->name = $input['name'];
       $category->id_parent = $input['id_parent'];
       $category->save();

       Flash::success('L\'opération a bien été enregistrée, elle sera pointée automatiquement');
       return response()->json([
           'result' => $category->id
       ]);

    }

    public function addOperationType(Request $request)
    {
        $input = $request->all();

	if ($input['id_operation_type'] == 0) {

                if (strlen($input['name']) > 1) {

			$operationType = new OperationType();
			$operationType->id_category = $input['id_category'];
			$operationType->name = $input['name'];
			$operationType->findme = $input['findme'];
			$operationType->save();
		} else if ($input['id_category'] > 0 && $input['id_operation'] > 0) {
			$operation = Operation::find($input['id_operation']);
	                $operation->id_category = $input['id_category'];
	                $operation->save();	
		} else if ($input['id_category'] > 0 && $input['id_operation_inc'] > 0) {
			$operation = OperationInc::find($input['id_operation_inc']);
	                $operation->id_category = $input['id_category'];
	                $operation->save();	
		}
	} else {


			$operationType = OperationType::find($input['id_operation_type']);
               		$operationType->id_category = $input['id_category'];
                	$operationType->name = $input['name'];
                	$operationType->findme = $input['findme'];
                	$operationType->save();

	}

	if ($input['id_operation'] > 0 && strlen($input['name']) > 1) {
		$operation = Operation::find($input['id_operation']);
		$operation->operation_type = $operationType->id;
		$operation->save();
	}
	if ($input['id_operation_inc'] > 0 && strlen($input['name']) > 1) {
                $operationInc = OperationInc::find($input['id_operation_inc']);
                $operationInc->id_operation_type = $operationType->id;
                $operationInc->save();
        }


       Flash::success('L\'opération a bien été enregistrée, elle sera pointée automatiquement');

	return redirect(route('home'));

    }

    public function dropzone(FileUploadRequest $request)
    {
        $destinationPath = public_path() . '/uploads/files/';

        $file_temp = $request->file('file');
        $extension       = $file_temp->getClientOriginalExtension() ?: 'png';
        $safeName        = str_random(10).'.'.$extension;

        $fileItem = new File();
        $fileItem->filename = $safeName;
        $fileItem->mime = $file_temp->getMimeType();
        $fileItem->save();

        $file_temp->move($destinationPath, $safeName);

        $seeder = new OperationsSeeder();
        $seeder->file = "/public/uploads/files/".$safeName;
        $seeder->run();


        $handle = fopen("/var/www/comptes/".$seeder->file, "r");

        $csvLine = fgetcsv($handle, 1000, ";");

        $soldeAmount = str_replace(",",".",str_replace(" EUR", "", $csvLine[5]));

        $solde = Solde::find(1);

        $solde->amount = $soldeAmount;

        $solde->save();


      //  Thumbnail::generate_image_thumbnail($destinationPath . $safeName, $destinationPath . 'thumb_' . $safeName);

        return $fileItem->toJson();
    }

}
