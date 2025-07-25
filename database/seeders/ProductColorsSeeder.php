<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductColorsSeeder extends Seeder
{
    public function run()
    {
        // Array of web-safe colors
        $colors = [
            ['name' => 'Black', 'hex_code' => '#000000'],
            ['name' => 'Silver', 'hex_code' => '#C0C0C0'],
            ['name' => 'Gray', 'hex_code' => '#808080'],
            ['name' => 'White', 'hex_code' => '#FFFFFF'],
            ['name' => 'Maroon', 'hex_code' => '#800000'],
            ['name' => 'Red', 'hex_code' => '#FF0000'],
            ['name' => 'Purple', 'hex_code' => '#800080'],
            ['name' => 'Fuchsia', 'hex_code' => '#FF00FF'],
            ['name' => 'Green', 'hex_code' => '#008000'],
            ['name' => 'Lime', 'hex_code' => '#00FF00'],
            ['name' => 'Olive', 'hex_code' => '#808000'],
            ['name' => 'Yellow', 'hex_code' => '#FFFF00'],
            ['name' => 'Navy', 'hex_code' => '#000080'],
            ['name' => 'Blue', 'hex_code' => '#0000FF'],
            ['name' => 'Teal', 'hex_code' => '#008080'],
            ['name' => 'Aqua', 'hex_code' => '#00FFFF'],
        ];

        // Insert colors into the product_colors table
        DB::table('product_colors')->insert($colors);
    }
}
