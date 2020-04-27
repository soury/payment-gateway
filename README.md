Payments online PHP library
==========================================


This library provides an integration with the WebServices of some payment gateway (Unicredit PagOnline Imprese / GestPay (Banca Sella)).
It was developed by following the technical documentation v.07 of 07/02/2017 provided by Unicredit.

Installation
------------

In order to use this library you have to import it through composer:

```
composer require sourazou/pagamenti-online
```

Usage
-----

configure the payment form you want to use in the config / paymentsOnline.php file 
```
return [
    'test'		=> true,

    /*
    * classe: module to use for payments (gestPay/pagOnline)
    */
    'classe'=> 'pagOnline',

    /*
    * Parameters needed for the module gestPay
    */
    'shopLogin'	=> '',
    'uicCode' 	=> '242',
    'useSSL' => true,

    /*
    * Parameters needed for the module pagOnline
    */
    'kSig'	=> '',
    'tid'	=> '',
    'wsdl'	=> '',
];
```

In the index.php file you will find payment and response examples.

you will also find the readme of the various modules for further information.

Contributing
------------

Fork this repository, make your changes and submit a pull request.
Please run the tests and the coding standards checks before submitting a pull request.

License
-------

This library is under the MIT license. See the complete license in the LICENSE file.

