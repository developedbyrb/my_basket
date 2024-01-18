<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait GenerateSkus
{
    /**
     * @param  Request  $request
     * @return $this|false|string
     */
    public function generate($name, $id, $brand, $variantData, $l = 2)
    {
        unset($variantData['price']);
        unset($variantData['is_default']);
        unset($variantData['avail_stock']);
        $variantString = '';
        foreach ($variantData as $key => $value) {
            $variantString .= mb_substr($key, 0, 1).$value;
        }
        $results = ''; // empty string

        $str1 = mb_substr($name, 0, $l);
        $str1 = strtoupper(substr($str1, 0, $l));

        $str3 = mb_substr($brand, 0, $l);
        $str3 = strtoupper(substr($str3, 0, $l));

        $id = str_pad($id, 4, 0, STR_PAD_LEFT);

        $results .= "{$str1}-{$str3}{$id}{$variantString}";

        return $results;
    }

    private function unique_code($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

    private function getNameCode($name)
    {
        $words = explode(' ', $name);
        $acronym = '';

        foreach ($words as $w) {
            $acronym .= mb_substr($w, 0, 2);
        }

        return $acronym;
    }
}
