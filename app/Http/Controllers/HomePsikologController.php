<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Masyarakat;
use App\Models\Psikolog;
use App\Models\Konseling;
use App\Models\keluhan;
use App\Models\Masalah;
use App\Models\KonselingMasalah;
use App\Models\Evaluasi;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PhpMailController;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class HomePsikologController extends Controller
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
		// cek supaya hanya user psikolog yang dapat mengakses
		if($this->getUser()->hasRole('psikolog')) {
			
			// get data psikolog
			$psikolog = Psikolog::where('id', $this->getUser()->psikolog_id)->first();

			// get data keluhan masyarakat yang ditangani oleh psikolog
			$keluhan = keluhan::where('psikolog_id', $this->getUser()->psikolog_id)
				->join('masyarakats', 'keluhans.mas_id', '=', 'masyarakats.token')
				->select(
					'keluhans.*', 
					'masyarakats.nama', 
					'masyarakats.hp', 
					'jadwal_alt2_tgl as tanggal_konseling', 
					'jadwal_alt2_jam as jam_konseling'
				)
				->orderBy('keluhans.status', 'asc')
				->orderBy('keluhans.created_at', 'desc')
				->get();
			
			// dd($keluhan);

			// data dashboard
			$dashboard = [
				'konseling_belum' => Keluhan::where([
					'psikolog_id' => $this->getUser()->psikolog_id,
					'status' => 0
				])->count(),
				'konseling_on_progress' => Keluhan::where([
					'psikolog_id' => $this->getUser()->psikolog_id,
					'status' => 1
				])->count(),
				'konseling_selesai' => Keluhan::where([
					'psikolog_id' => $this->getUser()->psikolog_id,
					'status' => 2
				])->count(),
			];
			
			return view('backend/home_psikolog')->with([
				'dashboard' => $dashboard,
				'psikolog' => $psikolog,
				'keluhan' => $keluhan,
				'user' => $this->getUser()
			]);
		} else {
			return redirect()->route('home');
		}
	}

	/**
	 * Tampilkan detail data konseling. 
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function konseling($id) 
	{
		// ambil data keluhan, konseling, dass dan detail masyarakat/klien
		$data = Masyarakat::where('keluhans.id', $id)
			->join('keluhans', 'masyarakats.token', '=', 'keluhans.mas_id')
			->join('konselings', 'masyarakats.token', '=', 'konselings.mas_id')
			->join('psikologs', 'konselings.psikolog_id', '=', 'psikologs.id')
			->join('dasshasils', 'masyarakats.token', '=', 'dasshasils.mas_id')
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
					'anamnesis',
					'laporan'
				)
				->first();

				$konseling = [
					'hasil' => $konseling->hasil,
					'kesimpulan' => $konseling->kesimpulan,
					'saran' => $konseling->saran,
					'anamnesis' => $konseling->anamnesis,
					'berkas_pendukung' => $konseling->berkas_pendukung,
					'laporan' => $konseling->laporan
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

	/**
	 * Tampilkan laporan detail konseling. 
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function laporanDetail($id)
	{

		// ambil data keluhan, konseling, dass dan detail masyarakat/klien
		$data = Masyarakat::where('keluhans.id', $id)
			->join('keluhans', 'masyarakats.token', '=', 'keluhans.mas_id')
			->join('konselings', 'masyarakats.token', '=', 'konselings.mas_id')
			->join('psikologs', 'konselings.psikolog_id', '=', 'psikologs.id')
			->join('dasshasils', 'masyarakats.token', '=', 'dasshasils.mas_id')
			->select(
				'masyarakats.nama',
				'masyarakats.nik',
				'masyarakats.jk',
				'masyarakats.tgl_lahir',
				'masyarakats.hp',
				'masyarakats.pekerjaan',
				'masyarakats.pendidikan',
				'masyarakats.kec_id',
				'masyarakats.alamat', 
				'masyarakats.token',
				'keluhans.id as keluhan_id',
				'keluhans.keluhan', 
				'keluhans.jadwal_jam as jamnya',
				'keluhans.jadwal_alt2_tgl as tanggalnya', 
				'konselings.id as konseling_id',
				'psikologs.nama as psikolog_nama',
				'psikologs.sipp',
				'psikologs.id as psikolog_id', 
				'psikologs.ttd',
				'dasshasils.*'
			)
			->where([
				'keluhans.status' => 2, // hanya ambil data keluhan yang sudah selesai
				'konselings.status' => 2 // hanya ambil data konseling yang sudah selesai
			])
			->first();
		
		// dd($data);

		// get data konseling
		$konseling = Konseling::where('id', $data->konseling_id)
		->select(
			'hasil',
			'kesimpulan',
			'saran',
			'berkas_pendukung', 
		)
		->first();

		// get data masalah
		$masalah = Masalah::get();

		// get data konseling masalah
		$konseling_masalah = KonselingMasalah::where('konseling_id', $data->konseling_id)->get();
		$konseling_masalah = $konseling_masalah->map(function($item) {
			return $item->masalah_id;
		})->toArray();

		// dd($konseling_masalah);

		return view('backend/laporan_detail')->with([
			'data' => $data,
			'konseling' => $konseling,
			'masalah' => $masalah,
			'konseling_masalah' => $konseling_masalah,
			'user' => $this->getUser()
		]);
	}

	/**
	 * Trigger kirim form evaluasi ke masyarakat. 
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function formEvaluasi($id)
	{
		// dd($id);
		// trigger kirim pesan ke klien untuk mengisi form evaluasi
		$masyarakat = Masyarakat::where('token', $id)->first();

		// dd($masyarakat);

		$data = [
			'phone' => $this->normalizePhoneNumber($masyarakat->hp),
			'message' => "Halo $masyarakat->nama, kami mohon bantuan Anda untuk mengisi formulir evaluasi konseling yang telah Anda lakukan. Silakan klik link berikut untuk mengisi formulir evaluasi: ".route('front.evaluasi', $id)."\n\nSalam, Denpasar Menyama Bagia"
		];
		$this->notif_wa($data);

		return redirect()->route('home-psikolog')->with('message', 'Berhasil mengirimkan formulir evaluasi ke masyarakat');
	}

	/**
	 * store jadwal fix. 
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function storeJadwal(Request $request)
	{
		//validate form
		$this->validate($request, [
			'keluhan_id'     => 'required',
			'jadwal_alt2_tgl'     => 'required',
			'jadwal_alt2_jam'     => 'required'
		]);

		// dd($request->all());

		// update keluhan dan konseling
		$keluhan = keluhan::with(['psikolog', 'masyarakat'])
			->find($request->keluhan_id);

		$keluhan->jadwal_alt2_tgl = $request->jadwal_alt2_tgl;
		$keluhan->jadwal_alt2_jam = $request->jadwal_alt2_jam;
		$keluhan->status = 1;
		$keluhan->updated_at = Carbon::now();
		$keluhan->save(['timestamps' => FALSE]);

		$konseling = Konseling::where([
			'psikolog_id' => $this->getUser()->psikolog_id,
			'mas_id' => $keluhan->mas_id,
			'status' => 0
		])->latest()->first();

		$konseling->status = 1;
		$konseling->updated_at = Carbon::now();
		$konseling->save(['timestamps' => FALSE]);

		// kirim notifikasi ke masyarakat
		$data = [
			'phone' => $this->normalizePhoneNumber($keluhan['masyarakat']->hp),
			'message' => "Halo ".$keluhan['masyarakat']->nama.", berikut adalah detail jadwal konseling Anda yang telah di-konfirmasi:\n\nTanggal: ".Carbon::parse($keluhan->jadwal_alt2_tgl)->format('d/m/Y')."\nJam: $keluhan->jadwal_alt2_jam WITA\nPsikolog: ".$keluhan['psikolog']->nama."\nNomor HP Psikolog: ".$keluhan['psikolog']->hp."\nAlamat Praktek Psikolog: ".$keluhan['psikolog']->alamat_praktek."\n\nSilahkan untuk datang ke lokasi praktek pada tanggal dan jam yang telah ditentukan\nSampai jumpa nanti!\n\nSalam, Denpasar Menyama Bagia"
		];
		$this->notif_wa($data);

		if($keluhan && $konseling) {
			return redirect()->route('backend.konseling', $request->keluhan_id)->with('success', 'Berhasil melakukan update');
		} else {
			return redirect()->route('backend.konseling', $request->keluhan_id)->with('error', 'Gagal melakukan update');
		}
	}

	/**
	 * update jadwal utama atau alternatif. 
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function updateJadwal(Request $request)
	{
		if($request->jenis=='utama') {
			// update jadwal utama
			$keluhan = keluhan::find($request->keluhan_id);
			$keluhan->jadwal_alt2_tgl = $request->jadwal_tgl;
			$keluhan->jadwal_alt2_jam = $request->jadwal_jam;
			$keluhan->status = 1;
			$keluhan->updated_at = Carbon::now();
			$keluhan->save(['timestamps' => FALSE]);
		} else {
			// update jadwal alternatif
			$keluhan = keluhan::find($request->keluhan_id);
			$keluhan->jadwal_alt2_tgl = $request->jadwal_alt_tgl;
			$keluhan->jadwal_alt2_jam = $request->jadwal_alt_jam;
			$keluhan->status = 1;
			$keluhan->updated_at = Carbon::now();
			$keluhan->save(['timestamps' => FALSE]);
		}

		$konseling = Konseling::where([
			'psikolog_id' => $this->getUser()->psikolog_id,
			'mas_id' => $keluhan->mas_id,
			'status' => 0
		])->latest()->first();
		$konseling->status = 1;
		$konseling->updated_at = Carbon::now();
		$konseling->save(['timestamps' => FALSE]);

		// kirim notifikasi ke masyarakat
		// $data = [
		// 	'phone' => '0'.$masyarakat->hp,
		// 	'message' => "Halo $masyarakat->nama, berikut adalah detail jadwal konseling Anda:\n\nTanggal: $masyarakat->hari\nJam: $masyarakat->jam\nPsikolog: $masyarakat->psikolog\nNomor HP Psikolog: 0$masyarakat->psikolog_hp\nAlamat Praktek Psikolog: 0$masyarakat->alamat_praktek\n\nSampai jumpa nanti!\n\nSalam, Denpasar Menyama Bagia"
		// ];
		// $this->notif_wa($data);

		// 
		if($keluhan && $konseling) {
			return redirect()->route('backend.konseling', $request->keluhan_id)->with('success', 'Berhasil melakukan update');
		} else {
			return redirect()->route('backend.konseling', $request->keluhan_id)->with('error', 'Gagal melakukan update');
		}

	}

	/**
	 * input data hasil konseling. 
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function storeHasil(Request $request)
	{
		//validate form
		$this->validate($request, [
			'mas_id'     	=> 'required',
			'keluhan_id'    => 'required',
			'konseling_id'  => 'required',
			'hasil'     	=> 'required',
			'anamnesis'     => 'required',
			'masalah'     	=> 'required|array',
			'kesimpulan'    => 'required',
			'saran'     	=> 'required',
			'berkas_pendukung'     	=> 'required|file|mimes:jpg,jpeg,png|max:2048',
			'laporan'     			=> 'required|mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet:2048'

		]);


		$monthFolder = date('Y') . '/' . date('m');

		// ambil data lama
		$old_file = Konseling::where([
			'psikolog_id' => $this->getUser()->psikolog_id,
			'mas_id' => $request->mas_id,
			'status' => 1
		]);

		// Simpan berkas pendukung
		if ($request->hasFile('berkas_pendukung')) {
			$berkasPath = $this->simpanFile($request->file('berkas_pendukung'), 'berkas_pendukung', $monthFolder, $old_file->berkas_pendukung);
			if (!$berkasPath) {
				// return response()->json(['error' => 'Gagal menyimpan berkas pendukung'], 500);
				return redirect()->route('backend.konseling', $request->keluhan_id)->with('error', 'Gagal menyimpan berkas pendukung');
			}
		}

		// Simpan laporan
		if ($request->hasFile('laporan')) {
			$laporanPath = $this->simpanFile($request->file('laporan'), 'laporan', $monthFolder, $old_file->laporan);
			if (!$laporanPath) {
				// return response()->json(['error' => 'Gagal menyimpan laporan'], 500);
				return redirect()->route('backend.konseling', $request->keluhan_id)->with('error', 'Gagal menyimpan laporan');
			}
		}

		// dd($request->all());
		// // simpan file berkas pendukung menggunakan storage
		// $berkas_pendukung = $request->file('berkas_pendukung');
		// $berkas_pendukung_name = time().'_'.$berkas_pendukung->getClientOriginalName();

		// $year_folder = date("Y");
		// $month_folder = $year_folder . '/' . date("m");

		// $path = 'uploads/berkas_pendukung/'.$month_folder.'/'.$berkas_pendukung_name;

		// $file_content = file_get_contents($berkas_pendukung);
		// if(!Storage::disk('public')->put($path, $file_content)) {
		// 	return false;
		// }

		// // simpan file laporan
		// $laporan = $request->file('laporan');
		// $laporan_name = time().'_'.$laporan->getClientOriginalName();

		// $path_laporan = 'uploads/laporan/'.$month_folder.'/'.$laporan_name;

		// $file_content = file_get_contents($laporan);
		// if(!Storage::disk('public')->put($path_laporan, $file_content)) {
		// 	return false;
		// }

		// $berkas_pendukung->move(public_path('uploads/berkas_pendukung'), $berkas_pendukung_name);

		// update data konseling
		$konseling = Konseling::where([
			'psikolog_id' => $this->getUser()->psikolog_id,
			'mas_id' => $request->mas_id,
			'status' => 1
		])->update([
			'hasil' => $request->hasil,
			'anamnesis' => $request->anamnesis,
			'kesimpulan' => $request->kesimpulan,
			'saran' => $request->saran,
			'berkas_pendukung' => $monthFolder.'/'.$berkasPath,
			'laporan' => $monthFolder.'/'.$laporanPath,
			'keluhan_id' => $request->keluhan_id,
			'status' => 2,
			'updated_at' => Carbon::now()
		]);

		// update data keluhan
		$keluhan = keluhan::find($request->keluhan_id);
		$keluhan->status = 2;
		$keluhan->updated_at = Carbon::now();
		$keluhan->save(['timestamps' => FALSE]);

		// insert data masalah
		$masalah = [];
		foreach($request->masalah as $key => $value) {
			$masalah[] = [
				'konseling_id' => $request->konseling_id,
				'masalah_id' => $value,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			];
		}
		$masalah = KonselingMasalah::insert($masalah);
		

		if($konseling && $masalah) {
			return redirect()->route('backend.konseling', $request->keluhan_id)->with('success', 'Berhasil melakukan update data hasil konseling');
		} else {
			return redirect()->route('backend.konseling', $request->keluhan_id)->with('error', 'Gagal melakukan update data hasil konseling');
		}
	}

	/**
	 * update data hasil konseling. 
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function updateHasil(Request $request)
	{
		//validate form
		$this->validate($request, [
			'mas_id'     	=> 'required',
			'keluhan_id'    => 'required',
			'konseling_id'  => 'required',
			'hasil'     	=> 'required',
			'masalah'     	=> 'required|array',
			'kesimpulan'    => 'required',
			'saran'     	=> 'required',
			'berkas_pendukung'     	=> 'file|mimes:jpg,jpeg,png|max:2048'
		]);

		// jika ada file berkas pendukung
		if($request->hasFile('berkas_pendukung')) {
			// hapus file lama
			$year_folder = date("Y");
			$month_folder = $year_folder . '/' . date("m");

			$old_berkas_pendukung = Konseling::where('id', $request->konseling_id)->first();
			$filePath = storage_path('app/public/uploads/berkas_pendukung/'.$old_berkas_pendukung->berkas_pendukung);
			if(file_exists($filePath) && $old_berkas_pendukung->berkas_pendukung) {
				unlink($filePath);
			}
			
			// simpan file berkas pendukung menggunakan storage
			$berkas_pendukung = $request->file('berkas_pendukung');
			$berkas_pendukung_name = time().'_'.$berkas_pendukung->getClientOriginalName();

			$path = 'uploads/berkas_pendukung/'.$month_folder.'/'.$berkas_pendukung_name;

			$file_content = file_get_contents($berkas_pendukung);
			if(!Storage::disk('public')->put($path, $file_content)) {
				return false;
			}

			$konseling = Konseling::where([
				'id' => $request->konseling_id
			])->update([
				'hasil' => $request->hasil,
				'kesimpulan' => $request->kesimpulan,
				'saran' => $request->saran,
				'berkas_pendukung' => $month_folder.'/'.$berkas_pendukung_name,
				'keluhan_id' => $request->keluhan_id,
				'status' => 2,
				'updated_at' => Carbon::now()
			]);
		} else {
			// update data konseling tanpa berkas pendukung
			$konseling = Konseling::where([
				'id' => $request->konseling_id
			])->update([
				'hasil' => $request->hasil,
				'kesimpulan' => $request->kesimpulan,
				'keluhan_id' => $request->keluhan_id,
				'saran' => $request->saran,
				'status' => 2,
				'updated_at' => Carbon::now()
			]);
		}

		// update data keluhan
		$keluhan = keluhan::find($request->keluhan_id);
		$keluhan->status = 2;
		$keluhan->updated_at = Carbon::now();
		$keluhan->save(['timestamps' => FALSE]);

		// update data masalah
		KonselingMasalah::where('konseling_id', $request->konseling_id)->delete();

		// insert data masalah baru
		$masalah = [];
		foreach($request->masalah as $key => $value) {
			$masalah[] = [
				'konseling_id' => $request->konseling_id,
				'masalah_id' => $value,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			];
		}
		$masalah = KonselingMasalah::insert($masalah);
		

		if($konseling && $masalah) {
			return redirect()->route('backend.konseling', $request->keluhan_id)->with('success', 'Berhasil melakukan update data hasil konseling');
		} else {
			return redirect()->route('backend.konseling', $request->keluhan_id)->with('error', 'Gagal melakukan update data hasil konseling');
		}
	}

	/**
	 * Batalkan konseling. 
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function batal($id)
	{
		// update status keluhan dan konseling menjadi batal
		$keluhan = keluhan::find($id);
		$keluhan->status = 3;
		$keluhan->updated_at = Carbon::now();
		$keluhan->save(['timestamps' => FALSE]);

		$konseling = Konseling::where([
			'psikolog_id' => $this->getUser()->psikolog_id,
			'mas_id' => $keluhan->mas_id,
			'status' => 1
		])->latest()->first();
		$konseling->status = 3;
		$konseling->updated_at = Carbon::now();
		$konseling->save(['timestamps' => FALSE]);

		if($keluhan && $konseling) {
			// get data masyarakat
			$masyarakat = Masyarakat::where('token', $keluhan->mas_id)->first();

			// kirim notifikasi ke masyarakat
			$data = [
				'phone' => $this->normalizePhoneNumber($masyarakat->hp),
				'message' => "Halo $masyarakat->nama, maaf konseling Anda pada tanggal ".Carbon::parse($keluhan->jadwal_alt2_tgl)->format('d/m/Y')." jam $keluhan->jadwal_alt2_jam WITA telah dibatalkan. Silakan hubungi kami untuk informasi lebih lanjut.\n\nSalam, Denpasar Menyama Bagia"
			];
			$this->notif_wa($data);

			// Kirim email
			$mailController = new PhpMailController();
			$mailController->BatalKonseling($masyarakat,$keluhan);


			// redirect ke halaman konseling
			return redirect()->route('backend.konseling', $id)->with('success', 'Berhasil melakukan pembatalan konseling');
		} else {
			// update balik status keluhan menjadi sebelumnya
			$keluhan = keluhan::find($id);
			$keluhan->status = 1;
			$keluhan->updated_at = Carbon::now();
			$keluhan->save(['timestamps' => FALSE]);
			
			return redirect()->route('backend.konseling', $id)->with('error', 'Gagal melakukan pembatalan konseling');
		}
	}

	/**
	 * reschedule konseling. 
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function reschedule(Request $request)
	{
		//validate form
		$this->validate($request, [
			'keluhan_id'     => 'required',
			'jadwal_alt2_tgl'     => 'required',
			'jadwal_alt2_jam'     => 'required'
		]);

		// dd($request->all());

		// update keluhan dan konseling
		$keluhan = keluhan::with('masyarakat')
			->find($request->keluhan_id);

		$keluhan->jadwal_alt2_tgl = $request->jadwal_alt2_tgl;
		$keluhan->jadwal_alt2_jam = $request->jadwal_alt2_jam;
		$keluhan->status = 1;
		$keluhan->updated_at = Carbon::now();
		$keluhan->save(['timestamps' => FALSE]);

		$konseling = Konseling::where([
			'psikolog_id' => $this->getUser()->psikolog_id,
			'mas_id' => $keluhan->mas_id,
			'status' => 1
		])->latest()->first();
		$konseling->updated_at = Carbon::now();
		$konseling->save(['timestamps' => FALSE]);

		// kirim notifikasi ke masyarakat
		$data = [
			'phone' => $this->normalizePhoneNumber($keluhan['masyarakat']->hp),
			'message' => "Halo ".$keluhan['masyarakat']->nama.", jadwal konseling Anda telah di-reschedule menjadi:\n\nTanggal: ".Carbon::parse($keluhan->jadwal_alt2_tgl)->format('d/m/Y')."\nJam: ".$keluhan->jadwal_alt2_jam." WITA\n\nMohon untuk datang ke lokasi pada tanggal terakhir yang telah di-reschedule.\nSampai jumpa nanti!\n\nSalam, Denpasar Menyama Bagia"
		];
		$this->notif_wa($data);

		if($keluhan && $konseling) {
			return redirect()->route('backend.konseling', $request->keluhan_id)->with('success', 'Berhasil melakukan reschedule konseling');
		} else {
			return redirect()->route('backend.konseling', $request->keluhan_id)->with('error', 'Gagal melakukan reschedule konseling');
		}
	}

	public function printPdf($id)
	{
		// ambil data keluhan, konseling, dass dan detail masyarakat/klien
		$data = Masyarakat::where('keluhans.id', $id)
			->join('keluhans', 'masyarakats.token', '=', 'keluhans.mas_id')
			->join('konselings', 'masyarakats.token', '=', 'konselings.mas_id')
			->join('psikologs', 'konselings.psikolog_id', '=', 'psikologs.id')
			->join('dasshasils', 'masyarakats.token', '=', 'dasshasils.mas_id')
			->select(
				'masyarakats.nama',
				'masyarakats.nik',
				'masyarakats.jk',
				'masyarakats.tgl_lahir',
				'masyarakats.hp',
				'masyarakats.pekerjaan',
				'masyarakats.pendidikan',
				'masyarakats.kec_id',
				'masyarakats.alamat', 
				'masyarakats.token',
				'keluhans.id as keluhan_id',
				'keluhans.keluhan', 
				'keluhans.jadwal_jam as jamnya',
				'keluhans.jadwal_alt2_tgl as tanggalnya', 
				'konselings.id as konseling_id',
				'psikologs.nama as psikolog_nama',
				'psikologs.sipp',
				'psikologs.id as psikolog_id', 
				'psikologs.ttd',
				'dasshasils.*'
			)
			->where([
				'keluhans.status' => 2, // hanya ambil data keluhan yang sudah selesai
				'konselings.status' => 2 // hanya ambil data konseling yang sudah selesai
			])
			->first();
		
		// dd($data);

		// get data konseling
		$konseling = Konseling::where('id', $data->konseling_id)
		->select(
			'hasil',
			'kesimpulan',
			'saran',
			'berkas_pendukung', 
		)
		->first();

		// get data masalah
		$masalah = Masalah::get();

		// get data konseling masalah
		$konseling_masalah = KonselingMasalah::where('konseling_id', $data->konseling_id)->get();
		$konseling_masalah = $konseling_masalah->map(function($item) {
			return $item->masalah_id;
		})->toArray();

		// dd($konseling_masalah);

		$tanggal = Carbon::now()->translatedFormat('d-m-Y');
		$string = $data->nama;
		$new_string = str_replace(" ", "-", $string); // Replace spaces with dashes

		$pdf = PDF::loadView('backend/pdf', compact('data', 'masalah', 'konseling', 'konseling_masalah'));
		$pdf->set_option('isRemoteEnabled', true);
		return $pdf->download('laporan-konseling-'.$tanggal.'_'.$new_string.'.pdf');
	}
}
