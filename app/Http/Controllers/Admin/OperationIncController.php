<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CreateOperationIncRequest;
use App\Http\Requests\UpdateOperationIncRequest;
use App\Repositories\OperationIncRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\OperationInc;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class OperationIncController extends InfyOmBaseController
{
    /** @var  OperationIncRepository */
    private $operationIncRepository;

    public function __construct(OperationIncRepository $operationIncRepo)
    {
        $this->operationIncRepository = $operationIncRepo;
    }

    /**
     * Display a listing of the OperationInc.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $this->operationIncRepository->pushCriteria(new RequestCriteria($request));
        $operationIncs = $this->operationIncRepository->all();
        return view('admin.operationIncs.index')
            ->with('operationIncs', $operationIncs);
    }

    /**
     * Show the form for creating a new OperationInc.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.operationIncs.create');
    }

    /**
     * Store a newly created OperationInc in storage.
     *
     * @param CreateOperationIncRequest $request
     *
     * @return Response
     */
    public function store(CreateOperationIncRequest $request)
    {
        $input = $request->all();

        $operationInc = $this->operationIncRepository->create($input);

        Flash::success('OperationInc saved successfully.');

        return redirect(route('admin.operationIncs.index'));
    }

    /**
     * Display the specified OperationInc.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $operationInc = $this->operationIncRepository->findWithoutFail($id);

        if (empty($operationInc)) {
            Flash::error('OperationInc not found');

            return redirect(route('operationIncs.index'));
        }

        return view('admin.operationIncs.show')->with('operationInc', $operationInc);
    }

    /**
     * Show the form for editing the specified OperationInc.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $operationInc = $this->operationIncRepository->findWithoutFail($id);

        if (empty($operationInc)) {
            Flash::error('OperationInc not found');

            return redirect(route('operationIncs.index'));
        }

        return view('admin.operationIncs.edit')->with('operationInc', $operationInc);
    }

    /**
     * Update the specified OperationInc in storage.
     *
     * @param  int              $id
     * @param UpdateOperationIncRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOperationIncRequest $request)
    {
        $operationInc = $this->operationIncRepository->findWithoutFail($id);

        

        if (empty($operationInc)) {
            Flash::error('OperationInc not found');

            return redirect(route('operationIncs.index'));
        }

        $operationInc = $this->operationIncRepository->update($request->all(), $id);

        Flash::success('OperationInc updated successfully.');

        return redirect(route('admin.operationIncs.index'));
    }

    /**
     * Remove the specified OperationInc from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
      public function getModalDelete($id = null)
      {
          $error = '';
          $model = '';
          $confirm_route =  route('admin.operationIncs.delete',['id'=>$id]);
          return View('admin.layouts/modal_confirmation', compact('error','model', 'confirm_route'));

      }

       public function getDelete($id = null)
       {
           $sample = OperationInc::destroy($id);

           // Redirect to the group management page
           return redirect(route('admin.operationIncs.index'))->with('success', Lang::get('message.success.delete'));

       }

}
