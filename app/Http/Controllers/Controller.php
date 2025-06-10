<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Spatie\Activitylog\Facades\Activity;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PhpMailController;

class Controller extends BaseController
{
	use AuthorizesRequests, ValidatesRequests;

	//fungsi kirim notif whatsapp
	public function notif_wa($data) {
		$curl = curl_init();
		$token = "7NLXy6ZPgPAQGuu92x9lySyKvLG2XFszSu1tufAkAs9QBOXaxt0n11Y9lzXcm3hp.VS1IlTNO";
		
		curl_setopt($curl, CURLOPT_HTTPHEADER,
			array(
				"Authorization: $token",
			)
		);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($curl, CURLOPT_URL,  "https://jogja.wablas.com/api/send-message");
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$result = curl_exec($curl);
		curl_close($curl);
		
		// echo "<pre>";
		// print_r($result);
	}

	// kirim email
	// public function notif_email($data)
	// {
	//     try {
	//         $mailController = new PhpMailController();
	// 	    $mailController->RescheduleKonseling($data);
	//         // $mailController->sendEmail($data);
	//         // return response()->json(['status' => 'success', 'message' => 'Email sent successfully']);
	//     } catch (\Exception $e) {
	//         Log::error('Email sending failed: ' . $e->getMessage());
	//         // return response()->json(['status' => 'error', 'message' => 'Failed to send email'], 500);
	//     }
	// }

	// public function notif_wa($data)
	// {

	//     try {
	//         $response = Http::withBasicAuth(
	//             env('WA_API_AUTH_USER'), 
	//             env('WA_API_AUTH_PASS'))
	//         ->post(env('WA_API_URL'), $data);

	//         // $responseData = $response->json();

	//         if ($response->successful()) {
	//             return $response->json();
	//         }

	//         Log::error('WA Response failed: ' . $response->body());

	//         Activity::causedBy('System')
	//             ->log('WA Response failed: ' . $response->body());

	//     } catch (\Exception $e) {
	//         Log::error('WA Request error: ' . $e->getMessage());
	//     }
	// }

	//konversi penyesuaian nomer telp
	public function normalizePhoneNumber($phone)
	{
		// Hilangkan spasi, tanda +, tanda -, titik, dan karakter non-digit
		$phone = preg_replace('/[^0-9]/', '', $phone);

		// Jika diawali dengan 0 (contoh: 0821...), ganti jadi 62
		if (substr($phone, 0, 1) === '0') {
			$phone = '62' . substr($phone, 1);
		}

		// Jika diawali dengan 8 (tanpa 0 atau 62), tambahkan 62 di depannya
		if (substr($phone, 0, 1) === '8') {
			$phone = '62' . $phone;
		}

		// Jika sudah diawali 62, biarkan
		return $phone;
	}

	public function simpanFile($file, $folderPrefix, $monthFolder, $oldFileName = null)
	{
		// Hapus file lama jika ada
		if ($oldFileName) {
			$oldPath = "uploads/{$folderPrefix}/{$oldFileName}";

			if (Storage::disk('public')->exists($oldPath)) {
				Storage::disk('public')->delete($oldPath);
			}
		}
		
		$fileName = time() . '_' . $file->getClientOriginalName();
		$path = "uploads/{$folderPrefix}/{$monthFolder}/{$fileName}";

		if (!Storage::disk('public')->put($path, file_get_contents($file))) {
			return false;
		}

		return $fileName; // Return nama file beserta path untuk simpan ke DB
	}

	public function getUser(){
		// ambil data user
		return $data = config('roles.models.defaultUser')::find(Auth::id());
	}
}
