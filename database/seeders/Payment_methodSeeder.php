<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment_method;

class Payment_methodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            'Cash by hand',
            'Cash by Wallet',
            'EasyPaisa'
         ];
      
        foreach ($records as $record) {
            Payment_method::create(['name' => $record]);
        }
    }
}
