<?php

use App\Setting;
use App\Library\Encryption;

if (!function_exists('setting')) {
    /**
     * description
     *
     * @param
     * @return
     */
    function setting($key) {

        $data = Setting::whereName($key)->first();

        if($data) {
            return $data->value;
        } else {
            return '';
        }
    }
}

if (!function_exists('encode_id')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function encode_id($string) {
        // $enkripsi = new Encryption();
        $key      = "KfqUsXXhY0nhhqrmovEx5qQZ";
        $string   = $key.$string;

        // return $enkripsi->encrypt($string,$key);
        return str_replace(['+','/','='], ['-','_',''], base64_encode($string));
    }
}

if (!function_exists('decode_id')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function decode_id($encrypted) {
        // $enkripsi = new Encryption();
        $key       = "KfqUsXXhY0nhhqrmovEx5qQZ";
        $decrypt   = base64_decode(str_replace(['-','_'], ['+','/'], $encrypted));

        // return $enkripsi->decrypt($encrypted, $key);
        return str_replace($key,'',$decrypt);
    }
}

if (!function_exists('decode_url')) {
    /**
     * description
     *
     * @param
     * @return
     */
    function rupiah($angka){

        $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
        return $hasil_rupiah;

    }
}
