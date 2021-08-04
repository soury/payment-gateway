<?php

namespace PagamentiOnline\PagOnline;

use Psr\Log\LoggerInterface;

use Psr\Log\LogLevel;
use PagamentiOnline\PagOnline\PaymentInit\Request as InitRequest;
use PagamentiOnline\PagOnline\PaymentInit\Response as InitResponse;

use PagamentiOnline\PagOnline\PaymentVerify\Request as VerifyRequest;
use PagamentiOnline\PagOnline\PaymentVerify\Response as VerifyResponse;

use PagamentiOnline\PagOnline\PaymentCredit\Request as CreditRequest;
use PagamentiOnline\PagOnline\PaymentCredit\Response as CreditResponse;

use PagamentiOnline\PagOnline\SoapClient\WrapperInterface;

use PagamentiOnline\PagOnline\Lists\Currency;
use PagamentiOnline\PagOnline\Lists\Language;
use PagamentiOnline\PagOnline\Lists\Operation;

use PagamentiOnline\Classes\Pagamento;

/**
 * Class Client
 * @package PagamentiOnline\PagOnline
 */
class Client extends Pagamento
{
    use Logging;

    /**
     * @deprecated Use the constants in the PagamentiOnline\PagOnline\Lists\Operation class instead
     */
    const TRANSACTION_TYPE_AUTH = Operation::TRANSACTION_TYPE_AUTH;

    /**
     * @deprecated Use the constants in the PagamentiOnline\PagOnline\Lists\Operation class instead
     */
    const TRANSACTION_TYPE_PURCHASE = Operation::TRANSACTION_TYPE_PURCHASE;

    /**
     * @deprecated Use the constants in the PagamentiOnline\PagOnline\Lists\Currency class instead
     */
    const CURRENCY_CODE_EUR = Currency::CURRENCY_CODE_EUR;

    /**
     * @deprecated Use the constants in the PagamentiOnline\PagOnline\Lists\Currency class instead
     */
    const CURRENCY_CODE_USD = Currency::CURRENCY_CODE_USD;

    /**
     * @deprecated Use the constants in the PagamentiOnline\PagOnline\Lists\Language class instead
     */
    const LANGUAGE_ITA = Language::LANGUAGE_ITA;

    /**
     * @deprecated Use the constants in the PagamentiOnline\PagOnline\Lists\Language class instead
     */
    const LANGUAGE_ENG = Language::LANGUAGE_ENG;

    const TRANSACTION_IN_PROGRESS_RETURN_CODE = 'IGFS_814';

    /**
     * @var string
     */
    protected $kSig;

    /**
     * @var string
     */
    protected $tId;

    /**
     * @var WrapperInterface
     */
    protected $soapClientWrapper;

    /**
     * Client constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->soapClientWrapper = new SoapClient\Wrapper();
    }

    /**
     * @param WrapperInterface $wrapper
     */
    public function setSoapClientWrapper(WrapperInterface $wrapper)
    {
        $this->soapClientWrapper = $wrapper;
    }

    /**
     * @return mixed
     */
    public function getKSig()
    {
        return $this->kSig;
    }

    /**
     * @param mixed $kSig
     */
    public function setKSig($kSig)
    {
        $this->kSig = $kSig;
    }

    /**
     * @return mixed
     */
    public function getTid()
    {
        return $this->tId;
    }
    
    /**
     * @param mixed $tId
     */
    public function setTid($tId)
    {
        $this->tId = $tId;
    }

