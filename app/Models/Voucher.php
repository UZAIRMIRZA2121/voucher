<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'language',
        'voucher_name',
        'voucher_description',
        'item_image',
        'item_thumbnail',
        'store_id',
        'category_id',
        'sub_category_id',
        'customer_id',
        'nutrition',
        'allergen_ingredients',
        'branch_id',
        'provider_id',
        'discount_type',
        'price',
        'minimum_purchase',
        'maximum_discount',
        'limit_per_user',
        'start_date',
        'end_date',
        'daily_start_time',
        'daily_end_time',
        'addon_ids',
        'voucher_options',
        'food_variations',
        'tags',
        'payment_methods',
        'offer_receiving_methods',
        'qr_code',
        'barcode',
    ];

    protected $casts = [
        'addon_ids' => 'array',
        'voucher_options' => 'array',
        'food_variations' => 'array',
        'tags' => 'array',
        'payment_methods' => 'array',
        'offer_receiving_methods' => 'array',
    ];
}
