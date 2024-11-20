<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewSprinklerPump;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NewSpinklerPumpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sprinklerPump1Activities = [
            ['code' => 'B1', 'activity' => 'Check selector switch Jockey, Electric and Diesel Pump', 'requirement' => 'Auto Position', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'B2', 'activity' => 'Check voltage electric pump (R-N,Y-N,B-N)', 'requirement' => '210V - 230V', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'B3', 'activity' => 'Check voltage electric pump (R-Y,Y-B,R-B)', 'requirement' => '380V - 400V', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'B4', 'activity' => 'Check selector switch battery supply diesel pump', 'requirement' => 'ON', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'B5', 'activity' => 'Check current battery', 'requirement' => 'Max 10 A', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'B6', 'activity' => 'Check voltage battery', 'requirement' => '24 V - 30 V', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'B7', 'activity' => 'Check system pressure', 'requirement' => '12 Bar - 14 Bar', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'B8', 'activity' => 'Check pressure in and out CV 4 s/d CV 9', 'requirement' => '12 Bar - 14 Bar', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'B9', 'activity' => 'Check the water cooler radiator', 'requirement' => 'Full', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'B10', 'activity' => 'Check the diesel tank fuel', 'requirement' => 'Fuel not less than the lower limit', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'B11', 'activity' => 'Check the water tank supply sprinkler', 'requirement' => 'Water not below 3 step', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
        ];

        // Data untuk Sprinkler Pump 2 (kode A1 - A11)
        $sprinklerPump2Activities = [
            ['code' => 'A1', 'activity' => 'Check selector switch Jockey, Electric and Diesel Pump', 'requirement' => 'Auto Position', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'A2', 'activity' => 'Check voltage electric pump (R-N,Y-N,B-N)', 'requirement' => '210V - 230V', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'A3', 'activity' => 'Check voltage electric pump (R-Y,Y-B,R-B)', 'requirement' => '380V - 400V', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'A4', 'activity' => 'Check selector switch battery supply diesel pump', 'requirement' => 'ON', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'A5', 'activity' => 'Check current battery', 'requirement' => 'Max 6 A', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'A6', 'activity' => 'Check voltage battery', 'requirement' => '12 V - 15 V', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'A7', 'activity' => 'Check system pressure', 'requirement' => '8 Bar - 10 Bar', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'A8', 'activity' => 'Check pressure in and out CV 1 s/d CV 3', 'requirement' => '8 Bar - 10 Bar', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'A9', 'activity' => 'Check the water cooler radiator', 'requirement' => 'Full', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'A10', 'activity' => 'Check the diesel tank fuel', 'requirement' => 'Fuel not less than the lower limit', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
            ['code' => 'A11', 'activity' => 'Check the water tank supply sprinkler', 'requirement' => 'Water not below 3 step', 'tools' => 'By Visual', 'who' => 'LT', 'interval' => 'Daily'],
        ];

        // Menambahkan data untuk Sprinkler Pump 1
        foreach ($sprinklerPump1Activities as $activity) {
            NewSprinklerPump::create([
                'equipment_name' => 'Sprinkler Pump 1',
                'code' => $activity['code'],
                'activity' => $activity['activity'],
                'requirement' => $activity['requirement'],
                'tools' => $activity['tools'],
                'who' => $activity['who'],
                'interval' => $activity['interval'],
            ]);
        }

        // Menambahkan data untuk Sprinkler Pump 2
        foreach ($sprinklerPump2Activities as $activity) {
            NewSprinklerPump::create([
                'equipment_name' => 'Sprinkler Pump 2',
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
