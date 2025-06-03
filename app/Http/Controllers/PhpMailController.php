<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

class PhpMailController extends Controller
{
     // Fungsi umum kirim email
    public function sendEmail($email, $subject, $messageHtml)
    {
        Mail::send([], [], function ($mail) use ($email, $subject, $messageHtml) {
            $mail->to($email)
                ->subject($subject)
                ->html($messageHtml);
        });
    }

    // Contoh fungsi spesifik: kirim form evaluasi
    public function kirimEvaluasi($masyarakat)
    {
        $link = route('front.evaluasi', $masyarakat->token);

        $pesanEmail = "
            <p>Halo {$masyarakat->nama},</p>
            <p>Kami mohon bantuan Anda untuk mengisi formulir evaluasi konseling.</p>
            <p><a href='{$link}'>Klik di sini untuk mengisi</a></p>
            <p>Salam,<br>Denpasar Menyama Bagia</p>
        ";

        $this->sendEmail($masyarakat->email, 'Permintaan Mengisi Form Evaluasi', $pesanEmail);
    }

    public function FinalKonseling($masyarakat,$alamat_web)
    {
        $pesanEmail = "
            <p>Halo {$masyarakat->psikolog}, berikut adalah detail jadwal konseling Anda:</p>
            <p>Tanggal: {$masyarakat->hari}</p>
            <p>Jam: {$masyarakat->jam}</p>
            <p>Klien: {$masyarakat->nama}</p>
            <p>Nomor HP Klien: 0{$masyarakat->hp}</p>
            <p>Untuk masuk ke dalam sistem Anda dapat mengakses alamat ini: {$alamat_web} </p>
            <p>Salam, Denpasar Menyama Bagia</p>
        ";

        $this->sendEmail($masyarakat->email, 'Detail Jadwal Konseling', $pesanEmail);
    }

    public function BatalKonseling($masyarakat, $keluhan)
    {
        $pesanEmail = "
            <p>Halo {$masyarakat->nama},</p>
            <p>Maaf, konseling Anda pada tanggal {$keluhan->jadwal_alt2_tgl} jam {$keluhan->jadwal_alt2_jam} telah dibatalkan.</p>
            <p>Silakan hubungi kami untuk informasi lebih lanjut.</p>
            <p>Salam,<br>Denpasar Menyama Bagia</p>
        ";

        $this->sendEmail($masyarakat->email, 'Pembatalan Jadwal Konseling', $pesanEmail);
    }

    public function RescheduleKonseling($masyarakat)
    {
        $pesanEmail = "
            <p>Halo {$masyarakat->nama},</p>
            <p>Jadwal konseling Anda telah direschedule menjadi:</p>
            <p><strong>Tanggal:</strong> {$masyarakat->hari}</p>
            <p><strong>Jam:</strong> {$masyarakat->jam}</p>
            <p>Sampai jumpa nanti!</p>
            <p>Salam,<br>Denpasar Menyama Bagia</p>
        ";

        $this->sendEmail($masyarakat->email, 'Jadwal Konseling Telah Diubah', $pesanEmail);
    }


    // // Contoh fungsi lain: kirim hasil survei
    // public function kirimHasilSurvei($masyarakat, $hasilText)
    // {
    //     $linkKonseling = route('front.konseling-store-reg', $masyarakat->token);

    //     $pesanEmail = "
    //         <p>Halo {$masyarakat->nama},</p>
    //         <p>Berikut hasil survei Anda:</p>
    //         <p>{$hasilText}</p>
    //         <p>Untuk konseling: <a href='{$linkKonseling}'>Klik di sini</a></p>
    //         <p>Salam,<br>Denpasar Menyama Bagia</p>
    //     ";

    //     $this->sendEmail($masyarakat->email, 'Hasil Survei Anda', $pesanEmail);
    // }
}
