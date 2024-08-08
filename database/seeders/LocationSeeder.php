<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locations')->delete();
        $locations = array(
            array('id' => 1, 'code' => 'A1', 'name' => "A.1 - B1 LOT 1"),
            array('id' => 2, 'code' => 'A2', 'name' => "A.2 - B1 LOT 1"),
            array('id' => 3, 'code' => 'A3', 'name' => "A.3 - B1 LOT 2"),
            array('id' => 4, 'code' => 'A4', 'name' => "A.4 - B1 LOT 3"),
            array('id' => 5, 'code' => 'A5', 'name' => "A.5 - B1 LOT 4"),
            array('id' => 6, 'code' => 'A6', 'name' => "A.6 - B1 LOT 5"),
            array('id' => 7, 'code' => 'A7', 'name' => "A.7 - B1 LOT 5"),
            array('id' => 8, 'code' => 'A8', 'name' => "A.8 - B1 LOT 5"),
            array('id' => 9, 'code' => 'A9', 'name' => "A.9 - B1 LOT 5"),
            array('id' => 10, 'code' => 'A10', 'name' => "A.10 - B1 LOT 6"),
            array('id' => 11, 'code' => 'A11', 'name' => "A.11 - B1 LOT 6"),
            array('id' => 12, 'code' => 'B1', 'name' => "B.1 - B1 LOT 3"),
            array('id' => 13, 'code' => 'B2', 'name' => "B.2 - B2a LOT 14"),
            array('id' => 14, 'code' => 'B3', 'name' => "B.3 - B2a LOT 16"),
            array('id' => 15, 'code' => 'B4', 'name' => "B.4 - B2a LOT 14"),
            array('id' => 16, 'code' => 'B5', 'name' => "B.5 - B2a LOT 17"),
            array('id' => 17, 'code' => 'B6', 'name' => "B.6 - B2a LOT 12"),
            array('id' => 18, 'code' => 'B7', 'name' => "B.7 - B2a LOT 12"),
            array('id' => 19, 'code' => 'B8', 'name' => "B.8 - B2a LOT 11"),
            array('id' => 20, 'code' => 'B9', 'name' => "B.9 - B2a LOT 11"),
            array('id' => 21, 'code' => 'B10', 'name' => "B.10 - B2a LOT 2"),
            array('id' => 22, 'code' => 'B11', 'name' => "B.11 - B2a LOT 2"),
            array('id' => 23, 'code' => 'B12', 'name' => "B.12 - B2a LOT 2"),
            array('id' => 24, 'code' => 'B13', 'name' => "B.13 - B2a LOT 2"),
            array('id' => 25, 'code' => 'B14', 'name' => "B.14 - B2a LOT 3"),
            array('id' => 26, 'code' => 'B15', 'name' => "B.15 - B2a LOT 3"),
            array('id' => 27, 'code' => 'C1', 'name' => "C.1 - B2a LOT 17"),
            array('id' => 28, 'code' => 'C2', 'name' => "C.2 - B2a LOT 10"),
            array('id' => 29, 'code' => 'C3', 'name' => "C.3 - B2a LOT 11"),
            array('id' => 30, 'code' => 'C4', 'name' => "C.4 - B2a LOT 11"),
            array('id' => 31, 'code' => 'C5', 'name' => "C.5 - B2a LOT 12"),
            array('id' => 32, 'code' => 'C6', 'name' => "C.6 - B2a LOT 12"),
            array('id' => 33, 'code' => 'C7', 'name' => "C.7 - B2a LOT 20"),
            array('id' => 34, 'code' => 'C8', 'name' => "C.8 - B2a LOT 20"),
            array('id' => 35, 'code' => 'C9', 'name' => "C.9 - B2a LOT 21"),
            array('id' => 36, 'code' => 'C10', 'name' => "C.10 - B2a LOT 21"),
            array('id' => 37, 'code' => 'C11', 'name' => "C.11 - B2a LOT 22"),
            array('id' => 38, 'code' => 'C12', 'name' => "C.12 - B2a LOT 22"),
            array('id' => 39, 'code' => 'C13', 'name' => "C.13 - B2a LOT 23"),
            array('id' => 40, 'code' => 'C14', 'name' => "C.14 - B2a LOT 23"),
            array('id' => 41, 'code' => 'C15', 'name' => "C.15 - B2a LOT 24"),
            array('id' => 42, 'code' => 'C16', 'name' => "C.16 - B2a LOT 24"),
            array('id' => 43, 'code' => 'D1', 'name' => "D.1 - B2a LOT 10"),
            array('id' => 44, 'code' => 'D2', 'name' => "D.2 - C2 LOT 1"),
            array('id' => 45, 'code' => 'D3', 'name' => "D.3 - C2 LOT 1"),
            array('id' => 46, 'code' => 'E1', 'name' => "E.1 - C2 LOT 1"),
            array('id' => 47, 'code' => 'E2', 'name' => "E.2 - C2 LOT 5"),
            array('id' => 48, 'code' => 'E3', 'name' => "E.3 - C2 LOT 5"),
            array('id' => 49, 'code' => 'E4', 'name' => "E.4 - C2 LOT 5"),
            array('id' => 50, 'code' => 'E5', 'name' => "E.5 - C2 LOT 6"),
            array('id' => 51, 'code' => 'E6', 'name' => "E.6 - C2 LOT 6"),


        );
        DB::table('locations')->insert($locations);
    }
}
