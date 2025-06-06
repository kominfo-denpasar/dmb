<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePsikologRequest;
use App\Http\Requests\UpdatePsikologRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PsikologRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Flash;
// use App\Models\LogAktivitas;
use App\Models\Psikolog;
use App\Models\User;
use App\Models\keluhan;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class PsikologController extends AppBaseController
{
	/** @var PsikologRepository $psikologRepository*/
	private $psikologRepository;

	public $user;

	public function __construct(PsikologRepository $psikologRepo)
	{
		// cek jika user sesuai dengan rolenya untuk akses controller
		$this->middleware(function ($request, $next) {
			$this->user = $this->getUser();
			
			if(!$this->user->hasRole('admin')) return redirect()->route('home');
			else return $next($request);
		});

		$this->psikologRepository = $psikologRepo;
	}

	/**
	 * Display a listing of the Psikolog.
	 */
	public function index(Request $request)
{
    if ($request->ajax()) {
        $data = Psikolog::query();

        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'arsip') {
                $data->where('status', 2);
            } else {
                $data->where('status', $request->status);
            }
        }

        return datatables()->of($data->get())
            ->addColumn('aksi', function ($row) {
                return '<a href="' . route('psikologs.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    $statusFilter = $request->input('status', '');
    $countsQuery = Psikolog::select('kec_id', DB::raw('count(*) as total'));

//	// view data berdasarkan kategori (aktif/tidak aktif)
    // if ($statusFilter != '') {
    //     if ($statusFilter == 'arsip') {
    //         $countsQuery->where('status', 2);
    //     } else {
    //         $countsQuery->where('status', $statusFilter);
    //     }
    // }
    $counts = $countsQuery->groupBy('kec_id')->pluck('total', 'kec_id');

    $psikologs = Psikolog::paginate(10);
    return view('psikologs.index', compact('psikologs', 'counts'));
}


	/**
	 * Show the form for creating a new Psikolog.
	 */
	public function create()
	{
		$psikolog = null;
		return view('psikologs.create')->with('psikolog', $psikolog);
	}

	/**
	 * Store a newly created Psikolog in storage.
	 */
	public function store(CreatePsikologRequest $request)
	{
		//validate form
		$this->validate($request, [
			'gambar'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
		]);

		$input = $request->all();
		// dd($input);

		//upload image
		if($request->file('foto')) {
			$file = $request->file('foto');
			$file_name = time().'_'.$file->getClientOriginalName();

			$year_folder = date("Y");
			$month_folder = $year_folder . '/' . date("m");

			$path = 'uploads/psikolog/'.$month_folder.'/'.$file_name;

			$file_content = file_get_contents($file);
			if(!Storage::disk('public')->put($path, $file_content)) {
				return false;
			}

			$input['foto'] = $month_folder.'/'.$file_name;
		}

		//upload image
		if($request->file('ttd')) {
			$file = $request->file('ttd');
			$file_name = time().'_'.$file->getClientOriginalName();

			$year_folder = date("Y");
			$month_folder = $year_folder . '/' . date("m");

			$path = 'uploads/psikolog/'.$month_folder.'/'.$file_name;

			$file_content = file_get_contents($file);
			if(!Storage::disk('public')->put($path, $file_content)) {
				return false;
			}

			$input['ttd'] = $month_folder.'/'.$file_name;
		}

		if(!empty($input['nik'])){
			$input['nik'] = Hash::make($request->nik);
		}

		$psikolog = $this->psikologRepository->create($input);

		activity()
		  ->causedBy(auth()->user())
		  ->performedOn($psikolog)
		  ->log('Menambahkan data psikolog');

		// buat user baru
		$user = config('roles.models.defaultUser')::create([
			'name' => $request->nama,
			'email' => $request->email,
			'psikolog_id' => $psikolog->id,
			'password' => bcrypt('AdminPsikolog#25'),
		]);

		$role = config('roles.models.role')::where('name', '=', 'Psikolog')->first();  //choose the default role upon user creation.
		$user->attachRole($role);

		// 
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

		// dd($psikolog);

		return view('psikologs.show')->with('psikolog', $psikolog);
	}

	/**
	 * Show the form for editing the specified Psikolog.
	 */
	public function edit($id)
	{
		// $psikolog = $this->psikologRepository->find($id);

		$psikolog = psikolog::where('psikologs.id', $id)
			->join('users', 'psikologs.id', '=', 'users.psikolog_id')
			->select('psikologs.*','users.email')->first();

		// dd($psikolog);

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

		// dd($request->password);
		if($request->password) {
			// 
			// dd($request->password);
			$data = User::where('psikolog_id', $id)->update([
				'password' => bcrypt($request->password)
			]);
		}

		if (empty($psikolog)) {
			Flash::error('Psikolog not found');

			return redirect(route('psikologs.index'));
		}

		$input = $request->all();

		//upload image
		if($request->file('foto')) {
			// ambil data lama
			$old_file = Psikolog::find($id);

			if ($old_file && $old_file->foto) {
				$filePath = storage_path('app/public/uploads/psikolog/' . $old_file->foto);

				// cek apakah file ada sebelum di-unlink
				if (file_exists($filePath)) {
					unlink($filePath);
				}
			}

			$file = $request->file('foto');
			$file_name = time().'_'.$file->getClientOriginalName();

			$year_folder = date("Y");
			$month_folder = $year_folder . '/' . date("m");

			$path = 'uploads/psikolog/'.$month_folder.'/'.$file_name;

			$file_content = file_get_contents($file);
			if(!Storage::disk('public')->put($path, $file_content)) {
				return false;
			}

			$input['foto'] = $month_folder.'/'.$file_name;
		}

		//upload ttd
		if($request->file('ttd')) {
			// hapus file lama
			$old_file = Psikolog::find($id);

			if ($old_file && $old_file->ttd) {
				$filePath = storage_path('app/public/uploads/psikolog/'.$old_file->ttd);

				// cek apakah file ada sebelum di-unlink
				if (file_exists($filePath)) {
					unlink($filePath);
				}
			}

			$file = $request->file('ttd');
			$file_name = time().'_'.$file->getClientOriginalName();

			$year_folder = date("Y");
			$month_folder = $year_folder . '/' . date("m");

			$path = 'uploads/psikolog/'.$month_folder.'/'.$file_name;

			$file_content = file_get_contents($file);
			if(!Storage::disk('public')->put($path, $file_content)) {
				return false;
			}

			$input['ttd'] = $month_folder.'/'.$file_name;
		}

		$psikolog = $this->psikologRepository->update($input, $id);

		activity()
		  -> causedBy(auth()->user())
		  ->performedOn($psikolog)
		  ->log('Memperbarui data psikolog');

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

		// hapus file foto dan ttd
		if ($psikolog->foto) {
			$filePath = storage_path('app/public/uploads/psikolog/' . $psikolog->foto);
			// cek apakah file ada sebelum di-unlink
			if (file_exists($filePath)) {
				unlink($filePath);
			}
		}

		if ($psikolog->ttd) {
			$filePath = storage_path('app/public/uploads/psikolog/' . $psikolog->ttd);
			// cek apakah file ada sebelum di-unlink
			if (file_exists($filePath)) {
				unlink($filePath);
			}
		}

		$this->psikologRepository->delete($id);

		Flash::success('Psikolog deleted successfully.');

		activity()
		->causedBy(auth()->user())
		->performedOn($psikolog)
		->log('Menghapus data psikolog');

		return redirect(route('psikologs.index'));
	}

	public static function kec($id) {
		$data = 'https://emsifa.github.io/api-wilayah-indonesia/api/district/'.$id.'.json';

		$res = Http::get($data);
		if($res->json()) {
			return $res->json()['name'];
		} else {
			return null;
		}
	}

	public static function desa($id) {
		$data = 'https://emsifa.github.io/api-wilayah-indonesia/api/village/'.$id.'.json';

		$res = Http::get($data);
		if($res->json()) {
			return $res->json()['name'];
		} else {
			return null;
		}
	}

	/**
     * Display data for datatable.
     *
     * @throws \Exception
     */
    public function indexJson(Request $request) {
        $sql = Psikolog::select(
            'id',
            'nama',
            'hp',
			'kec_id',
            'status'
        );

		if ($request->has('status') && $request->status != '') {
			if ($request->status == 'arsip') {
				$sql->where('status', 2);
			} else {
				$sql->where('status', $request->status);
			}
		}

		if ($request->has('kec_id') && $request->kec_id != '') {
			$sql->where('kec_id', $request->kec_id);
		}

        return Datatables::of($sql)
        ->addColumn('aksi', function($sql){
            $table = 'psikologs';
            return view('layouts/datatables_action', compact('sql', 'table'));
        })
		->editColumn('hp', function($sql){
            return "<a href='tel:62$sql->hp'>0".$sql->hp."</a>";
        })
		->editColumn('kec_id', function($sql){
            switch($sql->kec_id) {
				case '5171010':
					return "Denpasar Selatan";
					break;
				case '5171020':
					return "Denpasar Timur";
					break;
				case '5171030':
					return "Denpasar Barat";
					break;
				case '5171031':
					return "Denpasar Utara";
					break;
			}
        })
        ->editColumn('status', function($sql){
            if($sql->status==0) {
                return "<span class='badge bg-danger'> Tidak Aktif </span>";
            } elseif ($sql->status==1) {
                return "<span class='badge bg-success'> Aktif </span>";
            } else {
                return "-";
            }
        })
        ->rawColumns(['status', 'hp'])
        ->make(true);
    }

	/**
     * Display data keluhan for datatable.
     *
     * @throws \Exception
     */
    public function keluhanJson($id) {

		// get data keluhan masyarakat yang ditangani oleh psikolog
		$sql = keluhan::where('psikolog_id', $id)
			->join('masyarakats', 'keluhans.mas_id', '=', 'masyarakats.token')
			->select(
				'keluhans.id', 
				'keluhans.created_at', 
				'keluhans.status', 
				'masyarakats.nama', 
				'masyarakats.hp')
			->orderBy('keluhans.created_at', 'desc')
			->get();

        return Datatables::of($sql)
        ->addColumn('aksi', function($sql){
            $table = 'keluhans';
            return view('layouts/datatables_action_keluhan', compact('sql', 'table'));
        })
		->editColumn('created_at', function($sql){
            return $tanggal = date('d/m/Y', strtotime($sql->created_at));
        })
        ->editColumn('status', function($sql){
            if($sql->status==0) {
                return "<span class='badge bg-default'> Menunggu </span>";
            } elseif ($sql->status==1) {
                return "<span class='badge bg-warning'> On Progress </span>";
			} elseif ($sql->status==2) {
                return "<span class='badge bg-success'> Selesai </span>";
			} elseif ($sql->status==3) {
                return "<span class='badge bg-danger'>Batal </span>";
            } else {
                return "-";
            }
        })
        ->rawColumns(['status', 'hp'])
        ->make(true);
    }
}
