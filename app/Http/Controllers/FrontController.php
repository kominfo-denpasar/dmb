<?php

namespace App\Http\Controllers;
use Ichtrojan\Otp\Otp;

use App\Models\Masyarakat;
use App\Models\Psikolog;
use App\Models\dasshasil;
use App\Models\keluhan;
use App\Models\jadwal;
use App\Models\Konseling;
use App\Models\Evaluasi;
use App\Models\Blog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Traits\dateTransform;

use Carbon\Carbon;

use Artesaos\SEOTools\Facades\SEOTools;

class FrontController extends Controller
{

	use dateTransform;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index()
	{
		// dd(\App::getLocale());
		$psikolog = Psikolog::where('status', 1)->take(3)->inRandomOrder()->get();
		$blog = Blog::join('users', 'blogs.user_id', '=', 'users.id')
					->select(
						'blogs.judul', 
						'blogs.id', 
						'blogs.slug',
						'blogs.gambar', 
						'blogs.updated_at', 
						'users.name')
					->where('status', 1)
					->inRandomOrder()
					->take(3)
					->get();

		// seo
		SEOTools::setTitle("Program Konseling Anak Sekolah");

		return view('front.home')->with([
			'psikolog' => $psikolog,
			'blog' => $blog
		]);
	}

	/**
	 * Halaman intro survei.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function surveiIntro()
	{
		// seo
		SEOTools::setTitle("Sejenak, mari renungkan diri");
        SEOTools::setDescription("Mari renungkan diri. Ketahui kondisi kesehatan mental dan saran praktis untuk diri Anda di Denpasar Menyama Bagia");
        SEOTools::opengraph()->setUrl(url('/survei'));

		return view('front.survei_intro');
	}

	/**
	 * Halaman registrasi survei.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function surveiReg()
	{
		// jika sudah ada session token dan warning dari halaman intro maka lanjutkan ke halaman berikut
		if(Session::get('mas_id') && Session::get('warning')) {
			return view('front.survei_reg', ['warning' => Session::get('warning'), 'mas_id' => Session::get('mas_id')]);
		} else {
			return redirect()->route('front.survei-intro');
		}
	}

	/**
	 * Halaman pengisian survei DASS-21.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function surveiDass()
	{
		if(Session::get('mas_id') && Session::get('warning')) {
			// ambil data pertanyaan dari database
			$dass = DB::table('dass_pertanyaans')->get();
			$no = 1;

			//ambil data masyarakat
			// $masyarakat = Masyarakat::select('nama', 'id')->where('id', Session::get('mas_id'))->first();

			// cek jika sudah pernah mengisi dass
			$dasshasil = dasshasil::latest()
				->take(3)
				->select('created_at','id')
				->where('mas_id', Session::get('mas_id'))
				->get();

			return view('front.survei_dass', compact('dass', 'no', 'dasshasil'))
			->with([
				'warning' => Session::get('warning'), 
				'mas_id' => Session::get('mas_id')
			]);
		} else {
			return redirect()->route('front.survei-intro');
		}
	}

	/**
	 * cek nik
	 *
	 * @param Request $request
	 * @return void
	 */
	public function cekNik(Request $request)
	{
		//validate form
		$this->validate($request, [
			'hp'     => 'required|numeric|min:8'
		]);

		//check hp
		$masyarakat = Masyarakat::where('hp', $request->hp)->first();

		if ($masyarakat) {
			//jika hp sudah ada 
			return redirect()->route('front.survei-dass-21')->with([
				'warning' => 'Anda sudah pernah mendaftar sebelumnya, silahkan melanjutkan untuk mengisi survei!',
				'mas_id' => $masyarakat->token
			]);
		} else {
			// jika belum maka melanjutkan ke halaman berikut serta generate id token
			$token = uniqid().Str::random(6);
			
			return redirect()->route('front.survei-reg')->with([
				'warning' => 'Silahkan mengisi data registrasi di bawah ini untuk melanjutkan!',
				'mas_id' => $token,
				'hp' => $request->hp
			]);
		}
	}

