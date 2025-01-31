<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePsikologRequest;
use App\Http\Requests\UpdatePsikologRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PsikologRepository;
use Illuminate\Http\Request;
use Flash;

class PsikologController extends AppBaseController
{
    /** @var PsikologRepository $psikologRepository*/
    private $psikologRepository;

    public function __construct(PsikologRepository $psikologRepo)
    {
        $this->psikologRepository = $psikologRepo;
    }

    /**
     * Display a listing of the Psikolog.
     */
    public function index(Request $request)
    {
        $psikologs = $this->psikologRepository->paginate(10);

        return view('psikologs.index')
            ->with('psikologs', $psikologs);
    }

    /**
     * Show the form for creating a new Psikolog.
     */
    public function create()
    {
        return view('psikologs.create');
    }

    /**
     * Store a newly created Psikolog in storage.
     */
    public function store(CreatePsikologRequest $request)
    {
        $input = $request->all();

        $psikolog = $this->psikologRepository->create($input);

        Flash::success('Psikolog saved successfully.');

        return redirect(route('psikologs.index'));
    }

    /**
     * Display the specified Psikolog.
     */
    public function show($id)
    {
        $psikolog = $this->psikologRepository->find($id);

        if (empty($psikolog)) {
            Flash::error('Psikolog not found');

            return redirect(route('psikologs.index'));
        }

        return view('psikologs.show')->with('psikolog', $psikolog);
    }

    /**
     * Show the form for editing the specified Psikolog.
     */
    public function edit($id)
    {
        $psikolog = $this->psikologRepository->find($id);

        if (empty($psikolog)) {
            Flash::error('Psikolog not found');

            return redirect(route('psikologs.index'));
        }

        return view('psikologs.edit')->with('psikolog', $psikolog);
    }

    /**
     * Update the specified Psikolog in storage.
     */
    public function update($id, UpdatePsikologRequest $request)
    {
        $psikolog = $this->psikologRepository->find($id);

        if (empty($psikolog)) {
            Flash::error('Psikolog not found');

            return redirect(route('psikologs.index'));
        }

        $psikolog = $this->psikologRepository->update($request->all(), $id);

        Flash::success('Psikolog updated successfully.');

        return redirect(route('psikologs.index'));
    }

    /**
     * Remove the specified Psikolog from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $psikolog = $this->psikologRepository->find($id);

        if (empty($psikolog)) {
            Flash::error('Psikolog not found');

            return redirect(route('psikologs.index'));
        }

        $this->psikologRepository->delete($id);

        Flash::success('Psikolog deleted successfully.');

        return redirect(route('psikologs.index'));
    }
}