    /**
     * @param $isTestMode boolean
     * @param $kSig string Secret signature key
     * @param $tid string Terminal ID
     * @param $wsdl string WSDL URL
     */
    public function init($isTestMode, $kSig, $tid, $wsdl)
    {
        if (!$kSig) {
            throw new \InvalidArgumentException('Missing signature key');
        }

        if (!$tid) {
            throw new \InvalidArgumentException('Missing terminal id');
        }

        if (!$wsdl) {
            throw new \InvalidArgumentException('Missing WSDL URL');
        }

        if (defined('VAR_NAME')) {
            // Something
        }
        $this->kSig = $kSig;
        $this->tId = $tid;
        $soapOptions = array(
            'compression' => defined('SOAP_COMPRESSION_ACCEPT') ? SOAP_COMPRESSION_ACCEPT : 32,
            'soap_version' => defined('SOAP_1_1') ? SOAP_1_1 : 1,
            'trace' => true,
        );
        if (!extension_loaded('soap')) {
            $this->log(
                'Unable to create the webserver client.'.PHP_EOL.
                'The PHP_SOAP extension is required to use this library.',
                LogLevel::CRITICAL
            );
            throw new \RuntimeException('PHP SOAP extension is required.');
        }

        if ($isTestMode) {
            //Allow self-signed certificates in test mode
            $contextOptions = array(
                'ssl' => array(
                    'allow_self_signed' => true,
                )
            );
            $sslContext = stream_context_create($contextOptions);
            $soapOptions['stream_context'] = $sslContext;
        }

        $this->soapClientWrapper->initialize($wsdl, $soapOptions);
    }



    public function createPayment($params=array())
    {
        $trType;
        $floatAmount;
        $languageCode;
        $notifyUrl;
        $errorUrl;
        $currencyCode = Currency::CURRENCY_CODE_EUR;
        $shopId = null;
        $shopUserRef = null;
        $shopUserName = null;
        $description = null;
        $shopUserAccount = null;
        $addInfo1 = null;
        $addInfo2 = null;
        $addInfo3 = null;
        $addInfo4 = null;
        $addInfo5 = null;
        $freeText = null;
        $paymentReason = null;
        $validityExpire = null;

        if(isset($params['trType'])) $trType = $params['trType'];
        if(isset($params['floatAmount'])) $floatAmount = $params['floatAmount'];
        if(isset($params['languageCode'])) $languageCode = $params['languageCode'];
        if(isset($params['notifyUrl'])) $notifyUrl = $params['notifyUrl'];
        if(isset($params['errorUrl'])) $errorUrl = $params['errorUrl'];
        if(isset($params['currencyCode'])) $currencyCode = $params['currencyCode'];
        if(isset($params['shopId'])) $shopId = $params['shopId'];
        if(isset($params['shopUserRef'])) $shopUserRef = $params['shopUserRef'];
        if(isset($params['shopUserName'])) $shopUserName = $params['shopUserName'];
        if(isset($params['description'])) $description = $params['description'];
        if(isset($params['shopUserAccount'])) $shopUserAccount = $params['shopUserAccount'];
        if(isset($params['addInfo1'])) $addInfo1 = $params['addInfo1'];
        if(isset($params['addInfo2'])) $addInfo2 = $params['addInfo2'];
        if(isset($params['addInfo3'])) $addInfo3 = $params['addInfo3'];
        if(isset($params['addInfo4'])) $addInfo4 = $params['addInfo4'];
        if(isset($params['addInfo5'])) $addInfo5 = $params['addInfo5'];
        if(isset($params['freeText'])) $freeText = $params['freeText'];
        if(isset($params['paymentReason'])) $paymentReason = $params['paymentReason'];
        if(isset($params['validityExpire'])) $validityExpire = $params['validityExpire'];

        $response = $this->paymentInit($trType,$floatAmount,$languageCode,$notifyUrl,$errorUrl,$currencyCode,$shopId,$shopUserRef,$shopUserName,$description,$shopUserAccount,$addInfo1,$addInfo2,$addInfo3,$addInfo4,$addInfo5,$freeText,$paymentReason,$validityExpire);

        return [
            'paymentId' => $response->getPaymentId(),
            'tranId' => $response->getShopId(),
            'redirectUrl' => $response->getRedirectUrl(),
            'errorDesc' => $response->getErrorDesc()
        ];
    }