	/**
	 * simpan data pendaftaran awal
	 *
	 * @param Request $request
	 * @return void
	 */
	public function storeReg(Request $request)
	{
		//validate form
		$this->validate($request, [
			'nama'   => 'required|max:100',
			'jk'   => 'required',
			'tgl_lahir'   => 'required',
			// 'email'   => 'required',
			'hp'   => 'required',
			'mas_id'   => 'required'
		]);

		//create data
		$masyarakat = Masyarakat::create([
			'nama'   	=> $request->nama,
			'jk'     	=> $request->jk,
			'tgl_lahir'	=> $request->tgl_lahir,
			// 'email'     => $request->email,
			'hp'		=> $request->hp,
			'token'		=> $request->mas_id
		]);

		//redirect to dass21
		return redirect()->route('front.survei-dass-21')->with([
			'warning' => 'Berhasil menyimpan data!',
			'mas_id' => $masyarakat->token
		]);
	}

	/**
	 * simpan data pendaftaran awal
	 *
	 * @param Request $request
	 * @return void
	 */
	public function storeDass(Request $request)
	{
		// dd($request->all());
		//validate form
		$this->validate($request, [
			// 'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			'mas_id'     => 'required'
		]);

		//ambil data id token & hp masyarakat
		$masyarakat = Masyarakat::select('nama', 'token', 'hp')->where('token', $request->mas_id)->first();

		//jumlahkan nilai array
		$sum_d = array_sum($request->nilai_d);
		$sum_a = array_sum($request->nilai_a);
		$sum_s = array_sum($request->nilai_s);

		//upload image
		// $image = $request->file('image');
		// $image->storeAs('public/posts', $image->hashName());

		// depresi
		if ($sum_d <= 4) {
			$hasil_d = 'Normal';
		} elseif ($sum_d >= 5 && $sum_d <= 6) {
			$hasil_d = 'Mild';
		} elseif ($sum_d >= 7 && $sum_d <= 10) {
			$hasil_d = 'Moderate';
		} elseif ($sum_d >= 11 && $sum_d <= 13) {
			$hasil_d = 'Severe';
		} elseif ($sum_d >= 14) {
			$hasil_d = 'Extreme Severe';
		}

		// anxiety
		if ($sum_a <= 3) {
			$hasil_a = 'Normal';
		} elseif ($sum_a >= 4 && $sum_a <= 5) {
			$hasil_a = 'Mild';
		} elseif ($sum_a >= 6 && $sum_a <= 7) {
			$hasil_a = 'Moderate';
		} elseif ($sum_a >= 8 && $sum_a <= 9) {
			$hasil_a = 'Severe';
		} elseif ($sum_a >= 10) {
			$hasil_a = 'Extreme Severe';
		}

		// stress
		if ($sum_s <= 7) {
			$hasil_s = 'Normal';
		} elseif ($sum_s >= 8 && $sum_s <= 9) {
			$hasil_s = 'Mild';
		} elseif ($sum_s >= 10 && $sum_s <= 12) {
			$hasil_s = 'Moderate';
		} elseif ($sum_s >= 13 && $sum_s <= 16) {
			$hasil_s = 'Severe';
		} elseif ($sum_s >= 17) {
			$hasil_s = 'Extreme Severe';
		}

		$hasil = "Depresi: $hasil_d\nAnxiety: $hasil_a\nStress: $hasil_s";

		if($hasil_d == 'Normal' && $hasil_a == 'Normal' && $hasil_s == 'Normal') {
			$hasil_text = "Hasil tes Anda menunjukkan kondisi kesehatan mental yang berada dalam batas normal. Ini artinya, Anda mungkin sudah cukup baik dalam mengelola stres, kecemasan, atau suasana hati. Namun, kesehatan mental tetap penting untuk dijaga, lho! Jika Anda ingin berdiskusi atau memperdalam pemahaman tentang diri, klik tombol di bawah untuk menjadwalkan konseling gratis. Kami siap mendengarkan!";
			$hasil_status = 'Normal';
		} elseif($hasil_d == 'Extreme Severe' || $hasil_a == 'Extreme Severe' || $hasil_s == 'Extreme Severe') {
			$hasil_text = "Hasil tes menunjukkan gejala yang sangat serius dan perlu tindakan segera. Anda mungkin merasa sangat tertekan, cemas, atau sedih. Kondisi ini bisa sangat mengganggu aktivitas sehari-hari dan kualitas hidup Anda. Jangan biarkan kondisi ini berlarut-larut. Klik tombol di bawah untuk konseling gratis dan izinkan kami membantu Anda melewati ini.";
			$hasil_status = 'Extreme Severe';
		} elseif($hasil_d == 'Severe' || $hasil_a == 'Severe' || $hasil_s == 'Severe') {
			$hasil_text = "Hasil tes menunjukkan gejala yang cukup serius. Anda mungkin merasa stres yang sangat berat, sering diliputi kecemasan, atau suasana hati yang begitu rendah hingga mengganggu aktivitas sehari-hari. Kami paham ini tidak mudah, tapi Anda tidak perlu menghadapi ini sendirian. Silahkan tombol di bawah untuk konseling gratis dan izinkan kami membantu Anda melewati ini.";
			$hasil_status = 'Severe';
		} elseif($hasil_d == 'Moderate' || $hasil_a == 'Moderate' || $hasil_s == 'Moderate') {
			$hasil_text = "Hasil tes menunjukkan adanya gejala sedang. Ini mungkin berarti Anda sering merasa lelah secara emosional, khawatir yang berlebihan, atau merasa sedih tanpa alasan yang jelas. Kondisi ini penting untuk diperhatikan agar tidak menjadi lebih berat. Yuk, cari cara untuk kembali seimbang. Klik tombol di bawah untuk konseling gratis, kami ada untuk mendukung Anda!";
			$hasil_status = 'Moderate';
		} elseif($hasil_d == 'Mild' || $hasil_a == 'Mild' || $hasil_s == 'Mild') {
			$hasil_text = "Hasil tes menunjukkan adanya gejala ringan. Mungkin Anda sedang merasa sedikit lelah, stres, atau cemas, tapi masih bisa diatasi. Meski begitu, ada baiknya untuk mulai memahami kondisi ini lebih dalam sebelum berkembang lebih jauh. Silahkan klik tombol di bawah untuk konseling gratis dan obrolkan lebih lanjut dengan psikolog kami.";
			$hasil_status = 'Mild';
		}

		//create data hasil dass
		dasshasil::create([
			'mas_id'     	=> $masyarakat->token,
			'nilai_d'   	=> $sum_d,
			'nilai_s'     	=> $sum_s,
			'nilai_a'		=> $sum_a,
			'hasil_akhir'	=> $hasil
		]);
		
		// kirim whatsapp
		$data = [
			'phone' => '0'.$masyarakat->hp,
			'message' => "Halo $masyarakat->nama, berikut adalah hasil survei Anda:\n\n$hasil_text\n\nTerima kasih telah mengikuti survei ini.\n\nJika Anda ingin melakukan konseling, dapat mengklik link berikut: ".route('front.konseling-store-reg', $masyarakat->token)."\n\nSalam, Denpasar Menyama Bagia"
		];
		
		// script
		$this->notif_wa($data);

		//redirect
		return redirect()->route('front.survei-hasil')->with([
			'success' => 'Berhasil menyimpan data!',
			'hasil' => $hasil_text,
			'mas_id' => $masyarakat->token,
			'status' => $hasil_status,
		]);
	}

