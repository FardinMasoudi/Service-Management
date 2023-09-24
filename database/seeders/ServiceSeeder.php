<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $services = ['service1', 'service2', 'service3'];

        foreach ($services as $service) {
            Service::query()->firstOrCreate(
                ['title' => $service],
                [
                    'title' => $service
                ]
            );
        }
    }
}
