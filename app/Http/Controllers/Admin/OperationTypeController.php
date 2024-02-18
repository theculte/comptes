<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CreateOperationTypeRequest;
use App\Http\Requests\UpdateOperationTypeRequest;
use App\Repositories\OperationTypeRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\OperationType;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class OperationTypeController extends InfyOmBaseController
{
    /** @var  OperationTypeRepository */
    private $operationTypeRepository;

    public function __construct(OperationTypeRepository $operationTypeRepo)
    {
        $this->operationTypeRepository = $operationTypeRepo;
    }

    /**
     * Display a listing of the OperationType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $this->operationTypeRepository->pushCriteria(new RequestCriteria($request));
        $operationTypes = $this->operationTypeRepository->all();
        return view('admin.operationTypes.index')
            ->with('operationTypes', $operationTypes);
    }

    /**
     * Show the form for creating a new OperationType.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.operationTypes.create');
    }

    /**
     * Store a newly created OperationType in storage.
     *
     * @param CreateOperationTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateOperationTypeRequest $request)
    {
        $input = $request->all();

        $operationType = $this->operationTypeRepository->create($input);

        Flash::success('OperationType saved successfully.');

        return redirect(route('admin.operationTypes.index'));
    }

    /**
     * Display the specified OperationType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $operationType = $this->operationTypeRepository->findWithoutFail($id);

        if (empty($operationType)) {
            Flash::error('OperationType not found');

            return redirect(route('operationTypes.index'));
        }

        return view('admin.operationTypes.show')->with('operationType', $operationType);
    }

    /**
     * Show the form for editing the specified OperationType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $operationType = $this->operationTypeRepository->findWithoutFail($id);

        if (empty($operationType)) {
            Flash::error('OperationType not found');

            return redirect(route('operationTypes.index'));
        }

        return view('admin.operationTypes.edit')->with('operationType', $operationType);
    }

    /**
     * Update the specified OperationType in storage.
     *
     * @param  int              $id
     * @param UpdateOperationTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOperationTypeRequest $request)
    {
        $operationType = $this->operationTypeRepository->findWithoutFail($id);

        

        if (empty($operationType)) {
            Flash::error('OperationType not found');

            return redirect(route('operationTypes.index'));
        }

        $operationType = $this->operationTypeRepository->update($request->all(), $id);

        Flash::success('OperationType updated successfully.');

        return redirect(route('admin.operationTypes.index'));
    }

    /**
     * Remove the specified OperationType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
      public function getModalDelete($id = null)
      {
          $error = '';
          $model = '';
          $confirm_route =  route('admin.operationTypes.delete',['id'=>$id]);
          return View('admin.layouts/modal_confirmation', compact('error','model', 'confirm_route'));

      }

       public function getDelete($id = null)
       {
           $sample = OperationType::destroy($id);

           // Redirect to the group management page
           return redirect(route('admin.operationTypes.index'))->with('success', Lang::get('message.success.delete'));

       }

}