	/**
	 * Halaman hasil survei DASS-21.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function surveiHasil()
	{
		if(Session::get('success') && Session::get('hasil')) {
			return view('front.survei_hasil')
				->with([
					'success' => Session::get('success'), 
					'hasil' => Session::get('hasil')
				]);
		} else {
			return redirect()->route('front.survei-intro');
		}
	}

	/**
	 * Halaman registrasi konseling.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function konselingReg()
	{
		if(Session::get('success') && Session::get('mas_id')) {
			return view('front.konseling_reg', [
				'mas_id' => Session::get('mas_id'), 
				'success' => Session::get('success')]
			);
		} else {
			return redirect()->route('front.survei-intro');
		}
	}

	/**
	 * Proses registrasi konseling.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function konselingStoreReg($id)
	{
		// ambil data masyarakat dan cek apakah belum terverifikasi
		$masyarakat = Masyarakat::select('token', 'nama', 'hp')
			->where([
				'token' => $id
			])
			->first();

		// generate otp
		$otp = (new Otp)->generate($masyarakat->token, 'numeric', 6, 15);

		// dd($otp);

		// kirim whatsapp
		$data = [
			'phone' => '0'.$masyarakat->hp,
			'message' => "Halo $masyarakat->nama, berikut adalah kode OTP Anda.\n\nKode: $otp->token \n\nSilahkan input kode pada field yang sudah disediakan pada website. Mohon tidak menyebarkan kode ini kepada orang lain. Kode ini hanya berlaku selama 15 menit.\n\nSalam, Denpasar Menyama Bagia"
		];
		
		// script
		$this->notif_wa($data);

		return redirect()->route('front.konseling-reg')
			->with([
				'success' => 'Kode OTP berhasil dikirimkan!',
				'mas_id' => $masyarakat->token
			]);
	}

	/**
	 * validasi otp
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function validasiOtp(Request $request)
	{
		//ambil data masyarakat
		// $masyarakat = Masyarakat::where('id', $request->mas_id)
		// 	->select('id')
		// 	->first();
		// dd($request->otp);

		//cek otp
		$otp = (new Otp)->validate($request->mas_id, $request->otp);

		if ($otp->status) {
			// ganti status masyarakat
			$masyarakat = Masyarakat::where('token', $request->mas_id)
				->update([
					'status' => '1'
				]);

			return redirect()->route('front.konseling-keluhan', $request->mas_id)
				->with([
					'keluhan' => true
				]);
		} else {
			// jika salah
			return redirect()->route('front.konseling-reg')->with([
				'success' => $otp->message,
				'mas_id' => $request->mas_id
			]);
		}
	}

	/**
	 * Halaman regis keluhan.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function konselingKeluhan($id)
	{
		// cek apakah sudah verifikasi otp & sudah mengisi form keluhan
		// $masyarakat = Masyarakat::join('keluhans', 'masyarakats.token', '=', 'keluhans.mas_id')
		// 	->select('masyarakats.*', 'keluhans.keluhan')
		// 	->where([
		// 		'masyarakats.token' => $id,
		// 		'masyarakats.status' => '1'
		// 	])
		// 	->first();

		$masyarakat = Masyarakat::select('masyarakats.*')
			->where([
				'masyarakats.token' => $id,
				'masyarakats.status' => '1'
			])
			->first();

		// cek data keluhan
		$keluhan = keluhan::where([
			'mas_id' => $id
			])
		->whereIn('status', [0, 1])
		->first();

		// cek data konseling
		$konseling = Konseling::where([
			'mas_id' => $id
		])
		->whereIn('status', [0, 1])
		->first();

		// dd($keluhan);

		if($keluhan && $konseling) {
			// dd('test');
			// jika sudah mengisi keluhan & status konseling belum disetujui dan belum selesai
			return redirect()->route('front.konseling-final', $id)->with([
				'mas_id' => $id,
				'jadwal' => true
			]);
		} elseif (!$keluhan) {
			return view('front.konseling_keluhan', ['masyarakat' => $masyarakat]);
		} elseif ($keluhan->jadwal_id == null) {
			//redirect to jadwal
			return redirect()->route('front.konseling-jadwal', $id)->with([
				'mas_id' => $id
			]);
		} else {
			return redirect()->route('front.survei-intro');
		}
	}

	/**
	 * Halaman regis jadwal.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function konselingJadwal($id)
	{
		// cek apakah sudah verifikasi otp
		$masyarakat = Masyarakat::where('token', $id)
			->where('status', '1')
			->first();

		// cek jika sudah mengisi form keluhan
		$keluhan = keluhan::where([
			'mas_id' => $id,
			'status' => 0,
		])
		->first();

		if ($keluhan->psikolog_id != null) {
			// jika sudah mengisi keluhan & jadwal
			return redirect()->route('front.konseling-final', $id)->with([
				'mas_id' => $id,
				'jadwal' => true
			]);
		} elseif ($keluhan && $masyarakat) {
			// jika sudah mengisi keluhan tetapi belum mengisi jadwal

			// get data master psikolog
			$psikolog = Psikolog::where('status', 1)
				->get();

			return view('front.konseling_jadwal', [
				'masyarakat' => $masyarakat,
				'psikolog' => $psikolog
			]);
		} else {
			return redirect()->route('front.survei-intro');
		}
	}

	/**
	 * simpan data pendaftaran konseling bagian keluhan
	 *
	 * @param Request $request
	 * @return void
	 */
	public function konselingKeluhanStore(Request $request)
	{
		//validate form
		$this->validate($request, [
			'nik'   => 'required|numeric',
			'status_kawin'   => 'required',
			'pendidikan'   => 'required',
			'pekerjaan'   => 'required',
			'email'   => 'required',
			'kec_id'   => 'required',
			'desa_id'   => 'required',
			'alamat'   => 'required',
			
			'keluhan'   => 'required',
			'waktu_kapan'   => 'required',
			'nilai_mengganggu'   => 'required',

			'mas_id'   => 'required'
		]);

		//update data
		$masyarakat = Masyarakat::where(['token' => $request->mas_id])
		->update([
			'nama'   			=> $request->nama,
			'nik'     			=> $request->nik,
			'status_kawin'     	=> $request->status_kawin,
			'pendidikan'		=> $request->pendidikan,
			'pekerjaan'			=> $request->pekerjaan,
			'email'     		=> $request->email,
			'kec_id'   			=> $request->kec_id,
			'desa_id'     		=> $request->desa_id,
			'alamat'			=> $request->alamat
		]);

		// create data keluhan
		$keluhan = keluhan::create([
			'mas_id'     	=> $request->mas_id,
			'keluhan'		=> $request->keluhan,
			'waktu_kapan'	=> $request->waktu_kapan,
			'nilai_mengganggu'	=> $request->nilai_mengganggu
		]);

		//redirect to jadwal
		return redirect()->route('front.konseling-jadwal', $request->mas_id)->with([
			'mas_id' => $request->mas_id
		]);
	}

