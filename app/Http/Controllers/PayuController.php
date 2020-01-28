<?php


namespace App\Http\Controllers;


use GuzzleHttp\Client;

class PayuController extends Controller
{

    public function getPaymentMethods()
    {

        $apiKey = "bnvg2pvyuCDiX1G4kvFpWT8uDc"; //Ingrese aquí su propio apiKey.
        $merchantId = "1"; //Ingrese aquí su Id de Comercio.
        true; //Dejarlo True cuando sean pruebas.
        $paymentUrl = "https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi/";
        $client = new \GuzzleHttp\Client(
            array(

                \GuzzleHttp\RequestOptions::VERIFY => false,


            )
        );
        // $client->setDefaultOption('verify', false);
        $data_request = array(
            'verify' => false,
            "test" => 1,
            "language" => "en",
            "command" => "GET_PAYMENT_METHODS",
            "merchant" => array(
                "apiLogin" => "pRRXKOl8ikMmt9u",
                "apiKey" => "4Vj8eK4rloUd272L48hsrarnUA"
            )
        );

        try {
            $response = $client->request('POST', $paymentUrl, $data_request);
            echo $response->getStatusCode();

        } catch (RequestException $e) {
            echo $e->getRequest() . "\n";
            if ($e->hasResponse()) {
                echo $e->getResponse() . "\n";
            }
        }

        /* foreach ($payment_methods as $payment_method) {
             $payment_method->country;
             $payment_method->description;
             $payment_method->id;
         }*/


        return response()->json([
            [
                'isSuccess' => true,
                //  'count' => $data->count(),
                'status' => 200,
                'objects' => $response->getBody()
            ]
        ]);
    }
}