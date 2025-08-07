<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    Company::create([
        'name' => 'PT Contoh Sukses Makmur',
        'address' => 'Jl. Anggrek No. 123',
        'email' => 'admin@contohsukses.co.id',
        'latitude' => '-6.200000',
        'longitude' => '106.816666',
        'radius_km' => '3',
        'time_in' => '08:00',
        'time_out' => '17:00',
    ]);
}
}
