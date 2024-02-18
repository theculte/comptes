<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CreateOperationRecurentRequest;
use App\Http\Requests\UpdateOperationRecurentRequest;
use App\Repositories\OperationRecurentRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\OperationRecurent;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class OperationRecurentController extends InfyOmBaseController
{
    /** @var  OperationRecurentRepository */
    private $operationRecurentRepository;

    public function __construct(OperationRecurentRepository $operationRecurentRepo)
    {
        $this->operationRecurentRepository = $operationRecurentRepo;
    }

    /**
     * Display a listing of the OperationRecurent.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $this->operationRecurentRepository->pushCriteria(new RequestCriteria($request));
        $operationRecurents = $this->operationRecurentRepository->all();
        return view('admin.operationRecurents.index')
            ->with('operationRecurents', $operationRecurents);
    }

    /**
     * Show the form for creating a new OperationRecurent.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.operationRecurents.create');
    }

    /**
     * Store a newly created OperationRecurent in storage.
     *
     * @param CreateOperationRecurentRequest $request
     *
     * @return Response
     */
    public function store(CreateOperationRecurentRequest $request)
    {
        $input = $request->all();

        $operationRecurent = $this->operationRecurentRepository->create($input);

        Flash::success('OperationRecurent saved successfully.');

        return redirect(route('admin.operationRecurents.index'));
    }

    /**
     * Display the specified OperationRecurent.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $operationRecurent = $this->operationRecurentRepository->findWithoutFail($id);

        if (empty($operationRecurent)) {
            Flash::error('OperationRecurent not found');

            return redirect(route('operationRecurents.index'));
        }

        return view('admin.operationRecurents.show')->with('operationRecurent', $operationRecurent);
    }

    /**
     * Show the form for editing the specified OperationRecurent.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $operationRecurent = $this->operationRecurentRepository->findWithoutFail($id);

        if (empty($operationRecurent)) {
            Flash::error('OperationRecurent not found');

            return redirect(route('operationRecurents.index'));
        }

        return view('admin.operationRecurents.edit')->with('operationRecurent', $operationRecurent);
    }

    /**
     * Update the specified OperationRecurent in storage.
     *
     * @param  int              $id
     * @param UpdateOperationRecurentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOperationRecurentRequest $request)
    {
        $operationRecurent = $this->operationRecurentRepository->findWithoutFail($id);

        

        if (empty($operationRecurent)) {
            Flash::error('OperationRecurent not found');

            return redirect(route('operationRecurents.index'));
        }

        $operationRecurent = $this->operationRecurentRepository->update($request->all(), $id);

        Flash::success('OperationRecurent updated successfully.');

        return redirect(route('admin.operationRecurents.index'));
    }

    /**
     * Remove the specified OperationRecurent from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
      public function getModalDelete($id = null)
      {
          $error = '';
          $model = '';
          $confirm_route =  route('admin.operationRecurents.delete',['id'=>$id]);
          return View('admin.layouts/modal_confirmation', compact('error','model', 'confirm_route'));

      }

       public function getDelete($id = null)
       {
           $sample = OperationRecurent::destroy($id);

           // Redirect to the group management page
           return redirect(route('admin.operationRecurents.index'))->with('success', Lang::get('message.success.delete'));

       }

}
