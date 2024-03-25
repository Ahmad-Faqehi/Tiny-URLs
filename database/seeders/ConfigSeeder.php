<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Config;
class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        if (Config::where('name', '=', 'redis')->get()->count() == 0){

            DB::table('config')->insert([
                'name' => 'redis',
                'status' => 1,
                'description' => 'This field for redis if is working',
            ]);

        }
    }
}
