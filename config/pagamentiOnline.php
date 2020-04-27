<?php

return [
    'test'		=> true,

    /*
    * classe: module to use for payments (gestPay/pagOnline)
    */
    'classe'=> 'gestPay',

    /*
    * Parameters needed for the module gestPay
    */
    'shopLogin'	=> 'GESPAY68515',
    'uicCode' 	=> '242',
    'useSSL' => true,

    /*
    * Parameters needed for the module pagOnline
    */
    'kSig'	=> 'UNI_TESTKEY',
    'tid'	=> 'UNI_SEL',
    'wsdl'	=> 'https://testeps.netswgroup.it/UNI_CG_SERVICES/services/PaymentInitGatewayPort?wsdl',
    'notifyUrl' => 'http://2.233.131.39/Pagamenti/index.php',
    'errorUrl' => 'http://2.233.131.39/Pagamenti/index.php',
];