	/**
	 * Get data jadwal.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function jadwalPsikolog($id)
	{
		// get jadwal
		$jadwal = jadwal::where('psikolog_id', $id)
			->get();

		// cek apakah jadwal belum terisi oleh masyarakat lain
		$eventResult = [];
		foreach($jadwal as $key => $value) {
			$date = $this->getUpcomingDatesByDayName($value->hari);
			foreach($date as $k => $v) {
				$eventResult[] = array(
					"date" => $v,
					"times" => explode(',', $value->jam)
				);
			}
		}

		// 1. Ambil semua jadwal yang sudah dipakai
		$existing = Keluhan::where('status', 0)
			->where('psikolog_id', $id)
			->get([
				'jadwal_tgl', 'jadwal_jam',
				'jadwal_alt_tgl', 'jadwal_alt_jam',
				'jadwal_alt2_tgl', 'jadwal_alt2_jam',
			]);

		// 2. Buat key lookup seperti "2025-05-28|09:00"
		$used = [];

		foreach ($existing as $item) {
			$kombinasi = [
				[$item->jadwal_tgl, $item->jadwal_jam],
				[$item->jadwal_alt_tgl, $item->jadwal_alt_jam],
				[$item->jadwal_alt2_tgl, $item->jadwal_alt2_jam],
			];

			foreach ($kombinasi as [$tgl, $jam]) {
				if ($tgl && $jam) {
					$tglStr = Carbon::parse($tgl)->format('Y-m-d');
					$key = $tglStr . '|' . trim($jam);
					$used[$key] = true;
				}
			}
		}

		// 3. Cek eventResult
		$filtered = [];

		foreach ($eventResult as $event) {
			$tanggal = Carbon::parse($event['date'])->format('Y-m-d');
			foreach ($event['times'] as $jam) {
				$jam = trim($jam);
				$key = $tanggal . '|' . $jam;
				if (!isset($used[$key])) {
					$filtered[] = [
						'date' => $tanggal,
						'time' => $jam,
					];
				}
			}
		}
		// dd($filtered);

		// Kelompokkan berdasarkan tanggal
		$grouped = collect($filtered)
			->groupBy('date')
			->map(function ($items, $date) {
				return [
					'date' => $date,
					'times' => $items->pluck('time')->values()->all()
				];
			})
			->values()
			->all();

		// dd($grouped);
		

		// $eventResult = array(
		// 	array("date" => "2025-05-28", "times" => ["09:00", "10:00", "13:00"]),
		// 	array("date" => "2025-05-01", "times" => ["08:00", "11:00"]),
		// 	array("date" => "2025-05-03", "times" => ["10:00", "14:00"]),
		// );

		// echo json_encode($eventResult);
		return response()->json($grouped);
		
	}

	/**
	 * simpan data pendaftaran konseling bagian jadwal
	 *
	 * @param Request $request
	 * @return void
	 */
	public function konselingJadwalStore(Request $request)
	{
		// dd($request);
		//validate form
		$this->validate($request, [
			'psikolog_id'   => 'required',
			// 'jadwal_id'   => 'required',
			'mas_id'   => 'required',
			'utama'   => 'required',
			'alternatif'   => 'required'
		]);

		// updata data keluhan
		$keluhan = keluhan::where(['mas_id' => $request->mas_id, 'status' => 0])
		->update([
			'psikolog_id'   	=> $request->psikolog_id,
			// 'jadwal_id'     	=> $request->jadwal_id,
			'jadwal_tgl'     	=> $request->utama['tanggal'],
			'jadwal_jam'     	=> $request->utama['jam'],
			'jadwal_alt_tgl'   	=> $request->alternatif['tanggal'],
			'jadwal_alt_jam'   	=> $request->alternatif['jam']
		]);

		//redirect to konseling final
		return redirect()->route('front.konseling-final', $request->mas_id)->with([
			'mas_id' => $request->mas_id,
			'jadwal' => true
		]);
	}

