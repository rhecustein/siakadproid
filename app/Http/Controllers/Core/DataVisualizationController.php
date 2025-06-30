<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Generator as Faker;

class DataVisualizationController extends Controller
{
    public function index()
    {
        return view('visualizations.map.index');
    }

    public function getSchoolData(Faker $faker)
    {
        $dummySchools = [];

        // Buat 100 sekolah acak tersebar di Indonesia
        for ($i = 1; $i <= 100; $i++) {
            $latitude = $faker->randomFloat(6, -10.5, 5.5);   // Indonesia Latitude
            $longitude = $faker->randomFloat(6, 95.0, 141.0); // Indonesia Longitude

            $dummySchools[] = [
                'type' => 'Feature',
                'properties' => [
                    'name' => "Sekolah Al-Bahjah #$i",
                    'student_count' => $faker->numberBetween(100, 1000),
                ],
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [(float) $longitude, (float) $latitude],
                ],
            ];
        }

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $dummySchools,
        ]);
    }

    public function getStudentData(Faker $faker)
    {
        $dummyStudents = [];

        // Lokasi pusat kota besar Indonesia
        $baseLocations = [
            ['lat' => -6.2, 'lon' => 106.8],   // Jakarta
            ['lat' => -7.25, 'lon' => 112.75], // Surabaya
            ['lat' => -6.9, 'lon' => 107.6],   // Bandung
            ['lat' => -0.9, 'lon' => 100.3],   // Padang
            ['lat' => 3.6,  'lon' => 98.7],    // Medan
            ['lat' => -5.1, 'lon' => 119.5],   // Makassar
        ];

        foreach ($baseLocations as $base) {
            for ($i = 0; $i < 500; $i++) {
                $dummyStudents[] = [
                    'latitude' => $base['lat'] + $faker->randomFloat(6, -0.3, 0.3),
                    'longitude' => $base['lon'] + $faker->randomFloat(6, -0.3, 0.3),
                ];
            }
        }

        return response()->json($dummyStudents);
    }
}