    /**
     * @see https://pagamenti.unicredit.it/UNI_CG_SERVICES/services/PaymentInitGatewayPort?xsd=dto/init/PaymentInit.xsd
     *
     * @param $trType string @see PagamentiOnline\PagOnline\Lists\Operation for a list of allowed values
     * @param $floatAmount float Payment amount. Must be a value with no more than 2 decimal places
     * @param $languageCode string @see PagamentiOnline\PagOnline\Lists\Language for a list of allowed values
     * @param $notifyUrl
     * @param $errorUrl
     * @param $currencyCode string @see PagamentiOnline\PagOnline\Lists\Currency for a list of allowed values
     * @param $shopId
     * @param $shopUserRef
     * @param $shopUserName
     * @param $description
     * @param $shopUserAccount
     * @param $addInfo1
     * @param $addInfo2
     * @param $addInfo3
     * @param $addInfo4
     * @param $addInfo5
     * @param $freeText
     * @param $paymentReason
     * @param $validityExpire
     *
     * @return InitResponse
     * @throws \Exception
     */
    public function paymentInit(
        $trType,
        $floatAmount,
        $languageCode,
        $notifyUrl,
        $errorUrl,
        $currencyCode = Currency::CURRENCY_CODE_EUR,
        $shopId = null,
        $shopUserRef = null,
        $shopUserName = null,
        $description = null,
        $shopUserAccount = null,
        $addInfo1 = null,
        $addInfo2 = null,
        $addInfo3 = null,
        $addInfo4 = null,
        $addInfo5 = null,
        $freeText = null,
        $paymentReason = null,
        $validityExpire = null
    ) {
        if (!$this->isInitialized()) {
            throw new \LogicException('Please initialize the client before trying to perform paymentInit operations');
        }

        if (empty($trType) || empty($floatAmount) || empty($languageCode) || empty($currencyCode) ||
            empty($notifyUrl) || empty($errorUrl)) {
            throw new \InvalidArgumentException("Cannot invoke webservice, some mandatory field is missing");
        }

        $trType = strtoupper($trType);
        $operations = new Operation();
        if (!array_key_exists($trType, $operations->getList())) {
            throw new \InvalidArgumentException(sprintf('Unsupported operation specified %s.', $trType));
        }

        $languageCode = strtoupper($languageCode);
        $languagesList = new Language();
        if (!array_key_exists($languageCode, $languagesList->getList())) {
            throw new \InvalidArgumentException(sprintf('Unsupported language specified %s.', $languageCode));
        }
        
        $currencyCode = strtoupper($currencyCode);
        $currencyList = new Currency();
        if (!array_key_exists($currencyCode, $currencyList->getList())) {
            throw new \InvalidArgumentException(sprintf('Unsupported currency specified %s.', $currencyCode));
        }

        if ($shopId) {
            if (strlen($shopId) > 35) {
                throw new \InvalidArgumentException('Shop Id is too long (max 35 chars)');
            }

            if (!preg_match("#^[a-zA-Z0-9/\-\?\:\(\)\.,'\+ ]*$#", $shopId)) {
                throw new \InvalidArgumentException('Shop Id can only contain chars a-z A-Z 0-9 /-?:().,\'+<space>');
            }
        }

        //@todo more validation

        try {
            $request = new InitRequest();

            $request->setShopId($shopId);
            $request->setShopUserRef($shopUserRef);
            $request->setShopUserName($shopUserName);
            $request->setShopUserAccount($shopUserAccount);
            $request->setTrType($trType);
            $request->setAmount($floatAmount);  //<-- The setter performs the validation and the conversion
            $request->setCurrencyCode($currencyCode);
            $request->setLangId($languageCode);
            $request->setNotifyUrl($notifyUrl);
            $request->setErrorUrl($errorUrl);
            $request->setAddInfo1($addInfo1);
            $request->setAddInfo2($addInfo2);
            $request->setAddInfo3($addInfo3);
            $request->setAddInfo4($addInfo4);
            $request->setAddInfo5($addInfo5);
            $request->setDescription($description);
            $request->setPaymentReason($paymentReason);
            $request->setFreeText($freeText);
            $request->setValidityExpire($validityExpire);
            $request->setTid($this->tId);
        } catch (\Exception $ex) {
            $this->log('An error occurred while initializing the Init request: '.$ex->getMessage(), LogLevel::CRITICAL);
            throw $ex;
        }

        $this->sign($request);

        try {
            $rawSoapResponseObject = $this->soapClientWrapper->init(array('request' => ($request->toArray())));
        } finally {
            //The "finally" statement is used to ensure that something is logged even if an error occurred
            $this->log('Raw request: ' . $this->soapClientWrapper->getLastRequest());
            $this->log('Raw response: ' . $this->soapClientWrapper->getLastResponse());
        }

        if (isset($rawSoapResponseObject->response->error) && !empty($rawSoapResponseObject->response->error)) {
            $this->log('Failure response received: ' . print_r($rawSoapResponseObject, true));
        } else {
            $this->log('Succesful response received: ' . print_r($rawSoapResponseObject, true));
        }

        return new InitResponse($rawSoapResponseObject);
    }