	/**
	 * Halaman final konseling.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function konselingFinal($id)
	{
		//ambil data join masyarakat, keluhan dan jadwal
		$masyarakat = Masyarakat::join('keluhans', 'masyarakats.token', '=', 'keluhans.mas_id')
			->join('psikologs', 'keluhans.psikolog_id', '=', 'psikologs.id')
			->select(
				'masyarakats.token', 
				'masyarakats.nik', 
				'masyarakats.nama', 
				'masyarakats.hp', 
				'keluhans.keluhan', 
				'keluhans.jadwal_tgl', 
				'keluhans.status', 
				'keluhans.jadwal_jam', 
				'psikologs.id as psikolog_id',
				'psikologs.nama as psikolog',
				'psikologs.alamat_praktek',
				'psikologs.hp as psikolog_hp'
			)
			->where('masyarakats.token', $id)
			->where(function($query) {
				$query->where('keluhans.status', 0)
					->orWhere('keluhans.status', 1);
			})
			->first();
		
		// dd($masyarakat);

		// cek tabel konseling apakah sudah ada data yg statusnya belum
		$cek = Konseling::where([
				'mas_id' => $id,
				'status' => 0
			])->first();

		if (!$cek) {
			// jika belum ada data konseling
			//create data konseling
			Konseling::create([
				'hasil'   			=> null,
				'kesimpulan'   		=> null,
				'saran'   			=> null,
				'berkas_pendukung'  => null,
				'status'   			=> 0,
				'psikolog_id'   	=> $masyarakat->psikolog_id,
				'mas_id'   			=> $id
			]);

			// kirim whatsapp untuk user pemohon & psikolog
			$alamat_web = url()->to('/').'/login';
			$data =[
				'phone' => '0'.$masyarakat->psikolog_hp,
				'message' => "Halo $masyarakat->psikolog, berikut adalah detail jadwal konseling Anda:\n\nTanggal: $masyarakat->jadwal_tgl\nJam: $masyarakat->jadwal_jam\nKlien: $masyarakat->nama\nNomor HP Klien: 0$masyarakat->hp\n\nUntuk masuk ke dalam sistem Anda dapat mengakses alamat ini: $alamat_web \nSalam, Denpasar Menyama Bagia"
			];
			$this->notif_wa($data);

			$data = [
				'phone' => '0'.$masyarakat->hp,
				'message' => "Halo $masyarakat->nama, berikut adalah detail jadwal konseling Anda:\n\nTanggal: $masyarakat->jadwal_tgl\nJam: $masyarakat->jadwal_jam\nPsikolog: $masyarakat->psikolog\nNomor HP Psikolog: 0$masyarakat->psikolog_hp\nAlamat Praktek Psikolog: 0$masyarakat->alamat_praktek\n\nSampai jumpa nanti!\n\nSalam, Denpasar Menyama Bagia"
			];
			$this->notif_wa($data);
		}

		// cek apakah sudah mengisi semua form konseling
		if(Session::get('jadwal') && $masyarakat) {
			//get data konten dari tabel pengaturan
			$selanjutnya = DB::table('pengaturans')
				->select('value')
				->where('slug', 'selanjutnya')
				->first();

			$jika_lewat = DB::table('pengaturans')
				->select('value')
				->where('slug', 'jika-lewat')
				->first();

			return view('front.konseling_final', [
				'mas_id' => $id, 
				'masyarakat' => $masyarakat,
				'selanjutnya' => $selanjutnya,
				'jika_lewat' => $jika_lewat
				]);
		} else {
			return redirect()->route('front.survei-intro');
		}
	}

	/**
	 * Halaman Formulir Evaluasi.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function formulirEvaluasi($id)
	{
		//ambil data join masyarakat, keluhan dan jadwal
		$masyarakat = Masyarakat::join('keluhans', 'masyarakats.token', '=', 'keluhans.mas_id')
			->join('psikologs', 'keluhans.psikolog_id', '=', 'psikologs.id')
			->select(
				'masyarakats.nik', 
				'masyarakats.nama', 
				'masyarakats.hp', 
				'keluhans.id as keluhan_id', 
				'psikologs.id as psikolog_id',
				'psikologs.nama as psikolog',
				'psikologs.alamat_praktek',
				'psikologs.hp as psikolog_hp')
			->where([
				'masyarakats.token' => $id,
				'keluhans.status' => 1
			])
			->first();

		// cek jika sudah mengisi form evaluasi
		$evaluasi = Evaluasi::where([
			'mas_id' => $id,
			'psikolog_id' => $masyarakat->psikolog_id,
			'keluhan_id' => $masyarakat->keluhan_id
		])->first();
		

		// dd($masyarakat);

		if($masyarakat && !$evaluasi) {
			return view('front.evaluasi', [
				'mas_id' => $id, 
				'masyarakat' => $masyarakat]
			);
		} else {
			return redirect()->route('front.survei-intro');
		}
	}

	/**
	 * simpan data evaluasi
	 *
	 * @param Request $request
	 * @return void
	 */
	public function storeEvaluasi(Request $request)
	{
		//validate form
		$this->validate($request, [
			'nilai_layanan'   => 'required',
			'nilai_keluhan'   => 'required',
			'rekomendasi'   => 'required'
		]);

		// dd($request->all());

		//simpan data
		$evaluasi = Evaluasi::create([
			'nilai_layanan'   	=> $request->nilai_layanan,
			'nilai_keluhan'   	=> $request->nilai_keluhan,
			'rekomendasi'   	=> $request->rekomendasi,
			'keluhan_id'   		=> $request->keluhan_id,
			'mas_id'   			=> $request->mas_id,
			'psikolog_id'   	=> $request->psikolog_id
		]);

		//redirect to finish
		return view('front.evaluasi_selesai');
	}

