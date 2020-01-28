<?php


namespace App\Http\Controllers;


use PrintuCo\LaravelPayU\LaravelPayU;

class PayuController extends Controller
{

    private $banks =array();

    public function getPaymentMethods()
    {
        LaravelPayU::setPayUEnvironment();

        $array=\PayUPayments::getPaymentMethods('es');
        return response()->json([
            [
                'isSuccess' => true,
                //  'count' => $data->count(),
                'status' => 200,
                'objects' =>  $array
            ]
        ]);
    }

    public function getPseBanks()
    {


        LaravelPayU::getPSEBanks(function($response) {
            //... Usar datos de bancos

            $this->banks=$response;


        }, function($error) {

        });

        return response()->json([
            [
                'isSuccess' => true,
                //  'count' => $data->count(),
                'status' => 200,
                'objects' =>  $this->banks
            ]
        ]);
    }

}