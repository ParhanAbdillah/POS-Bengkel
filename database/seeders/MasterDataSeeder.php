<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Sparepart;
use App\Models\Category;
use App\Models\Services;
use App\Models\Mechanics;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        Schema::disableForeignKeyConstraints();
        DB::table('spareparts')->truncate();
        DB::table('categories')->truncate();
        DB::table('services')->truncate();
        DB::table('mechanics')->truncate();
        Schema::enableForeignKeyConstraints();

        // Create 8 Categories
        $categories = [
            'Engine',
            'Undercarriage',
            'Drivetrain',
            'Electrical',
            'Braking',
            'Filter & Fluids',
            'Fast Moving',
            'Slow Moving'
        ];

        foreach ($categories as $catName) {
            Category::create(['name_category' => $catName]);
        }

        // Create 8 Spareparts matching the categories
        $spareparts = [
            ['name' => 'Piston Kit Honda', 'category_id' => 1, 'brand' => 'Honda', 'stock' => 15, 'min' => 5, 'purchase' => 150000, 'selling' => 180000],
            ['name' => 'Ban Luar FDR', 'category_id' => 2, 'brand' => 'FDR', 'stock' => 20, 'min' => 5, 'purchase' => 180000, 'selling' => 220000],
            ['name' => 'V-Belt CVT Yamaha', 'category_id' => 3, 'brand' => 'Yamaha', 'stock' => 25, 'min' => 5, 'purchase' => 80000, 'selling' => 110000],
            ['name' => 'Aki GS Astra', 'category_id' => 4, 'brand' => 'Astra', 'stock' => 10, 'min' => 3, 'purchase' => 200000, 'selling' => 250000],
            ['name' => 'Kampas Rem Depan Honda', 'category_id' => 5, 'brand' => 'Honda', 'stock' => 30, 'min' => 10, 'purchase' => 40000, 'selling' => 60000],
            ['name' => 'Oli Mesin MPX 1', 'category_id' => 6, 'brand' => 'Honda', 'stock' => 50, 'min' => 15, 'purchase' => 45000, 'selling' => 55000],
            ['name' => 'Busi NGK', 'category_id' => 7, 'brand' => 'NGK', 'stock' => 40, 'min' => 10, 'purchase' => 15000, 'selling' => 20000],
            ['name' => 'Gear Set SSS', 'category_id' => 8, 'brand' => 'SSS', 'stock' => 10, 'min' => 2, 'purchase' => 250000, 'selling' => 300000],
        ];

        foreach ($spareparts as $sp) {
            Sparepart::create([
                'sku' => 'SP-' . strtoupper($faker->bothify('####??')),
                'name_sparepart' => $sp['name'],
                'category_id' => $sp['category_id'],
                'brand_sparepart' => $sp['brand'],
                'stock_sparepart' => $sp['stock'],
                'min_stock_sparepart' => $sp['min'],
                'purchase_price' => $sp['purchase'],
                'selling_price' => $sp['selling'],
            ]);
        }

        // Create 8 Services with cheap prices (jasa only)
        $services = [
            ['name' => 'Ganti Oli', 'price' => 15000],
            ['name' => 'Servis Ringan', 'price' => 35000],
            ['name' => 'Ganti Kampas Rem', 'price' => 20000],
            ['name' => 'Ganti V-Belt', 'price' => 25000],
            ['name' => 'Ganti Busi', 'price' => 10000],
            ['name' => 'Pengecekan Kelistrikan', 'price' => 30000],
            ['name' => 'Servis Injeksi / Karburator', 'price' => 45000],
            ['name' => 'Tambal Ban Tubeless', 'price' => 15000],
        ];

        foreach ($services as $srv) {
            Services::create([
                'name_service' => $srv['name'],
                'price_service' => $srv['price'],
            ]);
        }

        // Create 8 Mechanics
        $mechanicNames = [
            'Budi Santoso',
            'Agus Supriyanto',
            'Iwan Setiawan',
            'Joko Susanto',
            'Ridwan',
            'Dedi Mulyadi',
            'Ahmad',
            'Sutisna'
        ];

        foreach ($mechanicNames as $index => $name) {
            Mechanics::create([
                'name_mechanic' => $name,
                'phone_mechanic' => '0812' . str_pad($index + 1, 8, '0', STR_PAD_LEFT),
                'address_mechanic' => 'Jl. Pendidikan No. ' . ($index + 1) . ', Tasikmalaya',
            ]);
        }
    }
}