	/**
	 * view halaman faq
	 *
	 * @param Request $request
	 * @return void
	 */
	public function faq()
	{
		//get data faq dari tabel pengaturan
		$faq = DB::table('pengaturans')
			->where('slug', 'faq')
			->first();

		// seo
		SEOTools::setTitle(__('front.faq'));
        SEOTools::setDescription("List pertanyaan yang sering ditanyakan");
        SEOTools::opengraph()->setUrl(url('/faq'));
		
		return view('front.faq')->with([
			'faq' => $faq
		]);
	}

	/**
	 * view halaman privasi
	 *
	 * @param Request $request
	 * @return void
	 */
	public function privasi()
	{
		//get data dari tabel pengaturan
		$data = DB::table('pengaturans')
			->where('slug', 'privasi')
			->first();

		// seo
		SEOTools::setTitle('Kebijakan Privasi');
        SEOTools::setDescription("Kebijakan Privasi Denpasar Menyama Bagia");
        SEOTools::opengraph()->setUrl(url('/privasi'));
		
		return view('front.privasi')->with([
			'data' => $data
		]);
	}

	/**
	 * view halaman detail blog
	 *
	 * @param Request $request
	 * @return void
	 */
	public function blogDetail($slug)
	{
		//get data faq dari tabel pengaturan
		$blog = DB::table('blogs')
			->join('users', 'blogs.user_id', 'users.id')
			->select(
				'blogs.judul',
				'blogs.deskripsi',
				'blogs.gambar',
				'blogs.updated_at',
				'users.name')
			->where('slug', $slug)
			->first();
		

		if($blog) {
			// seo
			SEOTools::setTitle($blog->judul);
			SEOTools::setDescription(str_limit(strip_tags($blog->deskripsi), $limit = 150, $end = '...'));
			SEOTools::opengraph()->setUrl(url('/artikel/'.$slug));
			SEOTools::opengraph()->addProperty('type', 'articles');
			// SEOTools::twitter()->setSite('@LuizVinicius73');
			if(file_exists(storage_path('app/public/uploads/blog/'.$blog->gambar))) {
				SEOTools::jsonLd()->addImage(asset('/storage/uploads/blog/'.$blog->gambar));
				SEOTools::addImages(url('/storage/uploads/blog/'.$blog->gambar));
			} else {
				SEOTools::jsonLd()->addImage(asset('img/pp_user.jpg'));
				SEOTools::addImages(url('img/pp_user.jpg'));
			}

			return view('front.blog_detail')->with([
				'blog' => $blog
			]);
		} else {
			return view('front.404');
		}
	
	}

