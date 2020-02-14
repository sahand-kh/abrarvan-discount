<?php

namespace App\Http\Controllers;

use App\Helpers\ApplyDiscountHelper;
use App\Helpers\JsonDecoder;
use App\Models\Discount;
use App\Models\DiscountUserPivot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApplyDiscountController extends Controller
{

    public function apply(Request $request)
    {
        $discountHelper = new ApplyDiscountHelper();

        if ($json = (new JsonDecoder())->applyDiscount($request)):

            $discount = Discount::where('code', $json['code'])->first();
            if (!$discount)
                return $discountHelper->formatResponse(false, 'no such a discount code');

            if ($discount->count < 1)
                return $discountHelper->formatResponse(false, 'All code consumed already');

            $discountUserPivot = DiscountUserPivot::where('discount_id', $discount->id)->where('wallet_id', $json['wallet_id'])->first();
            if ($discountUserPivot)
                return $discountHelper->formatResponse(false, 'User already used this discount code');

            return $discountHelper->applyDiscountForUser($discount, $json['wallet_id']);

        endif;
        return $discountHelper->formatResponse(false, 'json format in invalid');

    }
}
