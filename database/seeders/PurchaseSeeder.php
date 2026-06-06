<?php

namespace Database\Seeders;

use App\Models\Masters\Gst;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(DB::table('purchases')->count() == 0){
            $gstMap = Gst::pluck('id', 'rate')->toArray();

            $purchases = [
                [
                    'invoice_no' => 'PUR-0001',
                    'supplier_id' => 1,
                    'payment_status' => 'pending',
                    'payment_mode_id' => 1,
                    'items' => [
                        ['product_id' => 1, 'price' => 100, 'qty' => 10, 'discount' => 50, 'gst_rate' => 18],
                        ['product_id' => 2, 'price' => 200, 'qty' => 5,  'discount' => 0,  'gst_rate' => 5],
                    ],
                ],

                [
                    'invoice_no' => 'PUR-0002',
                    'supplier_id' => 2,
                    'payment_status' => 'paid',
                    'payment_mode_id' => 2,
                    'items' => [
                        ['product_id' => 3, 'price' => 150, 'qty' => 10, 'discount' => 100, 'gst_rate' => 12],
                        ['product_id' => 4, 'price' => 300, 'qty' => 2,  'discount' => 50,  'gst_rate' => 18],
                    ],
                ],

                [
                    'invoice_no' => 'PUR-0003',
                    'supplier_id' => 3,
                    'payment_status' => 'partially',
                    'payment_mode_id' => 3,
                    'items' => [
                        ['product_id' => 5, 'price' => 500, 'qty' => 2,  'discount' => 100, 'gst_rate' => 28],
                        ['product_id' => 1, 'price' => 100, 'qty' => 20, 'discount' => 0,   'gst_rate' => 18],
                    ],
                ],

                [
                    'invoice_no' => 'PUR-0004',
                    'supplier_id' => 4,
                    'payment_status' => 'pending',
                    'payment_mode_id' => 1,
                    'items' => [
                        ['product_id' => 2, 'price' => 200, 'qty' => 5, 'discount' => 0, 'gst_rate' => 5],
                    ],
                ],

                [
                    'invoice_no' => 'PUR-0005',
                    'supplier_id' => 5,
                    'payment_status' => 'paid',
                    'payment_mode_id' => 4,
                    'items' => [
                        ['product_id' => 3, 'price' => 250, 'qty' => 10, 'discount' => 200, 'gst_rate' => 12],
                        ['product_id' => 4, 'price' => 300, 'qty' => 5,  'discount' => 100, 'gst_rate' => 18],
                    ],
                ],

                [
                    'invoice_no' => 'PUR-0006',
                    'supplier_id' => 6,
                    'payment_status' => 'partially',
                    'payment_mode_id' => 2,
                    'items' => [
                        ['product_id' => 5, 'price' => 400, 'qty' => 3, 'discount' => 50, 'gst_rate' => 28],
                        ['product_id' => 1, 'price' => 100, 'qty' => 10, 'discount' => 0, 'gst_rate' => 18],
                    ],
                ],
            ];

            foreach ($purchases as $p) {

                $grand = 0;
                $discountTotal = 0;
                $gstTotal = 0;
                $finalTotal = 0;

                $purchaseId = DB::table('purchases')->insertGetId([
                    'invoice_no' => $p['invoice_no'],
                    'invoice_date' => now(),
                    'supplier_id' => $p['supplier_id'],
                    'financial_year_id' => 1,
                    'payment_mode_id' => $p['payment_mode_id'],
                    'payment_status' => $p['payment_status'],
                    'grand_amount' => 0,
                    'gst_amount' => 0,
                    'discount_amount' => 0,
                    'total_amount' => 0,
                    'paid_amount' => 0,
                    'due_amount' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $itemsInsert = [];

                foreach ($p['items'] as $item) {

                    $subTotal = $item['price'] * $item['qty'];
                    $net = $subTotal - $item['discount'];

                    $gstRate = $item['gst_rate'];
                    $gstAmount = ($net * $gstRate) / 100;
                    $total = $net + $gstAmount;

                    $itemsInsert[] = [
                        'purchase_id' => $purchaseId,
                        'product_id' => $item['product_id'],
                        'price' => $item['price'],
                        'quantity' => $item['qty'],
                        'sub_total' => $subTotal,
                        'discount' => $item['discount'],
                        'gst_id' => $gstMap[$gstRate] ?? null,
                        'gst_amount' => $gstAmount,
                        'total' => $total,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    $grand += $subTotal;
                    $discountTotal += $item['discount'];
                    $gstTotal += $gstAmount;
                    $finalTotal += $total;
                }

                DB::table('purchase_items')->insert($itemsInsert);

                DB::table('purchases')
                    ->where('id', $purchaseId)
                    ->update([
                        'grand_amount' => $grand,
                        'discount_amount' => $discountTotal,
                        'gst_amount' => $gstTotal,
                        'total_amount' => $finalTotal,
                        'paid_amount' => match ($p['payment_status']) {
                            'paid' => $finalTotal,
                            'partially' => $finalTotal / 2,
                            default => 0,
                        },
                        'due_amount' => match ($p['payment_status']) {
                            'paid' => 0,
                            'partially' => $finalTotal / 2,
                            default => $finalTotal,
                        },
                    ]);
            }
        }
    }
}
