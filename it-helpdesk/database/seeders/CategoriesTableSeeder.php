<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Hardware',
                'description' => 'Kerusakan perangkat keras seperti komputer, laptop, printer, scanner, monitor, dll'
            ],
            [
                'name' => 'Software',
                'description' => 'Masalah pada aplikasi, sistem operasi, atau software yang digunakan dalam operasional hotel'
            ],
            [
                'name' => 'Network',
                'description' => 'Gangguan jaringan internet, WiFi, koneksi LAN, atau masalah pada server'
            ],
            [
                'name' => 'Printer',
                'description' => 'Masalah pada mesin printer, scanner, mesin fotocopy, atau alat cetak lainnya'
            ],
            [
                'name' => 'Email',
                'description' => 'Masalah terkait email perusahaan, login email, atau pengiriman email'
            ],
            [
                'name' => 'Database',
                'description' => 'Masalah pada database, SQL, atau sistem informasi manajemen hotel'
            ],
            [
                'name' => 'Security',
                'description' => 'Masalah keamanan sistem, akses user, virus, atau malware'
            ],
            [
                'name' => 'Other',
                'description' => 'Masalah lainnya yang tidak termasuk dalam kategori di atas'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}