<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Masyarakat as Client;
use App\Models\dasshasil as Dass21Result;
use App\Models\Konseling;
use App\Models\Psikolog;
use App\Models\User;

use App\Http\Requests\UpdatePsikologRequest;
use App\Repositories\PsikologRepository;
use Flash;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

	/** @var PsikologRepository $psikologRepository*/
	private $psikologRepository;

	public $user;

	public function __construct(PsikologRepository $psikologRepo)
	{
		// cek jika user sesuai dengan rolenya untuk akses controller
		$this->middleware(function ($request, $next) {
			$this->user = $this->getUser();
			return $next($request);
		});

		$this->psikologRepository = $psikologRepo;
	}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$data = DB::table('dasshasils')
			->select('hasil_akhir', DB::raw('MONTH(created_at) as bulan'))
			->get();

		$rekap = [];

		foreach ($data as $item) {
			$lines = explode("\n", $item->hasil_akhir);
			foreach ($lines as $line) {
				if (strpos($line, ':') !== false) {
					[$kategori, $level] = array_map('trim', explode(':', $line));
					if (!isset($rekap[$kategori][$level])) {
						$rekap[$kategori][$level] = 0;
					}
					$rekap[$kategori][$level]++;
				}
			}
		}

        $this->user = $this->getUser();
            
        if(!$this->user->hasRole('admin')) return redirect()->route('home-psikolog');
        else return view('backend/home', [
			'dassPie' => $rekap
		]);
    }

    /**
	 * Tampilkan profil. 
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function profil()
	{
		$this->user = $this->getUser();

		// dd($psikolog);
		// dd($this->user->psikolog);

		if($this->user->hasRole('admin')) {
			// jika admin, tampilkan profil user
			
			return view('backend/profil', [
				'user' => $this->user
			]);
		} else if($this->user->hasRole('psikolog')) {
			$psikolog = psikolog::join('users', 'psikologs.id', '=', 'users.psikolog_id')
			->select('psikologs.*','users.email')
			->where([
				'psikologs.status' => 1,
				'psikologs.id' => $this->user->psikolog_id
			])
			->first();

			return view('backend/profil', [
				'user' => $this->user,
				'psikolog' => $psikolog,
			]); 
		}
		// 
		return view('backend/profil', [
			'user' => $this->user
		]); 
	}

	/**
	 * Update the specified Psikolog in storage.
	 */
	public function updateProfil($id, UpdatePsikologRequest $request)
	{
		$psikolog = $this->psikologRepository->find($id);

		// dd($request->password);
		if($request->password) {
			// dd($request->password);
			$data = User::where('psikolog_id', $id)->update([
				'password' => bcrypt($request->password)
			]);
		}

		// jika nomor telepon diisi, normalisasi nomer telepon
		if($request->hp) {
			$hp = $this->normalizePhoneNumber($request->hp);
			$request->merge(['hp' => $hp]);
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
			// ambil data lama
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

		// update user data
		$user = User::where('psikolog_id', $id)->first();
		if (empty($user)) {
			Flash::error('User tidak ditemukan.');
			return redirect(route('backend.profil'));
		}
		// $input = $request->all();
		if ($request->has('password') && $request->password) {
			$input['password'] = bcrypt($request->password);
		} else {
			unset($input['password']);
		}

		$input['name'] = $input['nama'];
		$result = $user->update($input);

		// update session user
		$this->user = Auth::user();
		$updatedUser = $this->user->fresh(); // Get the updated user
		Auth::setUser($updatedUser); // Update the session

		if($result && $psikolog) {
			// jika update sukses
			Flash::success('Data berhasil diupdate.');
		} else {
			// jika update gagal
			Flash::error('Data gagal diupdate.');
		}
		return redirect(route('backend.profil'));
	}

	/**
	 * Update the specified user.
	 */
	public function updateProfilAdmin($id, Request $request)
	{
		// update user data
		$user = User::find($id);
		if (empty($user)) {
			Flash::error('User tidak ditemukan.');
			return redirect(route('backend.profil'));
		}
		$input = $request->all();
		if ($request->has('password') && $request->password) {
			$input['password'] = bcrypt($request->password);
		} else {
			unset($input['password']);
		}
		$result = $user->update($input);
		// update session user
		$this->user = Auth::user();
		$updatedUser = $this->user->fresh(); // Get the updated user
		Auth::setUser($updatedUser); // Update the session
		
		
		if($result) {
			// jika update sukses
			Flash::success('Data berhasil diupdate.');
		} else {
			// jika update gagal
			Flash::error('Data gagal diupdate.');
		}
		
		return redirect(route('backend.profil'));

	}

    public function data(Request $request)
	{
		$year = $request->input('year', now()->year);
		$month = $request->input('month');

		$clientQuery = Client::whereYear('created_at', $year);
		$dassQuery = Dass21Result::whereYear('created_at', $year);
		$konselingQuery = Konseling::whereYear('created_at', $year);

		if ($month) {
			$clientQuery->whereMonth('created_at', $month);
			$dassQuery->whereMonth('created_at', $month);
			$konselingQuery->whereMonth('created_at', $month);
		}

		// Klien per bulan
		$clients = Client::selectRaw('MONTH(created_at) as month, status, COUNT(*) as total')
			->whereYear('created_at', $year)
			->when($month, fn($q) => $q->whereMonth('created_at', $month))
			->groupBy('month', 'status')
			->get()
			->groupBy('status')
			->map(fn($rows) => $rows->pluck('total', 'month'));;
		

		// Konseling per bulan
		$konseling = Konseling::selectRaw('MONTH(created_at) as month, status, COUNT(*) as total')
			->whereYear('created_at', $year)
			->when($month, fn($q) => $q->whereMonth('created_at', $month))
			->groupBy('month', 'status')
			->get()
			->groupBy('status')
			->map(fn($rows) => $rows->pluck('total', 'month'));

		return response()->json([
			'clients' => $clients,
			'konseling' => $konseling,
		]);
	}
}
