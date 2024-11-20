<?php

namespace Database\Seeders;

use App\Models\Compressor;
use App\Models\NewCompressor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NewCompressorSeeder extends Seeder
{
    public function run()
    {
        $activities = [
            ['code' => 'A1a', 'activity' => 'Discharger pressure', 'requirement' => '6.5 Bar - 7.0 Bar', 'tools' => 'Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'A1b', 'activity' => 'Discharger temp', 'requirement' => '80°C - 95°C', 'tools' => 'Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'A1c', 'activity' => 'Ambient temp', 'requirement' => '30°C - 40°C', 'tools' => 'Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'A2', 'activity' => 'Check auto drain, open drain manual', 'requirement' => 'Clean water tank', 'tools' => 'Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'A3', 'activity' => 'Oil level', 'requirement' => 'No more than the upper limit, and no less than the lower limit', 'tools' => 'Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'A4', 'activity' => 'Check dryer', 'requirement' => '4°C - 10°C', 'tools' => 'Visual', 'who' => 'LT', 'interval' => 'Daily'],
        ];

        // Loop untuk setiap compressor tanpa bulan
        for ($compressorIndex = 1; $compressorIndex <= 27; $compressorIndex++) {
            // Loop setiap aktivitas dan buat entri untuk setiap aktivitas
            foreach ($activities as $activity) {
                NewCompressor::create([
                    'equipment_name' => 'Compressor ' . $compressorIndex,
                    'code' => $activity['code'],
                    'activity' => $activity['activity'],
                    'requirement' => $activity['requirement'],
                    'tools' => $activity['tools'],
                    'who' => $activity['who'],
                    'interval' => $activity['interval'],
                ]);
            }
        }
    }
}
