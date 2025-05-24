<?php
namespace App\Traits;

trait dateTransform
{
    function getUpcomingDatesByDayName($dayName, $startDate = null) {
        $dates = [];

        // Mulai dari hari ini jika $startDate tidak ditentukan
        $start = new \DateTime($startDate ?? 'today');
        $end = clone $start;
        $end->modify('+1 month');

        // Format nama hari agar sesuai (e.g., Senin)
        $targetDay = ucfirst(strtolower($dayName));

        // Loop dari start ke end
        while ($start <= $end) {
            $currentDayName = $this->translateDayToIndo($start->format('l'));
            if ($currentDayName === $targetDay) {
                // $dates[] = $targetDay . ', ' . $start->format('d-m-Y');
                $dates[] = $start->format('Y-m-d');
            }
            $start->modify('+1 day');
        }

        return $dates;
    }

    // Fungsi bantu untuk menerjemahkan nama hari dari Inggris ke Indonesia
    function translateDayToIndo($englishDay) {
        $days = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu'
        ];

        return $days[$englishDay] ?? $englishDay;
    }
}