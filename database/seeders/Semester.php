<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Semester extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('semesters')->insert([
            ['name' => 'ឆមាសទី ១'],
            ['name' => 'ឆមាសទី ២'],
            ['name' => 'ឆមាសទី ៣'],
            ['name' => 'ឆមាសទី ៤']
        ]);

    }
}
