<?php

class RatepayHelperVersion
{
    private $_version = '1.0.0';

    private $_zgbDse = 'https://www.ratepay.com/zusaetzliche-geschaeftsbedingungen-und-datenschutzhinweis';

    public function getRatepayVersion()
    {
        return $this->_version;
    }

    public function getRatepayLinkZgbDse()
    {
        return $this->_zgbDse;
    }
}