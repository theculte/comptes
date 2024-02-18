<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CreateTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Repositories\TypeRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\Type;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class TypeController extends InfyOmBaseController
{
    /** @var  TypeRepository */
    private $typeRepository;

    public function __construct(TypeRepository $typeRepo)
    {
        $this->typeRepository = $typeRepo;
    }

    /**
     * Display a listing of the Type.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $this->typeRepository->pushCriteria(new RequestCriteria($request));
        $types = $this->typeRepository->all();
        return view('admin.types.index')
            ->with('types', $types);
    }

    /**
     * Show the form for creating a new Type.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.types.create');
    }

    /**
     * Store a newly created Type in storage.
     *
     * @param CreateTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateTypeRequest $request)
    {
        $input = $request->all();

        $type = $this->typeRepository->create($input);

        Flash::success('Type saved successfully.');

        return redirect(route('admin.types.index'));
    }

    /**
     * Display the specified Type.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $type = $this->typeRepository->findWithoutFail($id);

        if (empty($type)) {
            Flash::error('Type not found');

            return redirect(route('types.index'));
        }

        return view('admin.types.show')->with('type', $type);
    }

    /**
     * Show the form for editing the specified Type.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $type = $this->typeRepository->findWithoutFail($id);

        if (empty($type)) {
            Flash::error('Type not found');

            return redirect(route('types.index'));
        }

        return view('admin.types.edit')->with('type', $type);
    }

    /**
     * Update the specified Type in storage.
     *
     * @param  int              $id
     * @param UpdateTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTypeRequest $request)
    {
        $type = $this->typeRepository->findWithoutFail($id);

        

        if (empty($type)) {
            Flash::error('Type not found');

            return redirect(route('types.index'));
        }

        $type = $this->typeRepository->update($request->all(), $id);

        Flash::success('Type updated successfully.');

        return redirect(route('admin.types.index'));
    }

    /**
     * Remove the specified Type from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
      public function getModalDelete($id = null)
      {
          $error = '';
          $model = '';
          $confirm_route =  route('admin.types.delete',['id'=>$id]);
          return View('admin.layouts/modal_confirmation', compact('error','model', 'confirm_route'));

      }

       public function getDelete($id = null)
       {
           $sample = Type::destroy($id);

           // Redirect to the group management page
           return redirect(route('admin.types.index'))->with('success', Lang::get('message.success.delete'));

       }

}
