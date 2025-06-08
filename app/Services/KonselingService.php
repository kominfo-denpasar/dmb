<?php
namespace App\Services;

use App\Models\Konseling;
use App\Models\keluhan;
use Carbon\Carbon;

class KonselingService
{
    /**
     * Get the hasil konseling by konseling.
     *
     * @param Konseling $konseling
     * @return HasilKonseling|null
     */
    public function getKeluhanByKonseling(Konseling $konseling)
    {
        return keluhan::where('mas_id', $konseling->masyarakat_id)->first();
    }

    public function getKonselingByKeluhan(keluhan $dt)
    {
        return Konseling::where('mas_id', $dt->mas_id)->first();
    }

    public function batalkanKonselingLewatTanggal()
    {
        $pendaftaranLewat = keluhan::with(['masyarakat'])
            ->whereDate('jadwal_alt2_tgl', '<', Carbon::today())
            ->whereNotIn('status', [2, 3]) // 2 = selesai, 3 = batal
            ->get();

        foreach ($pendaftaranLewat as $pendaftaran) {

            $konseling = $this->getKonselingByKeluhan($pendaftaran);
            if ($konseling) {
                // $hasilKonseling->delete();
                $konseling->update(['status' => 3]); // Update status konseling menjadi batal
            }

            // Update status keluhan menjadi dibatalkan
            $pendaftaran->update(['status' => 3]);

            // Log jika perlu
            info("Konseling milik {$pendaftaran->masyarakat->nama} dibatalkan otomatis karena lewat tanggal.");
        }

        return $pendaftaranLewat->count(); // Optional: return total yang dibatalkan
    }
}
