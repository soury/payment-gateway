<?php

namespace PagamentiOnline\PagOnline;

abstract class PaymentResponse
{
    /**
     * PaymentResponse constructor.
     * @param \stdClass $rawSoapResponse
     */
    public function __construct(\stdClass $rawSoapResponse)
    {
        $this->initFromRawSoapResponse($rawSoapResponse);
    }

    /**
     * @param \stdClass $rawSoapResponse
     * @return void
     */
    abstract protected function initFromRawSoapResponse(\stdClass $rawSoapResponse);
}
