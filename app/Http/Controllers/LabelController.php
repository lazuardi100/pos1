<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;

class LabelController extends Controller
{
    public function index()
    {
        return view('dashboard.label.index');
    }

    public function printLabel(Request $request){
        $source = $request->source;
        $data = [];

        if($source == 'woo'){
            // get all product from woo
            $woo_products = (array) $this->woocommerce()->get('products');
            $data = $this->convertDataWoo($woo_products);
        }

        return view('dashboard.label.printpage', [
            'datas' => $data,
            'source' => $source
        ]);
    }

    private function convertDataWoo($woo_products){
        $data = [];
        foreach ($woo_products as $woo_product) {
            // check if attributes contain size
            $temp_data = new stdClass();
            $is_size = false;
            foreach ($woo_product->attributes as $attribute) {
                if($attribute->name == 'Size'){
                    $is_size = true;

                    foreach($attribute->options as $option){
                        $temp_data->id = $woo_product->id;
                        $temp_data->name = $woo_product->name;
                        $temp_data->price = $woo_product->price;
                        $temp_data->stock = $woo_product->stock_quantity;
                        $temp_data->size = $option;
                        $data[] = $temp_data;
                    }
                    break;
                }
            }
            if($is_size){
                continue;
            }
            
            $temp_data->id = $woo_product->id;
            $temp_data->name = $woo_product->name;
            $temp_data->price = $woo_product->price;
            $temp_data->stock = $woo_product->stock_quantity;
            $temp_data->size = '-';
            
            $data[] = $temp_data;
        }

        // dd($data);
        return $data;
    }
}
