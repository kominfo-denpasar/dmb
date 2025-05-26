<?php

namespace App\Http\Controllers;

use App\DataTables\MasyarakatDataTable;
use App\Http\Requests\CreateMasyarakatRequest;
use App\Http\Requests\UpdateMasyarakatRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\MasyarakatRepository;
use Illuminate\Http\Request;
use Flash;

class MasyarakatController extends AppBaseController
{
    /** @var MasyarakatRepository $masyarakatRepository*/
    private $masyarakatRepository;

    public $user;

    public function __construct(MasyarakatRepository $masyarakatRepo)
    {
        // cek jika user sesuai dengan rolenya untuk akses controller
        $this->middleware(function ($request, $next) {
            $this->user = $this->getUser();
            
            if(!$this->user->hasRole('admin')) return redirect()->route('home');
            else return $next($request);
        });

        $this->masyarakatRepository = $masyarakatRepo;
    }

    /**
     * Display a listing of the Masyarakat.
     */
    public function index(MasyarakatDataTable $masyarakatDataTable)
    {
        // $masyarakats = $this->masyarakatRepository->paginate(10);

        return $masyarakatDataTable->render('masyarakats.index');

        // return view('masyarakats.index')
        //     ->with('masyarakats', $masyarakats);
    }

    /**
     * Show the form for creating a new Masyarakat.
     */
    public function create()
    {
        return view('masyarakats.create');
    }

    /**
     * Store a newly created Masyarakat in storage.
     */
    public function store(CreateMasyarakatRequest $request)
    {
        $input = $request->all();

        $masyarakat = $this->masyarakatRepository->create($input);

        Flash::success('Masyarakat saved successfully.');

        return redirect(route('masyarakats.index'));
    }

    /**
     * Display the specified Masyarakat.
     */
    public function show($id)
    {
        $masyarakat = $this->masyarakatRepository->find($id);

        if (empty($masyarakat)) {
            Flash::error('Masyarakat not found');

            return redirect(route('masyarakats.index'));
        }

        return view('masyarakats.show')->with('masyarakat', $masyarakat);
    }

    /**
     * Show the form for editing the specified Masyarakat.
     */
    public function edit($id)
    {
        $masyarakat = $this->masyarakatRepository->find($id);

        if (empty($masyarakat)) {
            Flash::error('Masyarakat not found');

            return redirect(route('masyarakats.index'));
        }

        return view('masyarakats.edit')->with('masyarakat', $masyarakat);
    }

    /**
     * Update the specified Masyarakat in storage.
     */
    public function update($id, UpdateMasyarakatRequest $request)
    {
        $masyarakat = $this->masyarakatRepository->find($id);

        if (empty($masyarakat)) {
            Flash::error('Masyarakat not found');

            return redirect(route('masyarakats.index'));
        }

        $masyarakat = $this->masyarakatRepository->update($request->all(), $id);

        Flash::success('Masyarakat updated successfully.');

        return redirect(route('masyarakats.index'));
    }

    /**
     * Remove the specified Masyarakat from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $masyarakat = $this->masyarakatRepository->find($id);

        if (empty($masyarakat)) {
            Flash::error('Masyarakat not found');

            return redirect(route('masyarakats.index'));
        }

        $this->masyarakatRepository->delete($id);

        Flash::success('Masyarakat deleted successfully.');

        return redirect(route('masyarakats.index'));
    }
}
