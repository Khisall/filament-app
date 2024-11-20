<?php

namespace Database\Seeders;

use App\Models\PatrolCheck;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PatrolCheckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // B3 AREA
            ['area_main' => 'B3 AREA', 'area_name' => 'Compressore Room B3', 'check_description' => 'a. Ensuring the Fence Compressore room Is Closed and Functioning Properly. b. Ensuring compressore no suspicious thing (Leakage) or sabotage. c. Ensuring No Pipe Leaks From Cooling Tower.'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Compressore Room B3', 'check_description' => 'a. Memastikan Pagar Ruangan Kompresor Tertutup Dan Berfungsi Dengan Baik. b. Memastikan Tidak Ada hal yang mencurigakan (kebocoran) atau sabotase. c. Memastikan tidak ada kebocoran dari cooling tower.'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Store Plant Maintenance', 'check_description' => 'a. Ensuring Door store plant Are Locked and Good Condition. b. Ensuring the Area is Clean and Neat.'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Store Plant Maintenance', 'check_description' => 'a. Memastikan Pintu ruangan store plant dalam kondisi terkunci dan keadaan baik. b. Memastikan kondisi area bersih dan rapi.'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Compressor Room Mcc', 'check_description' => 'a. Ensuring the Fence Compressore room Is Closed and Functioning Properly. b. Ensuring compressore no suspicious thing (Leakage) or sabotage. c. Ensure no leakage from cooling tower.'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Compressor Room Mcc', 'check_description' => 'a. Memastikan Pagar Ruangan Kompresor Tertutup Dan Berfungsi Dengan Baik. b. Memastikan Tidak Ada hal yang mencurigakan (kebocoran) atau sabotase. c. Memastikan tidak ada kebocoran di area cooling tower.'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Scrap Area Gate 2B', 'check_description' => 'a. Make sure the gate 2B is closed and locked. b. Ensuring the Area is Clean and Neat. c. Ensuring There Are No Objects And Suspicious Conditions. d. Ensuring Security guard at Gate 2 standby at post 2.'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Scrap Area Gate 2B', 'check_description' => 'a. Memastikan Pagar 2B Dalam Kondisi Tertutup dan Terkunci. b. Memastikan Area Dalam Kondisi Bersih dan Rapi. c. Memastikan Tidak Ada Benda Dan Kondisi Yang Mencurigakan. d. Memastikan Petugas Security berada di pos 2.'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Compressor Room Mcc Lot 10', 'check_description' => 'a. Ensuring the Fence Compressore room Is Closed and Functioning Properly. b. Ensuring compressore no suspicious thing (Leakage) or sabotage.'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Compressor Room Mcc Lot 10', 'check_description' => 'a. Memastikan Pagar Ruangan Kompresor Tertutup Dan Berfungsi Dengan Baik. b. Memastikan Tidak Ada hal yang mencurigakan (kebocoran) atau sabotase.'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Smoking Area & Parking', 'check_description' => 'a. Ensuring Parking Vehicles in Accordance with the Rules. b. Ensuring Smoking Areas Are Neat and Clean. c. Ensuring Access Doors to carton scrap area Always Closed and Locked.'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Smoking Area & Parking', 'check_description' => 'a. Memastikan Kendaraan Parkir Sesuai Dengan Aturan. b. Memastikan Area Smoking Dalam Kondisi Rapi dan Bersih. c. Memastikan Pintu Akses ke area scrap karton Selalu Kondisi Tertutup dan Terkunci.'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Back Of B3 Factory', 'check_description' => 'a. Ensuring There Is No Sabotage From Outside Or Inside From. b. Ensuring There Are No Things That Suspect The Area.'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Back Of B3 Factory', 'check_description' => 'a. Memastikan Tidak ada Sabotase dari Luar Maupun Dari Dalam. b. Memastikan Tidak Ada Hal-hal Yang Mencurigakan Diarea Tersebut.'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Linkway B2-B4', 'check_description' => 'a. Ensuring Officers Standby at The Post. b. Ensuring Lights Are Already On (Night Shift) / Off (Day Shift).'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Linkway B2-B4', 'check_description' => 'a. Memastikan Petugas Ada & Dalam Kondisi Stand By Di pos. b. Memastikan Kondisi Lampu Sudah Dalam Kondisi Hidup/Mati.'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Storage & SCM', 'check_description' => 'Ensuring Areas Are Safe and There Is No Potential Sabotage From Outside Or Inside.'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Storage & SCM', 'check_description' => 'Memastikan area tersebut dalam kondisi aman dan tidak ada potensi sabotase baik dari luar maupun dalam.'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Lighting', 'check_description' => 'Ensure that all lights turn on, especially the coverage area included in the CCTV monitor area. If something is damaged, immediately report it to the Plant for re-functioning within 48 hours.'],
            ['area_main' => 'B3 AREA', 'area_name' => 'Lighting', 'check_description' => 'Memastikan semua lampu menyala terutama cakupan area yang masuk dalam areal monitor CCTV. Jika ada yang rusak segera dilaporkan ke Plant untuk difungsikan kembali paling lambat 48 jam.'],

            // B2 AREA
            ['area_main' => 'B2 AREA', 'area_name' => 'General Waste Area', 'check_description' => 'Ensuring temporary waste storage doors are locked.'],
            ['area_main' => 'B2 AREA', 'area_name' => 'General Waste Area', 'check_description' => 'Memastikan Pintu TPS Dalam Kondisi Tergembok.'],
            ['area_main' => 'B2 AREA', 'area_name' => 'Springkle Pump', 'check_description' => 'a. Ensuring there are no suspicious objects around the tank. b. Ensuring there is no trial of sabotage from outside / inside.'],
            ['area_main' => 'B2 AREA', 'area_name' => 'Springkle Pump', 'check_description' => 'a. Memastikan Tidak Ada Benda Yang Mencurigakan Disekitar Tangki. b. Memastikan Tidak Ada Percobaan Sabotase Dari Luar/Dalam.'],
            ['area_main' => 'B2 AREA', 'area_name' => 'Server Room', 'check_description' => 'a. Ensuring the door are closed and locked. b. Ensuring that there are no sabotage trials from outside / inside.'],
            ['area_main' => 'B2 AREA', 'area_name' => 'Server Room', 'check_description' => 'a. Memastikan Kondisi Pintu Tertutup dan Terkunci. b. Memastikan Tidak Ada Percobaan Sabotase Dari Luar/Dalam.'],
            ['area_main' => 'B2 AREA', 'area_name' => 'Scrap Area', 'check_description' => 'a. Make Sure There Are No Objects And Suspicious Conditions. b. Ensuring the Area is Clean and Neat. c. Ensuring the Door Is Closed and Locked.'],
            ['area_main' => 'B2 AREA', 'area_name' => 'Scrap Area', 'check_description' => 'a. Pastikan Tidak Ada Benda Dan Kondisi Yang Mencurigakan. b. Memastikan Area Dalam Kondisi Bersih dan Rapi. c. Memastikan Pintu Dalam Kondisi Tertutup dan Terkunci.'],
            ['area_main' => 'B2 AREA', 'area_name' => 'MRS Natural Gas', 'check_description' => 'a. Ensuring the Door Is Closed and Locked. b. Ensuring No Gas Leaks in the Area. c. Ensuring No Suspicious Objects / Conditions.'],
            ['area_main' => 'B2 AREA', 'area_name' => 'MRS Natural Gas', 'check_description' => 'a. Memastikan Pintu Dalam Kondisi Tertutup dan Terkunci. b. Memastikan Tidak Ada Kebocoran Gas Diarea Tersebut. c. Memastikan Tidak Ada Benda/Kondisi Yang Mencurigakan.'],

            // B1 AREA
            ['area_main' => 'B1 AREA', 'area_name' => 'General Waste Area', 'check_description' => 'a. Ensuring temporary waste storage doors are locked. b. Ensuring No Suspicious Objects / Conditions. c. Ensuring Lights Are Already On (Night Shift) / Off(Day Shift).'],
            ['area_main' => 'B1 AREA', 'area_name' => 'General Waste Area', 'check_description' => 'a. Memastikan Pintu TPS Dalam Kondisi Tergembok. b. Memastikan Tidak Ada Benda/Kondisi Yang Mencurigakan. c. Memastikan Kondisi Lampu Sudah Dalam Kondisi Hidup/Mati.'],
            ['area_main' => 'B1 AREA', 'area_name' => 'Store Loading and Unloading', 'check_description' => 'a. Ensuring The Gate Is Locked when no activities. b. Ensuring the Gate Is Good Condition to Function Properly. c. Ensuring Area Conditions There Are Nothing Suspicious.'],
            ['area_main' => 'B1 AREA', 'area_name' => 'Store Loading and Unloading', 'check_description' => 'a. Memastikan Pintu Gate Dalam Kondisi Terkunci jika tidak ada aktifitas. b. Memastikan Kondisi Gate Berfungsi Dengan Baik. c. Memastikan Kondisi Area Tidak Ada Hal-hal Yang Mencurigakan.'],
            ['area_main' => 'B1 AREA', 'area_name' => 'Security Post 4', 'check_description' => 'a. Ensuring The Security Guard Standby at The Post. b. Ensuring Gate Doors Are Locked. c. Ensuring Gate Good Conditions & Function Properly.'],
            ['area_main' => 'B1 AREA', 'area_name' => 'Security Post 4', 'check_description' => 'a. Memastikan Petugas Ada & Dalam Berjaga Di Pos. b. Memastikan Pintu Gate Dalam Kondisi Terkunci. c. Memastikan Kondisi Gate Berfungsi Dengan Baik.'],
            ['area_main' => 'B1 AREA', 'area_name' => 'Die cast', 'check_description' => 'a. Ensuring that there are no Oil Spills and Other B3 waste. b. Ensuring that No Employee Smokes the Area. c. Ensuring Area Conditions There Are Nothing Suspicious.'],
            ['area_main' => 'B1 AREA', 'area_name' => 'Die Cast', 'check_description' => 'a. Memastikan Tidak Ada Tumpahan Oli dan limbah B3 Lainnya. b. Memastikan Tidak Ada Karyawan Yang Merokok Diarea Tersebut. c. Memastikan Kondisi Area Tidak Ada Hal-hal Yang Mencurigakan.'],
            ['area_main' => 'B1 AREA', 'area_name' => 'Die Cast Back Area / MCC Ladder', 'check_description' => 'a. Ensuring No Pipe Leaks From Cooling Tower Die Casting. b. Ensuring No Damage to the Net Fence. c. Ensuring Area Conditions There Are Nothing Suspicious.'],
            ['area_main' => 'B1 AREA', 'area_name' => 'Die Cast Back Area / MCC Ladder', 'check_description' => 'a. Memastikan Tidak Ada Kebocoran Pipa Dari Cooling Tower DC. b. Memastikan Tidak Ada Kerusakan Pada Pagar Net. c. Memastikan Kondisi Area Tidak Ada Hal-hal Yang Mencurigakan.'],
        ];

        foreach ($data as $item) {
            PatrolCheck::firstOrCreate([
                'area_main' => $item['area_main'],
                'area_name' => $item['area_name'],
                'check_description' => $item['check_description'],
            ]);
        }
    }
}
