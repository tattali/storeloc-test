<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Service;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Service::factory()->count(20)->create();
        Store::factory()->count(100)->create();
        $services = Service::all();
        Store::select('id')->cursor()->each(function ($store) use ($services) {
            DB::table('service_store')->insert($services->random(3)->map(function ($service) use ($store) {
                return [
                    'service_id' => $service->id,
                    'store_id' => $store->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            })->all());
        });
    }
}
