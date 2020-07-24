<?php

namespace PagamentiOnline\PagOnline\PaymentCredit;

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
     * @var integer
     */
    protected $amount;
     /**
     * @var string
     */
    protected $refTranID;
    /**
     * @var string
     */
    protected $splitTran;
    /**
     * @var string
     */
    protected $addInfo1;

    /**
     * @var string
     */
    protected $addInfo2;

    /**
     * @var string
     */
    protected $addInfo3;

    /**
     * @var string
     */
    protected $addInfo4;

    /**
     * @var string
     */
    protected $addInfo5;
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
     * @return float
     */
    public function getAmount()
    {
        return $this->amount / 100;
    }

    /**
     * Convert to "number of cents" representation. Beware of possible rounding errors.
     *
     * @param float $amount
     */
    public function setAmount($amount)
    {
        //@todo: Maybe this should become a "dumb" setter and this code should be in the client?
        $centsAmount = $amount * 100;
        $newAmount = round($centsAmount);
        //Make sure that the supplied amount contains no more than 2 decimal places
        if (abs($newAmount - $centsAmount) > 0.0000000001) {
            throw new \RuntimeException(
                sprintf(
                    'Unicredit PagOnline Imprese only accepts amounts with up to 2 decimal places. %s given',
                    $amount
                )
            );
        }
        $this->amount = $newAmount;
    }

    /**
     * @return string
     */
    public function getRefTranID()
    {
        return $this->refTranID;
    }

    /**
     * @param string $refTranID
     */
    public function setRefTranID($refTranID)
    {
        $this->refTranID = $refTranID;
    }

    /**
     * @return string
     */
    public function getSplitTran()
    {
        return $this->splitTran;
    }

    /**
     * @param string $splitTran
     */
    public function setSplitTran($splitTran)
    {
        $this->splitTran = $splitTran;
    }

    /**
     * @return string
     */
    public function getAddInfo1()
    {
        return $this->addInfo1;
    }

    /**
     * @param string $addInfo1
     */
    public function setAddInfo1($addInfo1)
    {
        $this->addInfo1 = $addInfo1;
    }

    /**
     * @return string
     */
    public function getAddInfo2()
    {
        return $this->addInfo2;
    }

    /**
     * @param string $addInfo2
     */
    public function setAddInfo2($addInfo2)
    {
        $this->addInfo2 = $addInfo2;
    }

    /**
     * @return string
     */
    public function getAddInfo3()
    {
        return $this->addInfo3;
    }

    /**
     * @param string $addInfo3
     */
    public function setAddInfo3($addInfo3)
    {
        $this->addInfo3 = $addInfo3;
    }

    /**
     * @return string
     */
    public function getAddInfo4()
    {
        return $this->addInfo4;
    }

    /**
     * @param string $addInfo4
     */
    public function setAddInfo4($addInfo4)
    {
        $this->addInfo4 = $addInfo4;
    }

    /**
     * @return string
     */
    public function getAddInfo5()
    {
        return $this->addInfo5;
    }

    /**
     * @param string $addInfo5
     */
    public function setAddInfo5($addInfo5)
    {
        $this->addInfo5 = $addInfo5;
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
     * @return string
     */
    public function getSignatureData()
    {
        $data = $this->tid;
        $data .= $this->shopId;
        $data .= $this->amount;
        $data .= $this->refTranID;
        //$data .= $this->splitTran;
        $data .= $this->addInfo1;
        $data .= $this->addInfo2;
        $data .= $this->addInfo3;
        $data .= $this->addInfo4;
        $data .= $this->addInfo5;
        //It looks like the additional fields are not used by the signature, despite what the documentation says

        return $data;
    }
    
    /**
     * @return array
     */
    public function toArray()
    {
        //Even though the documentation mentions an initial uppercase letter in the field names, these seem to work
        //with a lowercase first letter...
        return array(
            'signature'       => $this->signature,
            'tid'             => $this->tid,
            'shopID'          => $this->shopId,
            'amount'          => (string)$this->amount,
            'refTranID'       => $this->refTranID,
            'splitTran'       => $this->splitTran,
            'addInfo1'        => $this->addInfo1,
            'addInfo2'        => $this->addInfo2,
            'addInfo3'        => $this->addInfo3,
            'addInfo4'        => $this->addInfo4,
            'addInfo5'        => $this->addInfo5
        );
    }
}
