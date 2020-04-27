<?php
namespace PagamentiOnline\PagOnline;

interface SignableInterface
{
    /**
     * @return string
     */
    public function getSignatureData();

    /**
     * @param $param
     * @return mixed
     */
    public function setSignature($param);
}
