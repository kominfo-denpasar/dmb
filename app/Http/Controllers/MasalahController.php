<?php

namespace App\Http\Controllers;

use App\DataTables\MasalahDataTable;
use App\Http\Requests\CreateMasalahRequest;
use App\Http\Requests\UpdateMasalahRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\MasalahRepository;
use Illuminate\Http\Request;
use Flash;

class MasalahController extends AppBaseController
{
    /** @var MasalahRepository $masalahRepository*/
    private $masalahRepository;

    public function __construct(MasalahRepository $masalahRepo)
    {
        $this->masalahRepository = $masalahRepo;
    }

    /**
     * Display a listing of the Masalah.
     */
    public function index(MasalahDataTable $masalahDataTable)
    {
        // $masalahs = $this->masalahRepository->paginate(10);
        return $masalahDataTable->render('masalahs.index');

        return view('masalahs.index')
            ->with('masalahs', $masalahs);
    }

    /**
     * Show the form for creating a new Masalah.
     */
    public function create()
    {
        return view('masalahs.create');
    }

    /**
     * Store a newly created Masalah in storage.
     */
    public function store(CreateMasalahRequest $request)
    {
        $input = $request->all();

        $masalah = $this->masalahRepository->create($input);

        Flash::success('Masalah saved successfully.');

        return redirect(route('masalahs.index'));
    }

    /**
     * Display the specified Masalah.
     */
    public function show($id)
    {
        $masalah = $this->masalahRepository->find($id);

        if (empty($masalah)) {
            Flash::error('Masalah not found');

            return redirect(route('masalahs.index'));
        }

        return view('masalahs.show')->with('masalah', $masalah);
    }

    /**
     * Show the form for editing the specified Masalah.
     */
    public function edit($id)
    {
        $masalah = $this->masalahRepository->find($id);

        if (empty($masalah)) {
            Flash::error('Masalah not found');

            return redirect(route('masalahs.index'));
        }

        return view('masalahs.edit')->with('masalah', $masalah);
    }

    /**
     * Update the specified Masalah in storage.
     */
    public function update($id, UpdateMasalahRequest $request)
    {
        $masalah = $this->masalahRepository->find($id);

        if (empty($masalah)) {
            Flash::error('Masalah not found');

            return redirect(route('masalahs.index'));
        }

        $masalah = $this->masalahRepository->update($request->all(), $id);

        Flash::success('Masalah updated successfully.');

        return redirect(route('masalahs.index'));
    }

    /**
     * Remove the specified Masalah from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $masalah = $this->masalahRepository->find($id);

        if (empty($masalah)) {
            Flash::error('Masalah not found');

            return redirect(route('masalahs.index'));
        }

        $this->masalahRepository->delete($id);

        Flash::success('Masalah deleted successfully.');

        return redirect(route('masalahs.index'));
    }
}
