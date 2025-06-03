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
use App\Models\Masyarakat;
use App\Models\Keluhan;
use App\Models\KonselingMasalah;
use App\Models\Masalah;
use App\Models\Evaluasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        // $sql = Konseling::where('mas_id', $mas_id)
        //     ->join('masyarakats', 'konselings.mas_id', '=', 'masyarakats.token')
        //     ->leftJoin('psikologs', 'konselings.psikolog_id', '=', 'psikologs.id')
        //     ->select(
        //         'konselings.id',
        //         'konselings.created_at',
        //         'psikologs.nama',
        //         'konselings.hasil',
        //         'konselings.kesimpulan',
        //         'konselings.saran',
        //         'konselings.status',
        //     )
        //     ->orderBy('konselings.created_at', 'desc')
        //     ->get();

        $sql = Konseling::where('konselings.mas_id', $mas_id)
                    ->join('masyarakats', 'konselings.mas_id', '=', 'masyarakats.token')
                    ->join('keluhans', 'konselings.keluhan_id', '=', 'keluhans.id')
                    ->leftJoin('psikologs', 'konselings.psikolog_id', '=', 'psikologs.id')
                    ->select(
                        'konselings.id',
                        'konselings.created_at',
                        // 'konselings.keluhan_id',
                        'psikologs.nama',
                        'konselings.hasil',
                        'konselings.kesimpulan',
                        'konselings.saran',
                        'konselings.status',
                    )
                    ->orderBy('konselings.created_at', 'desc')
                    ->get();

        return DataTables::of($sql)
            ->addColumn('aksi', function($sql){
                return view('layouts/datatables_action_masyarakat', compact('sql'));
                // return view('layouts/datatables_action_masyarakat', ['sql' => $sql]);
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

    /**
	 * Tampilkan detail data konseling. 
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function konselingDetails($id)
	{
        // dd($id);
		// ambil data keluhan, konseling, dass dan detail masyarakat/klien
        $data = Konseling::where('konselings.keluhan_id', $id)
                    ->join('masyarakats', 'konselings.mas_id', '=', 'masyarakats.token')
                    ->join('keluhans', 'keluhans.id', '=', 'konselings.keluhan_id')
                    ->join('psikologs', 'konselings.psikolog_id', '=', 'psikologs.id')
                    ->join('dasshasils', 'masyarakats.token', '=', 'dasshasils.mas_id')
		// $data = Masyarakat::where('keluhans.id', $id)
		// 	->join('keluhans', 'masyarakats.token', '=', 'keluhans.mas_id')
		// 	->join('konselings', 'masyarakats.token', '=', 'konselings.mas_id')
		// 	->join('psikologs', 'konselings.psikolog_id', '=', 'psikologs.id')
		// 	->join('dasshasils', 'masyarakats.token', '=', 'dasshasils.mas_id')
			->select(
				'masyarakats.nama',
				'masyarakats.nik',
				'masyarakats.jk',
				'masyarakats.hp',
				'masyarakats.pekerjaan',
				'masyarakats.pendidikan',
				'masyarakats.alamat', 
				'masyarakats.token', 
				'keluhans.*',
				'keluhans.id as keluhan_id', 
				'keluhans.jadwal_jam as jamnya',
				'konselings.id as konseling_id',
				'psikologs.nama as psikolog_nama',
				'psikologs.id as psikolog_id', 
				'dasshasils.*'
			)
			->first();
		
		// dd($data);

		// cek apakah ada data, jika iya maka tampilkan halaman detail konseling
		if($data) {
			// cek apakah psikolog yang login adalah psikolog yang ditunjuk dan apakah user adalah admin?
			if(!$this->getUser()->hasRole('admin')) {
				if($data->psikolog_id != $this->getUser()->psikolog_id) {
					return redirect()->route('home-psikolog')->with('message', 'Anda tidak memiliki akses ke halaman ini');
				}
			}

			// get data riwayat konseling
			$riwayat_konseling = keluhan::where([
				'mas_id' => $data->token,
			])
				->where('id', '<>', $data->keluhan_id)
				->orderBy('created_at', 'desc')
				->get();
			// dd($riwayat_konseling);

			// get data masalah
			$masalah = Masalah::get();

			// status == 0 -> konseling belum mulai
			if($data->status!=0) {
				// get data konseling
				$konseling = Konseling::where('id', $data->konseling_id)
				->select(
					'hasil',
					'kesimpulan',
					'saran',
					'berkas_pendukung', 
				)
				->first();

				$konseling = [
					'hasil' => $konseling->hasil,
					'kesimpulan' => $konseling->kesimpulan,
					'saran' => $konseling->saran,
					'berkas_pendukung' => $konseling->berkas_pendukung
				];

				// get data evaluasi
				$evaluasi = Evaluasi::where('keluhan_id', $data->keluhan_id)->first();

				// get data konseling masalah
				$konseling_masalah = KonselingMasalah::where('konseling_id', $data->konseling_id)->get();
				$konseling_masalah = $konseling_masalah->map(function($item) {
					return $item->masalah_id;
				})->toArray();
			} else {
				$konseling = [
					'hasil' => null,
					'kesimpulan' => null,
					'saran' => null,
					'berkas_pendukung' => null
				];
				$evaluasi = null;
				$konseling_masalah = [];

				
			}

			// dd($data->konseling_id);

			return view('backend/konseling')->with([
				'data' => $data,
				'masalah' => $masalah,
				'riwayat_konseling' => $riwayat_konseling,
				'konseling' => $konseling,
				'konseling_masalah' => $konseling_masalah,
				'evaluasi' => $evaluasi,
				'user' => $this->getUser()
			]);
		} else {
			return redirect()->route('home-psikolog')->with('message', 'Tidak ada data yang ditemukan');
		}
			
	}
}