    /**
     * @param $params
     *
     * @return VerifyResponse
     * @throws \Exception
     */
    public function paymentStatus($params=array())
    {
        $shopId;
        $paymentId;
        if(isset($params['shopId'])) $shopId = $params['shopId'];
        if(isset($params['paymentId'])) $paymentId = $params['paymentId'];
        $response = $this->paymentVerify($shopId, $paymentId);
        $result = [
            'tranId' => $response->getShopId(),
            'bankId' => $response->getTranId(),
            'errorCode' => $response->getError(),
            'errorDesc' => $response->getErrorDesc(),
            'tranResult' => $response->getStatus(),
            'authorizationCode' => $response->getAuthCode(),
            'currency' => '',
            'amount' => null,
            'country' => '',
            'buyerName' => '',
            'buyerEmail' => '',
            'customInfo' => []
        ];
        return $result;
    }

    /**
     * @param $shopId
     * @param $paymentId
     *
     * @return VerifyResponse
     * @throws \Exception
     */
    public function paymentVerify($shopId, $paymentId)
    {
        if (!$this->isInitialized()) {
            throw new \LogicException('Please initialize the client before trying to perform verify operations');
        }

        if (empty($shopId) || empty($paymentId)) {
            throw new \InvalidArgumentException("Cannot invoke webservice, some mandatory field is missing");
        }

        $request = new VerifyRequest();
        $request->setTid($this->tId);
        $request->setShopId($shopId);
        $request->setPaymentId($paymentId);

        $this->sign($request);

        $request = array('request' => ($request->toArray()));
        $this->log('Verify request: ' . print_r($request, true));

        try {
            $rawSoapResponseObject = $this->soapClientWrapper->verify($request);
        } finally {
            //The "finally" statement is used to ensure that something is logged even if an error occurred
            $this->log('Raw request: '.$this->soapClientWrapper->getLastRequest());
            $this->log('Raw response: '.$this->soapClientWrapper->getLastResponse());
        }

        if (isset($rawSoapResponseObject->response->error) && !empty($rawSoapResponseObject->response->error)) {
            $this->log('Failure response received: ' . print_r($rawSoapResponseObject, true));
        } else {
            $this->log('Succesful response received: ' . print_r($rawSoapResponseObject, true));
        }

        return new VerifyResponse($rawSoapResponseObject);
    }

