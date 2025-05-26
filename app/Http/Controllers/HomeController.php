<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Masyarakat as Client;
use App\Models\dasshasil as Dass21Result;
use App\Models\Konseling;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
		return view('backend/profil'); 
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
