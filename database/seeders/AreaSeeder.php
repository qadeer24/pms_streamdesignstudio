<?php
namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    
    public function run()
    {
        $khi_areas  = [
                    'Sohrab Goth', 
                    'Al-Asif', 
                    'Sadar', 
                    'Cantt-Khi', 
                ];


        $hyd_areas  = [
                    'Maji Hospital', 
                    'Qasim Chock', 
                    '7 No#', 
                    'Badin Stop', 
                ];


      
        foreach ($khi_areas as $key => $area) {
            Area::create([
                            'city_id'  => 1,
                            'name'  => $area
                        ]);
        }

        foreach ($hyd_areas as $key => $area) {
            Area::create([
                            'city_id'  =>  9,
                            'name'  => $area
                        ]);
        }
    }
}
