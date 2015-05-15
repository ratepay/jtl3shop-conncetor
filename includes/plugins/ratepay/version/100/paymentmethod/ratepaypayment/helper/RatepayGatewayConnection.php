<?php

class RatepayHelperConnection
{
    private $_PROD_URL = 'https://paymentpage.ratepay.com';

    private $_INT_URL = 'https://paymentpage-int.ratepay.com';

    private $_API_SUFFIX = '/api/1.0/rppaypageapi.php';

    private $_TOKEN_SUFFIX = '/paypage/payment/show/lang/de/token/';

    public function getRatepayPayPageApiUrl($sandbox = false)
    {
        return ($sandbox) ? $this->_INT_URL . $this->_API_SUFFIX : $this->_PROD_URL . $this->_API_SUFFIX;
    }

    public function getRatepayPayPageUrl($sandbox = false)
    {
        return ($sandbox) ? $this->_INT_URL . $this->_TOKEN_SUFFIX : $this->_PROD_URL . $this->_TOKEN_SUFFIX;
    }
}