<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use PrintuCo\LaravelPayU\LaravelPayU;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\Wallet as WalletResource;
use App\Wallet;

class PayuController extends Controller
{

    private $banks = array();

    public function getPaymentMethods()
    {
        LaravelPayU::setPayUEnvironment();

        $array = \PayUPayments::getPaymentMethods('es');
        return response()->json([
            [
                'isSuccess' => true,
                //  'count' => $data->count(),
                'status' => 200,
                'objects' => $array
            ]
        ]);
    }

    public function getPseBanks()
    {

        LaravelPayU::getPSEBanks(function ($response) {
            //... Usar datos de bancos

            $this->banks = $response;

        }, function ($error) {

        });

        return response()->json([
            [
                'isSuccess' => true,
                //  'count' => $data->count(),
                'status' => 200,
                'objects' => $this->banks
            ]
        ]);
    }

    public function sendPayment(Request $request)
    {
        $user = $this->getAuthenticatedUser();
        LaravelPayU::setPayUEnvironment();
        LaravelPayU::setAccountOnTesting(true);

        $data = $request->data;
        $reference = "DROPI_PAYMENT_" . date('Ymdhis_a');
        $transaction = $data['transaction'];
        $oder = $data['transaction']['order'];
        $payer = $data['transaction']['payer'];
        $buyer = $oder['buyer'];
        $value = $oder['amount'];

        //echo \Environment::getPaymentsUrl();
        $parameters = array(
            //Ingrese aquí el identificador de la cuenta.
            \PayUParameters::ACCOUNT_ID =>LaravelPayU::getAccountId(),

            //Ingrese aquí el código de referencia.
            \PayUParameters::REFERENCE_CODE => $reference,
            //Ingrese aquí la descripción.
            \PayUParameters::DESCRIPTION => $oder['description'],

            // -- Valores --
            //Ingrese aquí el valor de la transacción.
            \PayUParameters::VALUE => $value,
            //Ingrese aquí el valor del IVA (Impuesto al Valor Agregado solo valido para Colombia) de la transacción,
            //si se envía el IVA nulo el sistema aplicará el 19% automáticamente. Puede contener dos dígitos decimales.
            //Ej: 19000.00. En caso de no tener IVA debe enviarse en 0.
            \PayUParameters::TAX_VALUE => 0,
            //Ingrese aquí el valor base sobre el cual se calcula el IVA (solo valido para Colombia).
            //En caso de que no tenga IVA debe enviarse en 0.
            \PayUParameters::TAX_RETURN_BASE => 0,
            //Ingrese aquí la moneda.
            \PayUParameters::CURRENCY => "COP",

            // -- Comprador
            //Ingrese aquí el nombre del comprador.
            \PayUParameters::BUYER_NAME => $buyer['fullName'],
            //Ingrese aquí el email del comprador.
            \PayUParameters::BUYER_EMAIL => $buyer['emailAddress'],
            //Ingrese aquí el teléfono de contacto del comprador.
            \PayUParameters::BUYER_CONTACT_PHONE => $buyer['contactPhone'],
            //Ingrese aquí el documento de contacto del comprador.
            \PayUParameters::BUYER_DNI => $buyer['dniNumber'],
            //Ingrese aquí la dirección del comprador.
            \PayUParameters::BUYER_STREET => $buyer['shippingAddress']['street1'],
            \PayUParameters::BUYER_STREET_2 => $buyer['shippingAddress']['street2'],
            \PayUParameters::BUYER_CITY => $buyer['shippingAddress']['city'],
            \PayUParameters::BUYER_STATE => $buyer['shippingAddress']['state'],
            \PayUParameters::BUYER_COUNTRY => $buyer['shippingAddress']['country'],
            \PayUParameters::BUYER_POSTAL_CODE => $buyer['shippingAddress']['postalCode'],
            \PayUParameters::BUYER_PHONE => $buyer['shippingAddress']['phone'],

            // -- pagador --
            //Ingrese aquí el nombre del pagador.
            \PayUParameters::PAYER_NAME => $payer['fullName'],
            //Ingrese aquí el email del pagador.
            \PayUParameters::PAYER_EMAIL => $payer['emailAddress'],
            //Ingrese aquí el teléfono de contacto del pagador.
            \PayUParameters::PAYER_CONTACT_PHONE => $payer['contactPhone'],
            //Ingrese aquí el documento de contacto del pagador.
            //Ingrese aquí el documento de contacto del pagador.
            \PayUParameters::PAYER_DNI => $payer['dniNumber'],

            //Ingrese aquí la dirección del pagador.
            \PayUParameters::PAYER_STREET => $payer['billingAddress']['street1'],
            \PayUParameters::PAYER_STREET_2 => $payer['billingAddress']['street2'],
            \PayUParameters::PAYER_CITY => $payer['billingAddress']['city'],
            \PayUParameters::PAYER_STATE => $payer['billingAddress']['state'],
            \PayUParameters::PAYER_COUNTRY => $payer['billingAddress']['country'],
            \PayUParameters::PAYER_POSTAL_CODE => $payer['billingAddress']['postalCode'],
            \PayUParameters::PAYER_PHONE => $payer['billingAddress']['phone'],


            //Ingrese aquí el nombre de la tarjeta de crédito
            //VISA||MASTERCARD||AMEX||DINERS
            \PayUParameters::PAYMENT_METHOD => $transaction['paymentMethod'],

            //Ingrese aquí el número de cuotas.
            \PayUParameters::INSTALLMENTS_NUMBER => "1",
            //Ingrese aquí el nombre del pais.
            \PayUParameters::COUNTRY => \PayUCountries::CO,

            //Session id del device.
            \PayUParameters::DEVICE_SESSION_ID => "vghs6tvkcle931686k1900o6e1",
            //IP del pagadador
            \PayUParameters::IP_ADDRESS => $transaction['ipAddress'],
            //Cookie de la sesión actual.
            \PayUParameters::PAYER_COOKIE => $transaction['cookie'],
            //Cookie de la sesión actual.
            \PayUParameters::USER_AGENT => $transaction['userAgent'],
        );
        $parameters[\PayUParameters::NOTIFY_URL] = url('')."api/payu/notify_url";

        if ($transaction['paymentMethod'] != 'PSE') {
            // -- Datos de la tarjeta de crédito --

            $credit_card = $transaction['creditCard'];
            //Ingrese aquí el número de la tarjeta de crédito
            $parameters[\PayUParameters::CREDIT_CARD_NUMBER] = $credit_card['number'];
            //Ingrese aquí la fecha de vencimiento de la tarjeta de crédito
            $parameters[\PayUParameters::CREDIT_CARD_EXPIRATION_DATE] = $credit_card['expirationDate'];
            //Ingrese aquí el código de seguridad de la tarjeta de crédito
            $parameters[\PayUParameters::CREDIT_CARD_SECURITY_CODE] = $credit_card['securityCode'];


            $response = \PayUPayments::doAuthorizationAndCapture($parameters, 'es');

            if($response){
                $response->transactionResponse->orderId;
                $response->transactionResponse->transactionId;
                $response->transactionResponse->state;
                if($response->transactionResponse->state)
                if($response->transactionResponse->state=="PENDING"){
                    $response->transactionResponse->pendingReason;
                    $response->transactionResponse->extraParameters->BANK_URL;
                }
                $response->transactionResponse->responseCode;

                if ($response->transactionResponse->state == "APPROVED") {

                    $cartera=  Wallet::firstOrNew(['user_id' => $user->id]);
                    var_dump($cartera->id);

                    if($cartera->id){
                        $cartera->amount=$cartera->amount+$oder['amount'];

                    }else{
                        $cartera->user_id=$user->id;
                        $cartera->amount=$oder['amount'];
                    }
                    $cartera->save();
                }
            }


        } else {

            $pse = $transaction['extraParameters'];
            // -- infarmación obligatoria para PSE --
            //Ingrese aquí el código pse del banco.
            $parameters[\PayUParameters::PSE_FINANCIAL_INSTITUTION_CODE] = $pse['FINANCIAL_INSTITUTION_CODE'];
            //Ingrese aquí el tipo de persona (N natural o J jurídica)
            $parameters[\PayUParameters::PAYER_PERSON_TYPE] = $pse['USER_TYPE'];

            //Ingrese aquí el tipo de documento del pagador: CC, CE, NIT, TI, PP,IDC, CEL, RC, DE.
            $parameters[\PayUParameters::PAYER_DOCUMENT_TYPE] = $pse['PAYER_DOCUMENT_TYPE'];

            //Página de respuesta a la cual será redirigido el pagador.
            $parameters[\PayUParameters::RESPONSE_URL] = $pse['RESPONSE_URL'];


            $response = \PayUPayments::doAuthorizationAndCapture($parameters, 'es');

            if($response){
                $response->transactionResponse->orderId;
                $response->transactionResponse->transactionId;
                $response->transactionResponse->state;
                if($response->transactionResponse->state=="PENDING"){
                    $response->transactionResponse->pendingReason;
                    $response->transactionResponse->trazabilityCode;
                    $response->transactionResponse->authorizationCode;
                    $response->transactionResponse->extraParameters->URL_PAYMENT_RECEIPT_HTML;
                    $response->transactionResponse->extraParameters->REFERENCE;
                    $response->transactionResponse->extraParameters->BAR_CODE;
                }
                $response->transactionResponse->responseCode;

                if ($response->transactionResponse->state == "APPROVED") {

                  $cartera=  Wallet::firstOrNew(['user_id' => $user->id]);
                  var_dump($cartera);

                  if($cartera->id){
                      $cartera->amount=$cartera->amount+$oder['amount'];

                  }else{
                      $cartera->user_id=$user->id;
                      $cartera->amount=$oder['amount'];
                  }
                    $cartera->save();
                }
            }

        }

        return response()->json([
            [
                'isSuccess' => true,
                //  'count' => $data->count(),
                'status' => 200,
                'objects' => $response
            ]
        ]);
    }

    public function notifyurl(Request $request){
        $json = json_encode($request);
        DB::table('responseprueba')->insert(
            ['responseprueba' => $json]
        );
    }

    public function getresponseprueba(Request $request)
    {
        $query = DB::table('responseprueba')
            ->get();

        return response()->json([
            [
                'isSuccess' => true,
                //  'count' => $data->count(),
                'status' => 200,
                'objects' => $query
            ]
        ]);
    }

    private function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired']);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid']);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent']);
        }
        return $user;
    }
}
