<?php

namespace App\Http\Controllers;

use App\Helpers\JsonDecoder;
use App\Models\discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Todo: add pagination
        return json_encode(Discount::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            if ($json = (new JsonDecoder())->createDiscount($request)):

                $discount = new Discount();
                if ($discount->codeExists($json['code']))
                    return'The discount code already exists';
                $discount->create($json);
                return "discount defined successfully";
            endif;
            return "json format is invalid";

        } catch (\Exception $e) {
            Log::error('Discount code can not be defined ' . $e->getMessage());
            return "discount code can not be defined";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show($discountCode)
    {
        $discount = discount::where('code', $discountCode)->first();
        if ($discount)
            return json_encode($discount);
        return "no such a discount code";
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy($discountCode)
    {
        $discount = discount::where('code', $discountCode)->first();
        if ($discount):
            try {
                $discount->delete();
                return "discount code removed";
            } catch (\Exception $e) {
                if (0 !== strpos($e->getCode(), '23'))
                    return "Discount code can not be removed because some users already used it";
                Log::error('discount can not be removed ' . $e->getMessage());
                return "discount removal failure";
            }
        endif;
        return "no such a discount code";
    }
}
