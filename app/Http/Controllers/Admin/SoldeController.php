<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CreateSoldeRequest;
use App\Http\Requests\UpdateSoldeRequest;
use App\Repositories\SoldeRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\Solde;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class SoldeController extends InfyOmBaseController
{
    /** @var  SoldeRepository */
    private $soldeRepository;

    public function __construct(SoldeRepository $soldeRepo)
    {
        $this->soldeRepository = $soldeRepo;
    }

    /**
     * Display a listing of the Solde.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $this->soldeRepository->pushCriteria(new RequestCriteria($request));
        $soldes = $this->soldeRepository->all();
        return view('admin.soldes.index')
            ->with('soldes', $soldes);
    }

    /**
     * Show the form for creating a new Solde.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.soldes.create');
    }

    /**
     * Store a newly created Solde in storage.
     *
     * @param CreateSoldeRequest $request
     *
     * @return Response
     */
    public function store(CreateSoldeRequest $request)
    {
        $input = $request->all();

        $solde = $this->soldeRepository->create($input);

        Flash::success('Solde saved successfully.');

        return redirect(route('admin.soldes.index'));
    }

    /**
     * Display the specified Solde.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $solde = $this->soldeRepository->findWithoutFail($id);

        if (empty($solde)) {
            Flash::error('Solde not found');

            return redirect(route('soldes.index'));
        }

        return view('admin.soldes.show')->with('solde', $solde);
    }

    /**
     * Show the form for editing the specified Solde.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $solde = $this->soldeRepository->findWithoutFail($id);

        if (empty($solde)) {
            Flash::error('Solde not found');

            return redirect(route('soldes.index'));
        }

        return view('admin.soldes.edit')->with('solde', $solde);
    }

    /**
     * Update the specified Solde in storage.
     *
     * @param  int              $id
     * @param UpdateSoldeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSoldeRequest $request)
    {
        $solde = $this->soldeRepository->findWithoutFail($id);

        

        if (empty($solde)) {
            Flash::error('Solde not found');

            return redirect(route('soldes.index'));
        }

        $solde = $this->soldeRepository->update($request->all(), $id);

        Flash::success('Solde updated successfully.');

        return redirect(route('admin.soldes.index'));
    }

    /**
     * Remove the specified Solde from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
      public function getModalDelete($id = null)
      {
          $error = '';
          $model = '';
          $confirm_route =  route('admin.soldes.delete',['id'=>$id]);
          return View('admin.layouts/modal_confirmation', compact('error','model', 'confirm_route'));

      }

       public function getDelete($id = null)
       {
           $sample = Solde::destroy($id);

           // Redirect to the group management page
           return redirect(route('admin.soldes.index'))->with('success', Lang::get('message.success.delete'));

       }

}