	/**
	 * view halaman list blog
	 *
	 * @param Request $request
	 * @return void
	 */
	public function blogList()
	{
		//get data faq dari tabel pengaturan
		$blogs = DB::table('blogs')
			->join('users', 'blogs.user_id', 'users.id')
			->select(
				'blogs.judul',
				'blogs.deskripsi',
				'blogs.gambar',
				'blogs.slug',
				'blogs.updated_at',
				'users.name')
			->get();

		// seo
		SEOTools::setTitle(__('front.blog_title'));
        SEOTools::setDescription(__('front.blog_desc'));
        SEOTools::opengraph()->setUrl(url('/artikel'));
		
		return view('front.blog_list')->with([
			'blogs' => $blogs
		]);
	}

	/**
	 * Tes halaman
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function testHalaman()
	{
		activity()->log('Look, I logged something');
		// fungsi cek user menggunakan modul role
		// $user = config('roles.models.defaultUser')::find(1);

		// // attach role admin
		// $user->attachRole(1);
		
		// // cek apakah rolenya admin
		// if ($user->isAdmin()) {
		// 	echo "admin";
		// } else {
		// 	dd($user);
		// }

		// return view('front.konseling_final');
	}

	/**
	 * Tes notif
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function testNotif()
	{
		// kirim whatsapp untuk user pemohon
		$data = [
			'phone' => '081238921686',
			'message' => "weee",
		];
		
		// script
		$this->notif_wa($data);
	}

	/**
	 * halaman error
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function notFound() 
	{ 
		return view('front.404'); 
	}
}
