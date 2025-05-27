<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateKonselingRequest;
use App\Http\Requests\UpdateKonselingRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\KonselingRepository;
use App\Models\Konseling;
use Illuminate\Http\Request;
use Flash;
use Yajra\Datatables\Datatables;
use App\Models\Psikolog;

class KonselingController extends AppBaseController
{
    /** @var KonselingRepository $konselingRepository*/
    private $konselingRepository;

    public function __construct(KonselingRepository $konselingRepo)
    {
        $this->konselingRepository = $konselingRepo;
    }

    /**
     * Display a listing of the Konseling.
     */
    public function index(Request $request)
    {
        $konselings = $this->konselingRepository->paginate(10);

        return view('konselings.index')
            ->with('konselings', $konselings);
    }

    /**
     * Show the form for creating a new Konseling.
     */
    public function create()
    {
        return view('konselings.create');
    }

    /**
     * Store a newly created Konseling in storage.
     */
    public function store(CreateKonselingRequest $request)
    {
        $input = $request->all();

        $konseling = $this->konselingRepository->create($input);

        Flash::success('Konseling saved successfully.');

        return redirect(route('konselings.index'));
    }

    /**
     * Display the specified Konseling.
     */
    public function show($id)
    {
        $konseling = $this->konselingRepository->find($id);

        if (empty($konseling)) {
            Flash::error('Konseling not found');

            return redirect(route('konselings.index'));
        }

        return view('konselings.show')->with('konseling', $konseling);
    }

    /**
     * Show the form for editing the specified Konseling.
     */
    public function edit($id)
    {
        $konseling = $this->konselingRepository->find($id);

        if (empty($konseling)) {
            Flash::error('Konseling not found');

            return redirect(route('konselings.index'));
        }

        return view('konselings.edit')->with('konseling', $konseling);
    }

    /**
     * Update the specified Konseling in storage.
     */
    public function update($id, UpdateKonselingRequest $request)
    {
        $konseling = $this->konselingRepository->find($id);

        if (empty($konseling)) {
            Flash::error('Konseling not found');

            return redirect(route('konselings.index'));
        }

        $konseling = $this->konselingRepository->update($request->all(), $id);

        Flash::success('Konseling updated successfully.');

        return redirect(route('konselings.index'));
    }

    /**
     * Remove the specified Konseling from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $konseling = $this->konselingRepository->find($id);

        if (empty($konseling)) {
            Flash::error('Konseling not found');

            return redirect(route('konselings.index'));
        }

        $this->konselingRepository->delete($id);

        Flash::success('Konseling deleted successfully.');

        return redirect(route('konselings.index'));
    }

     /**
     * Get Masyarakat data for DataTables.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function masyarakatJson($mas_id)
    {

        // get data by mas_id
        $sql = Konseling::where('mas_id', $mas_id)
            ->join('masyarakats', 'konselings.mas_id', '=', 'masyarakats.token')
            ->leftJoin('psikologs', 'konselings.psikolog_id', '=', 'psikologs.id')
            ->select(
                'konselings.id',
                'konselings.created_at',
                'psikologs.nama',
                'konselings.hasil',
                'konselings.kesimpulan',
                'konselings.saran',
                'konselings.status',
            )
            ->orderBy('konselings.created_at', 'desc')
            ->get();

            // get all data withou filtering id masyarakat
        // $sql = Konseling::select([
        //     'id',
        //     'created_at',
        //     'psikolog_id',
        //     'hasil',
        //     'kesimpulan',
        //     'saran',
        //     'status'
        // ]);

        return DataTables::of($sql)
            ->addColumn('aksi', function($sql){
                return view('layouts/datatables_action_masyarakat', compact('sql'));
            })
            ->editColumn('created_at', function($sql){
                return date('d/m/Y', strtotime($sql->created_at));
            })
            ->editColumn('status', function($sql){
                if ($sql->status == 2) return "<span class='badge bg-success'>Selesai</span>";
                if ($sql->status == 1) return "<span class='badge bg-warning'>On Progress</span>";
                if ($sql->status == 3) return "<span class='badge bg-danger'>Batal</span>";
                return "<span class='badge bg-info'>Menunggu</span>";
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
    }
}
