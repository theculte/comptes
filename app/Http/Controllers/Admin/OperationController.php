<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CreateOperationRequest;
use App\Http\Requests\UpdateOperationRequest;
use App\Repositories\OperationRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\Operation;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class OperationController extends InfyOmBaseController
{
    /** @var  OperationRepository */
    private $operationRepository;

    public function __construct(OperationRepository $operationRepo)
    {
        $this->operationRepository = $operationRepo;
    }

    /**
     * Display a listing of the Operation.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $this->operationRepository->pushCriteria(new RequestCriteria($request));
        $operations = $this->operationRepository->all();
        return view('admin.operations.index')
            ->with('operations', $operations);
    }

    /**
     * Show the form for creating a new Operation.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.operations.create');
    }

    /**
     * Store a newly created Operation in storage.
     *
     * @param CreateOperationRequest $request
     *
     * @return Response
     */
    public function store(CreateOperationRequest $request)
    {
        $input = $request->all();

        $operation = $this->operationRepository->create($input);

        Flash::success('Operation saved successfully.');

        return redirect(route('admin.operations.index'));
    }

    /**
     * Display the specified Operation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $operation = $this->operationRepository->findWithoutFail($id);

        if (empty($operation)) {
            Flash::error('Operation not found');

            return redirect(route('operations.index'));
        }

        return view('admin.operations.show')->with('operation', $operation);
    }

    /**
     * Show the form for editing the specified Operation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $operation = $this->operationRepository->findWithoutFail($id);

        if (empty($operation)) {
            Flash::error('Operation not found');

            return redirect(route('operations.index'));
        }

        return view('admin.operations.edit')->with('operation', $operation);
    }

    /**
     * Update the specified Operation in storage.
     *
     * @param  int              $id
     * @param UpdateOperationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOperationRequest $request)
    {
        $operation = $this->operationRepository->findWithoutFail($id);

        
                        if($request->has('checked')){
	                    $request->merge(['checked' => 1]);
	                    }
                        else{
                        $request->merge(['checked' => 0]);
                         }

        if (empty($operation)) {
            Flash::error('Operation not found');

            return redirect(route('operations.index'));
        }

        $operation = $this->operationRepository->update($request->all(), $id);

        Flash::success('Operation updated successfully.');

        return redirect(route('admin.operations.index'));
    }

    /**
     * Remove the specified Operation from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
      public function getModalDelete($id = null)
      {
          $error = '';
          $model = '';
          $confirm_route =  route('admin.operations.delete',['id'=>$id]);
          return View('admin.layouts/modal_confirmation', compact('error','model', 'confirm_route'));

      }

       public function getDelete($id = null)
       {
           $sample = Operation::destroy($id);

           // Redirect to the group management page
           return redirect(route('admin.operations.index'))->with('success', Lang::get('message.success.delete'));

       }

}
