<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Masyarakat as Client;
use App\Models\dasshasil as Dass21Result;
use App\Models\Konseling;

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
        $this->user = $this->getUser();
            
        if(!$this->user->hasRole('admin')) return redirect()->route('home-psikolog');
        else return view('backend/home');
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

		// Jumlah klien per bulan
		$clients = Client::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
			->whereYear('created_at', $year)
			->groupBy('month')
			->pluck('total', 'month');

		// DASS21 per kategori per bulan
		$dass = Dass21Result::selectRaw('MONTH(created_at) as month, nilai_d, COUNT(*) as total')
			->whereYear('created_at', $year)
			->groupBy('month', 'nilai_d')
			->get()
			->groupBy('nilai_d')
			->map(function ($rows) {
				return $rows->pluck('total', 'month');
			});

		// Konseling per bulan
		$konseling = Konseling::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
			->whereYear('created_at', $year)
			->groupBy('month')
			->pluck('total', 'month');

		return response()->json([
			'clients' => $clients,
			'dass' => $dass,
			'konseling' => $konseling,
		]);
	}
}
