<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $unitPiece = Unit::updateOrCreate(['name' => 'Piece'], ['short_name' => 'pcs', 'is_active' => true]);
        $unitPack = Unit::updateOrCreate(['name' => 'Pack'], ['short_name' => 'pack', 'is_active' => true]);

        $stationery = Category::updateOrCreate(['name' => 'Stationery'], ['is_active' => true]);
        $office = Category::updateOrCreate(['name' => 'Office Supplies'], ['is_active' => true]);
        $printing = Category::updateOrCreate(['name' => 'Printing'], ['is_active' => true]);

        $atlas = Brand::updateOrCreate(['name' => 'Atlas'], ['is_active' => true]);
        $richard = Brand::updateOrCreate(['name' => 'Richard'], ['is_active' => true]);
        $jr = Brand::updateOrCreate(['name' => 'JR Marketing'], ['is_active' => true]);

        Supplier::updateOrCreate(
            ['code' => 'SUP-001'],
            [
                'name' => 'Colombo Stationery Suppliers',
                'contact_person' => 'Nimal Perera',
                'phone' => '0771234567',
                'email' => 'supplier@example.test',
                'address' => 'Colombo, Sri Lanka',
                'is_active' => true,
            ]
        );

        Customer::updateOrCreate(
            ['code' => 'CUS-001'],
            [
                'name' => 'Walk-in Customer',
                'phone' => '0110000000',
                'email' => 'customer@example.test',
                'address' => 'Sri Lanka',
                'is_active' => true,
            ]
        );

        $products = [
            [
                'sku' => 'JR-PEN-001',
                'barcode' => '479000100001',
                'name' => 'Atlas Blue Ballpoint Pen',
                'category_id' => $stationery->id,
                'brand_id' => $atlas->id,
                'unit_id' => $unitPiece->id,
                'cost_price' => 35,
                'selling_price' => 50,
                'wholesale_price' => 45,
                'quantity' => 250,
                'reorder_level' => 25,
            ],
            [
                'sku' => 'JR-BOOK-002',
                'barcode' => '479000100002',
                'name' => 'CR Exercise Book 120 Pages',
                'category_id' => $stationery->id,
                'brand_id' => $richard->id,
                'unit_id' => $unitPiece->id,
                'cost_price' => 160,
                'selling_price' => 220,
                'wholesale_price' => 200,
                'quantity' => 120,
                'reorder_level' => 20,
            ],
            [
                'sku' => 'JR-A4-003',
                'barcode' => '479000100003',
                'name' => 'A4 Copy Paper 500 Sheets',
                'category_id' => $office->id,
                'brand_id' => $jr->id,
                'unit_id' => $unitPack->id,
                'cost_price' => 1450,
                'selling_price' => 1750,
                'wholesale_price' => 1650,
                'quantity' => 40,
                'reorder_level' => 10,
            ],
            [
                'sku' => 'JR-INK-004',
                'barcode' => '479000100004',
                'name' => 'Printer Ink Bottle Black',
                'category_id' => $printing->id,
                'brand_id' => $jr->id,
                'unit_id' => $unitPiece->id,
                'cost_price' => 950,
                'selling_price' => 1250,
                'wholesale_price' => 1150,
                'quantity' => 18,
                'reorder_level' => 8,
            ],
            [
                'sku' => 'JR-FILE-005',
                'barcode' => '479000100005',
                'name' => 'Box File 3 Inch',
                'category_id' => $office->id,
                'brand_id' => $jr->id,
                'unit_id' => $unitPiece->id,
                'cost_price' => 280,
                'selling_price' => 420,
                'wholesale_price' => 390,
                'quantity' => 75,
                'reorder_level' => 15,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['sku' => $product['sku']],
                $product + ['is_active' => true]
            );
        }
    }
}
