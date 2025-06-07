<?php

namespace App\Traits;

use App\Models\PsikologKuota;
use App\Models\keluhan;
use App\Models\Pengaturan;
use Carbon\Carbon;

trait kuotaTrait
{
    public function cekKuotaPsikolog($psikologId): array
    {
        $now = Carbon::now();
        $bulan = $now->month;
        $tahun = $now->year;
        $tanggalHariIni = $now->toDateString();

        // Ambil atau buat kuota psikolog bulan ini
        $kuota = PsikologKuota::firstOrCreate(
            ['psikolog_id' => $psikologId, 'bulan' => $bulan],
            ['kuota_hari' => 1, 'kuota_bulan' => 2, 'kuota_tahun' => 10]
        );

        // Ambil kuota sistem total
        $kuotaSistem = Pengaturan::where('slug', 'kuota-total')->first();
        $kuotaSistemMax = $kuotaSistem ? (int) $kuotaSistem->value : 100; // Default 100 jika tidak ada pengaturan

        // Hitung pemakaian kuota
        $totalSistem = keluhan::whereMonth('jadwal_alt2_tgl', $bulan)
            ->whereYear('jadwal_alt2_tgl', $tahun)
            ->count();

        $totalHari = keluhan::where('psikolog_id', $psikologId)
            ->where('status', '!=', 3) // Status tidak 3 (batal)
            ->whereDate('jadwal_alt2_tgl', $tanggalHariIni)
            ->count();

        $totalBulan = keluhan::where('psikolog_id', $psikologId)
            ->where('status', '!=', 3) // Status tidak 3 (batal)
            ->whereMonth('jadwal_alt2_tgl', $bulan)
            ->whereYear('jadwal_alt2_tgl', $tahun)
            ->count();

        $totalTahun = keluhan::where('psikolog_id', $psikologId)
            ->where('status', '!=', 3) // Status tidak 3 (batal)
            ->whereYear('jadwal_alt2_tgl', $tahun)
            ->count();

        if ($totalSistem >= $kuotaSistemMax) {
            return ['status' => false, 'message' => 'Kuota sistem sudah penuh.'];
        }

        if ($totalHari >= $kuota->kuota_hari) {
            return ['status' => false, 'message' => 'Kuota harian psikolog sudah habis.'];
        }

        if ($totalBulan >= $kuota->kuota_bulan) {
            return ['status' => false, 'message' => 'Kuota bulanan psikolog sudah habis.'];
        }

        if ($totalTahun >= $kuota->kuota_tahun) {
            return ['status' => false, 'message' => 'Kuota tahunan psikolog sudah habis.'];
        }

        return ['status' => true];
    }
}