    public function setCredit($params=array())
    {
        $shopId;
        $amount;
        $refTranID;
        $splitTran=null;
        $addInfo1=null;
        $addInfo2=null;
        $addInfo3=null;
        $addInfo4=null;
        $addInfo5=null;
        if(isset($params['shopId'])) $shopId = $params['shopId'];
        if(isset($params['amount'])) $amount = $params['amount'];
        if(isset($params['refTranID'])) $refTranID = $params['refTranID'];
        if(isset($params['splitTran'])) $splitTran = $params['splitTran'];
        if(isset($params['addInfo1'])) $addInfo1 = $params['addInfo1'];
        if(isset($params['addInfo2'])) $addInfo2 = $params['addInfo2'];
        if(isset($params['addInfo3'])) $addInfo3 = $params['addInfo3'];
        if(isset($params['addInfo4'])) $addInfo4 = $params['addInfo4'];
        if(isset($params['addInfo5'])) $addInfo5 = $params['addInfo5'];

        $response = $this->paymentCredit($shopId,$amount,$refTranID,$splitTran,$addInfo1,$addInfo2,$addInfo3,$addInfo4,$addInfo5);

        $result = [
            'tranId' => $response->getShopId(),
            'bankId' => $response->getTranId(),
            'errorCode' => $response->getError(),
            'errorDesc' => $response->getErrorDesc(),
            'tranResult' => $response->getStatus(),
            'authorizationCode' => $response->getAuthCode(),
            'currency' => '',
            'amount' => null,
            'country' => '',
            'buyerName' => '',
            'buyerEmail' => '',
            'customInfo' => []
        ];
        return $result;
    }


    public function paymentCredit($shopId,$amount,$refTranID,$splitTran=null,$addInfo1=null,$addInfo2=null,$addInfo3=null,$addInfo4=null,$addInfo5=null){
        if (!$this->isInitialized()) {
            throw new \LogicException('Please initialize the client before trying to perform paymentInit operations');
        }

        if ($shopId) {
            if (strlen($shopId) > 35) {
                throw new \InvalidArgumentException('Shop Id is too long (max 35 chars)');
            }

            if (!preg_match("#^[a-zA-Z0-9/\-\?\:\(\)\.,'\+ ]*$#", $shopId)) {
                throw new \InvalidArgumentException('Shop Id can only contain chars a-z A-Z 0-9 /-?:().,\'+<space>');
            }
        }

        //@todo more validation

        try {
            $request = new CreditRequest();

            $request->setShopId($shopId);
            $request->setAmount($amount);  //<-- The setter performs the validation and the conversion
            $request->setRefTranID($refTranID);
            $request->setSplitTran($splitTran);
            $request->setAddInfo1($addInfo1);
            $request->setAddInfo2($addInfo2);
            $request->setAddInfo3($addInfo3);
            $request->setAddInfo4($addInfo4);
            $request->setAddInfo5($addInfo5);
            $request->setTid($this->tId);
        } catch (\Exception $ex) {
            $this->log('An error occurred while initializing the Init request: '.$ex->getMessage(), LogLevel::CRITICAL);
            throw $ex;
        }

        $this->sign($request);

        try {
            $rawSoapResponseObject = $this->soapClientWrapper->credit(array('request' => ($request->toArray())));
        } finally {
            //The "finally" statement is used to ensure that something is logged even if an error occurred
            $this->log('Raw request: ' . $this->soapClientWrapper->getLastRequest());
            $this->log('Raw response: ' . $this->soapClientWrapper->getLastResponse());
        }

        if (isset($rawSoapResponseObject->response->error) && !empty($rawSoapResponseObject->response->error)) {
            $this->log('Failure response received: ' . print_r($rawSoapResponseObject, true));
        } else {
            $this->log('Succesful response received: ' . print_r($rawSoapResponseObject, true));
        }

        return new CreditResponse($rawSoapResponseObject);
    }


    /**
     * @return bool
     */
    protected function isInitialized()
    {
        return isset($this->tId) && isset($this->kSig) && $this->soapClientWrapper->isInitialized();
    }

    /**
     * @deprecated Use isInitialized instead
     *
     * @return bool
     */
    protected function canExecute()
    {
        return $this->isInitialized();
    }

    /**
     * @param $request
     */
    protected function sign(SignableInterface $request)
    {
        $signatureCalculator = new SignatureCalculator($this->logger);
        $signatureCalculator->sign($request, $this->kSig);
    }
}
