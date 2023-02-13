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
    
    public function woocommerce()
    {
        $woocommerce = new Client(
            'https://workethicstudio.com/',
            'ck_d0af19fdc508051a34b90ba681635e0b4bcc882a',
            'cs_4aea9aeb04000260238cdaa19995fe8ffdac2c80',
            [
                'version' => 'wc/v3',
            ]
        );

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
