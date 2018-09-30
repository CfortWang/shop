<?php

namespace App\Helpers;

class ParamValidationHelper
{
    public static function isValidSeqListStr($seqListStr)
    {
        $seqList = explode(',', $seqListStr);
        $seqCollection = collect($seqList);
        $filteredSeqCollection = $seqCollection->filter(function ($value, $key) {
            if (intval($value) == $value) return intval($value) > 0;
            return false;
        });

        if (count($seqList) != count($filteredSeqCollection)) {
            return false;
        } else {
            return $filteredSeqCollection;
        }
    }
}
