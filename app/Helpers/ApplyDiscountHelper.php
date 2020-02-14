<?php


namespace App\Helpers;


use App\Models\Discount;
use App\Models\DiscountUserPivot;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApplyDiscountHelper
{
    public function applyDiscountForUser(Discount $discount, $walletId)
    {
        try {
            DB::beginTransaction();

            $discount->reduceCount();
            DiscountUserPivot::create([
                'wallet_id' => $walletId,
                'discount_id' => $discount->id,
            ]);

            DB::commit();
            return $this->formatResponse(true, 'discount code applied', $discount->value);
        } catch(\Exception $e) {
            Log::error('discount code can not applied for user. ' . $e->getMessage());
            return $this->formatResponse(false, 'discount code can not applied for user. for more information view the logs');
        }
    }


    public function formatResponse($status, $message, $value=0)
    {
        $response['status'] = $status;
        $response['message'] = $message;
        $response['value'] = $value;
        return json_encode($response);
    }
}
