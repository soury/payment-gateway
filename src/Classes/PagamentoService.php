<?php
namespace PagamentiOnline\Classes;
use PagamentiOnline\Classes\Pagamento;
use Psr\Log\Test\TestLogger;
use PagamentiOnline\PagOnline\Client;
use PagamentiOnline\GestPay\GestPay;

class PagamentoService 
{
    public $pagamento;
    private $notifyUrl;
    private $errorUrl;

    public function __construct($configs = array()) 
    {
        if(!count($configs)) $configs = include('config/pagamentiOnline.php');

        $this->pagamento = new Pagamento();

        switch($configs['classe']) {
            case 'pagOnline':
                $this->pagamento = new Client(new TestLogger());
                $this->pagamento->init($configs['test'], $configs['kSig'], $configs['tid'], $configs['wsdl']);
                $this->notifyUrl = $configs['notifyUrl'];
                $this->errorUrl = $configs['errorUrl'];
                break;
            case 'gestPay':
                $this->pagamento = new GestPay($configs['shopLogin'], $configs['useSSL'], $configs['test']);
                break;
        }
	}

    public function getPaymentUrl($params)
    {
        if($this->notifyUrl) $params['notifyUrl'] = $this->notifyUrl.'?shopId='.$params['shopId'];
        if($this->errorUrl) $params['errorUrl'] = $this->errorUrl.'?shopId='.$params['shopId'];
        return $this->pagamento->createPayment($params);
    }

    public function checkPaymentResult($params=array())
    {
        return $this->pagamento->paymentStatus($params);
    }
}