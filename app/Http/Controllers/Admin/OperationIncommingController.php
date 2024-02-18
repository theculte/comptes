<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CreateOperationIncommingRequest;
use App\Http\Requests\UpdateOperationIncommingRequest;
use App\Repositories\OperationIncommingRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\OperationIncomming;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class OperationIncommingController extends InfyOmBaseController
{
    /** @var  OperationIncommingRepository */
    private $operationIncommingRepository;

    public function __construct(OperationIncommingRepository $operationIncommingRepo)
    {
        $this->operationIncommingRepository = $operationIncommingRepo;
    }

    /**
     * Display a listing of the OperationIncomming.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $this->operationIncommingRepository->pushCriteria(new RequestCriteria($request));
        $operationIncommings = $this->operationIncommingRepository->all();
        return view('admin.operationIncommings.index')
            ->with('operationIncommings', $operationIncommings);
    }

    /**
     * Show the form for creating a new OperationIncomming.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.operationIncommings.create');
    }

    /**
     * Store a newly created OperationIncomming in storage.
     *
     * @param CreateOperationIncommingRequest $request
     *
     * @return Response
     */
    public function store(CreateOperationIncommingRequest $request)
    {
        $input = $request->all();

        $operationIncomming = $this->operationIncommingRepository->create($input);

        Flash::success('OperationIncomming saved successfully.');

        return redirect(route('admin.operationIncommings.index'));
    }

    /**
     * Display the specified OperationIncomming.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $operationIncomming = $this->operationIncommingRepository->findWithoutFail($id);

        if (empty($operationIncomming)) {
            Flash::error('OperationIncomming not found');

            return redirect(route('operationIncommings.index'));
        }

        return view('admin.operationIncommings.show')->with('operationIncomming', $operationIncomming);
    }

    /**
     * Show the form for editing the specified OperationIncomming.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $operationIncomming = $this->operationIncommingRepository->findWithoutFail($id);

        if (empty($operationIncomming)) {
            Flash::error('OperationIncomming not found');

            return redirect(route('operationIncommings.index'));
        }

        return view('admin.operationIncommings.edit')->with('operationIncomming', $operationIncomming);
    }

    /**
     * Update the specified OperationIncomming in storage.
     *
     * @param  int              $id
     * @param UpdateOperationIncommingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOperationIncommingRequest $request)
    {
        $operationIncomming = $this->operationIncommingRepository->findWithoutFail($id);

        

        if (empty($operationIncomming)) {
            Flash::error('OperationIncomming not found');

            return redirect(route('operationIncommings.index'));
        }

        $operationIncomming = $this->operationIncommingRepository->update($request->all(), $id);

        Flash::success('OperationIncomming updated successfully.');

        return redirect(route('admin.operationIncommings.index'));
    }

    /**
     * Remove the specified OperationIncomming from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
      public function getModalDelete($id = null)
      {
          $error = '';
          $model = '';
          $confirm_route =  route('admin.operationIncommings.delete',['id'=>$id]);
          return View('admin.layouts/modal_confirmation', compact('error','model', 'confirm_route'));

      }

       public function getDelete($id = null)
       {
           $sample = OperationIncomming::destroy($id);

           // Redirect to the group management page
           return redirect(route('admin.operationIncommings.index'))->with('success', Lang::get('message.success.delete'));

       }

}
