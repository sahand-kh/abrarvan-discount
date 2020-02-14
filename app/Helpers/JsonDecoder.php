<?php


namespace App\Helpers;


use Illuminate\Http\Request;

class JsonDecoder
{
    public function createDiscount(Request $request)
    {
        if(!$json = $this->checkJsonSignature($request, 'discount'))
            return false;

        if (array_diff_key(array_flip(['code', 'value', 'count']), $json))
            return false;

        return $json;
    }


    public function applyDiscount(Request $request)
    {
        if(!$json = $this->checkJsonSignature($request, 'discount'))
            return false;

        if (array_diff_key(array_flip(['code', 'wallet_id']), $json))
            return false;

        return $json;
    }


    private function checkJsonSignature(Request $request, $fieldName)
    {
        if(!$request->has($fieldName))
            return false;

        $json =  json_decode($request->get($fieldName), true);

        if(json_last_error() != JSON_ERROR_NONE)
            return false;
        return $json;
    }
}
