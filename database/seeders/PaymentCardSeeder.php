<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentCard;

class PaymentCardSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 test payment cards with initial saldo
        $cards = [
            [
                'card_code' => PaymentCard::generateCardCode(),
                'barcode_data' => 'BARCODE001',
                'username' => 'card_001',
                'holder_name' => 'Andi Wijaya',
                'saldo' => 1000000,
                'status' => 'active',
            ],
            [
                'card_code' => PaymentCard::generateCardCode(),
                'barcode_data' => 'BARCODE002',
                'username' => 'card_002',
                'holder_name' => 'Budi Santoso',
                'saldo' => 500000,
                'status' => 'active',
            ],
            [
                'card_code' => PaymentCard::generateCardCode(),
                'barcode_data' => 'BARCODE003',
                'username' => 'card_003',
                'holder_name' => 'Citra Dewi',
                'saldo' => 750000,
                'status' => 'active',
            ],
            [
                'card_code' => PaymentCard::generateCardCode(),
                'barcode_data' => 'BARCODE004',
                'username' => 'card_004',
                'holder_name' => 'Dedi Hermawan',
                'saldo' => 250000,
                'status' => 'active',
            ],
            [
                'card_code' => PaymentCard::generateCardCode(),
                'barcode_data' => 'BARCODE005',
                'username' => 'card_005',
                'holder_name' => 'Eka Putri',
                'saldo' => 2000000,
                'status' => 'active',
            ],
        ];

        foreach ($cards as $card) {
            PaymentCard::create($card);
        }
    }
}
