<?php

namespace PagamentiOnline\PagOnline\SoapClient;

interface WrapperInterface
{
    /**
     * @param $wsdlUrl string
     * @param array $soapOptions
     */
    public function initialize($wsdlUrl, array $soapOptions);

    /**
     * @return bool
     */
    public function isInitialized();

    /**
     * @param array $requestData
     * @return \stdClass
     */
    public function init(array $requestData);

    /**
     * @param array $requestData
     * @return \stdClass
     */
    public function verify(array $requestData);

    /**
     * @return string
     */
    public function getLastRequest();

    /**
     * @return string
     */
    public function getLastResponse();
}
