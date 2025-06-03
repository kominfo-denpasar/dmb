<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    //fungsi kirim notif whatsapp
    // public function notif_wa($data) {
    //     $curl = curl_init();
    //     $token = "7NLXy6ZPgPAQGuu92x9lySyKvLG2XFszSu1tufAkAs9QBOXaxt0n11Y9lzXcm3hp.VS1IlTNO";
        
    //     curl_setopt($curl, CURLOPT_HTTPHEADER,
    //         array(
    //             "Authorization: $token",
    //         )
    //     );
    //     curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    //     curl_setopt($curl, CURLOPT_URL,  "https://jogja.wablas.com/api/send-message");
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    //     $result = curl_exec($curl);
    //     curl_close($curl);
        
    //     // echo "<pre>";
    //     // print_r($result);
    // }

    public function notif_wa($data)
    {
        //Dev Environment
        $url = "http://localhost:3000/send/message";
        $username = "user1";
        $password = "pass1";

        //Production Environment
        // $url = env('WA_API_URL');
        // $username = env('WA_API_AUTH_USER');
        // $password = env('WA_API_AUTH_PASS');

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

        curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($curl);
        curl_close($curl);
        // dd($result);
    }

    public function getUser(){
        // ambil data user
        return $data = config('roles.models.defaultUser')::find(Auth::id());
    }
}
