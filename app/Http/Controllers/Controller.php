<?php

namespace App\Http\Controllers;

use App\Models\cart;
use Automattic\WooCommerce\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function convertUSD(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/convert?to=IDR&from=USD&amount=1",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "apikey: Wyqd8y0I4scpYFzwbHlYZuzZSyfChT6n"
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $bv = json_decode($response);
//        dd($bv->result);
        return $bv->result;
    }
    
    public function woocommerce(){
        if (env('APP_ENV_REAL') == 'local') {
            $url = 'http://0.0.0.0:8081/';
            $key = 'ck_fb94ebcd161b6ad4b376e29a7eec108c9c3babe2';
            $secret = 'cs_e3a99fb8bfdc0544de27b6adada9c47083c96d16';
        } else {
            $url = 'https://shop.blotterism.com/';
            $key = 'ck_2961b9f25e3473304a4851b32ca91abb48ffef82';
            $secret = 'cs_be8b74c01e1593b65117d1974a99060a2902de17';
        }
        $woocommerce = new Client(
            $url,
            $key,
            $secret,
            [
                'version' => 'wc/v3',
                'verify_ssl' => false,
                'wp_api' => true,
                'query_string_auth' => true,
            ]
        );

        // old key
        // key: ck_2961b9f25e3473304a4851b32ca91abb48ffef82
        // secret: cs_be8b74c01e1593b65117d1974a99060a2902de17

        return $woocommerce;
    }

    public function cart(){
        // $data = cart::whereStatus('0')->where('customer_id','=',null)->get();
        $data = cart::whereStatus('0')->where('user_id' , Auth::user()->id)->get();


        return $data;
    }
    public function total(){
        $data = cart::whereStatus('0')->whereUserId(Auth::user()->id)->get();

        $tmp = 0;
        foreach ($data as $a){
            $tmp = $tmp + $a->subTotal;
        }
        return $tmp;
    }

    
}
