<?php

namespace PagamentiOnline\PagOnline\PaymentVerify;

use PagamentiOnline\PagOnline\SignableInterface;

class Request implements SignableInterface
{
    /**
     * @var string
     */
    protected $tid;
    /**
     * @var string
     */
    protected $shopId;
    /**
     * @var string
     */
    protected $paymentId;
    /**
     * @var string
     */
    protected $signature;

    /**
     * @return mixed
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
     * @param mixed $tid
     */
    public function setTid($tid)
    {
        $this->tid = $tid;
    }

    /**
     * @return mixed
     */
    public function getShopId()
    {
        return $this->shopId;
    }


    /**
     * @param string $signature
     * @return void
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
    }

    /**
     * @param mixed $shopId
     */
    public function setShopId($shopId)
    {
        $this->shopId = $shopId;
    }

    /**
     * @return mixed
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * @param mixed $paymentId
     */
    public function setPaymentId($paymentId)
    {
        $this->paymentId = $paymentId;
    }

    /**
     * @return string
     */
    public function getSignatureData()
    {
        return $this->tid . $this->shopId . $this->paymentId;
    }
    
    /**
     * @return array
     */
    public function toArray()
    {
        //Even though the documentation mentions an initial uppercase letter in the field names, these seem to work
        //with a lowercase first letter...
        return array(
            'signature' => $this->signature,
            'tid'       => $this->tid,
            'shopID'    => $this->shopId,
            'paymentID' => $this->paymentId
        );
    }
}
