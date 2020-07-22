<?php
require "vendor/autoload.php"; 
use PagamentiOnline\Classes\PagamentoService;

try {
$pagamento = new PagamentoService([]/*, 'https://testeps.netswgroup.it/UNI_CG_SERVICES/services/PaymentTranGatewayPort?wsdl'*/);

    /*
    * Example paymentUrl request data pagOnline
    */
    
    /*$params = [
        'trType' => 'PURCHASE',
        'floatAmount' => 1.00,
        'languageCode' => 'IT',
        'notifyUrl' => 'http://2.233.131.39/Pagamenti/index.php',
        'errorUrl' => 'http://2.233.131.39/Pagamenti/index.php',
        'currencyCode' => 'EUR',
        'shopId' => '411111115455555',
        'ShopUserName' => 'John Doe',
        'ShopUserAccount' => 'john@doe.com'
    ];
    $reponse = $pagamento->getPaymentUrl($params);
    var_dump($reponse);*/

    /*
    * Example checkPaymentResult request data pagOnline
    */
    /*$data = $pagamento->checkPaymentResult(['shopId' => '411111115455555','paymentId' => '00203574029102262186']);
    var_dump($data);*/

    /*
    * Example credit data pagOnline
    */
    
    /*$params = [
        'amount' => 1.00,
        'shopId' => '411111115455555',
        'refTranID' => '3056476690463954'
    ];
    $reponse = $pagamento->credit($params);
    var_dump($reponse);*/


    /*
    * Example paymentUrl request data gestPay
    */
    $params = [
		'currency' => 242,
		'amount' => 1.00,
		'transactionID' => '56',
		'buyerName' => 'John Doe',
		'buyerEmail' => 'john@doe.com',
        'customInfo'=>'BV_CODCLIENTE=P*P1*PAY1_RISK_RESPONSE_DESCRIPTION=PROVA',
    ];

    $reponse = $pagamento->getPaymentUrl($params);
    var_dump($reponse);

    /*
    * Example checkPaymentResult request data gestPay
    */
    //$data = $pagamento->checkPaymentResult();


    //file_put_contents(date('s').'filename.txt', print_r($data, true));

} catch (\Throwable $th) {
    print_r($th);
}