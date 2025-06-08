<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\keluhan;
use App\Services\KonselingService;

class UpdateKonselingStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'konseling:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Proses ini akan membatalkan konseling yang sudah lewat tanggal hari H.
                            Juga akan mengupdate status konseling yang belum dikonfirmasi menjadi batal setelah 2 hari.';

    /**
     * Execute the console command.
     */
    public function handle(KonselingService $service)
    {
        // batalkan konseling yang sudah lewat tanggal hari h
        $this->info('Memulai proses pembatalan konseling yang lewat tanggal...');
        $total = $service->batalkanKonselingLewatTanggal();
        $this->info("Total konseling yang dibatalkan otomatis: {$total}");

        // ----------------

        //update status konseling yang belum dikonfirmasi menjadi batal setelah 2 hari
        $dt = keluhan::where('status', 0)
            ->whereDate('created_at', '<=', now()->subDays(2)->toDateString())
            ->update(['status' => 3]);

        if ($dt) {
            $this->info('Berhasil mengupdate semua status konseling yang belum dikonfirmasi menjadi batal.');
        }
    }
}
