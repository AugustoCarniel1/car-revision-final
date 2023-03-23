<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarBrand;

class CarBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CarBrand::create(['description' => 'Alfa Romeo']);
        CarBrand::create(['description' => 'Audi']);
        CarBrand::create(['description' => 'BMW']);
        CarBrand::create(['description' => 'Chevrolet']);
        CarBrand::create(['description' => 'Dodge']);
        CarBrand::create(['description' => 'Fiat']);
        CarBrand::create(['description' => 'Ford']);
        CarBrand::create(['description' => 'Honda']);
        CarBrand::create(['description' => 'Hyundai']);
        CarBrand::create(['description' => 'Jaguar']);
        CarBrand::create(['description' => 'Jeep']);
        CarBrand::create(['description' => 'Kia']);
        CarBrand::create(['description' => 'Mazda']);
        CarBrand::create(['description' => 'Mercedes']);
        CarBrand::create(['description' => 'Mini']);
        CarBrand::create(['description' => 'Mitsubishi']);
        CarBrand::create(['description' => 'Nissan']);
        CarBrand::create(['description' => 'Prsche']);
        CarBrand::create(['description' => 'Ram']);
        CarBrand::create(['description' => 'Smart']);
        CarBrand::create(['description' => 'Subaru']);
        CarBrand::create(['description' => 'Suzuki']);
        CarBrand::create(['description' => 'Tesla']);
        CarBrand::create(['description' => 'Toyota']);
        CarBrand::create(['description' => 'Volkswagen']);
        CarBrand::create(['description' => 'Volvo']);
    }
}
