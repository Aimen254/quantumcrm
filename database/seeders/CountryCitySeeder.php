<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\City;

class CountryCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pakistan = Country::create(['name' => 'Pakistan']);
        $india = Country::create(['name' => 'India']);
        $canada = Country::create(['name' => 'Canada']);
    
        City::insert([
            ['name' => 'Lahore', 'country_id' => $pakistan->id],
            ['name' => 'Karachi', 'country_id' => $pakistan->id],
            ['name' => 'Islamabad', 'country_id' => $pakistan->id],
    
            ['name' => 'Mumbai', 'country_id' => $india->id],
            ['name' => 'Delhi', 'country_id' => $india->id],
    
            ['name' => 'Toronto', 'country_id' => $canada->id],
            ['name' => 'Vancouver', 'country_id' => $canada->id],
        ]);
    }
}
