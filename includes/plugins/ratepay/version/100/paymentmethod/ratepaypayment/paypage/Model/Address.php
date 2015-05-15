<?php

/**
 * Address Model
 *
 * @category PayIntelligent
 * @package PiRatepay_Paypage_Model
 * @copyright Copyright(c) 2012 PayIntellignet GmbH
 * @license
 * @version 1.0.0
 */
class PiRatepay_Paypage_Model_Address
{

    /**
     * street
     * @var string
     */
    private $_street;

    /**
     * streetnumber
     * @var string
     */
    private $_streetNumber;

    /**
     * postal code
     * @var string
     */
    private $_zip;

    /**
     * city
     * @var string
     */
    private $_city;

    /**
     * country
     * @var string
     */
    private $_country;

    /**
     * An instance of the validationclass
     * @var Pi_Util_Validation
     */
    private $_validation;

    /**
     * Parameterized constructor.
     *
     * @param string $street Streetname
     * @param string $streetNumber Streetnumber
     * @param string $zip Postal code
     * @param string $city city
     * @param string $country Country Exp.:'ISO-3166-1-Alpha-2-Standard'
     * @param Pi_Util_Validation $validation defaults to null
     */
    public function __construct(
        $street = null,
        $streetNumber = null,
        $zip = null,
        $city = null,
        $country = null,
        $validation = null
    )
    {
        $this->_validation = is_null($validation)? new Pi_Util_Validation() : $validation;

        if (!is_null($street)) {
            $this->setStreet($street);
        }
        if (!is_null($streetNumber)) {
            $this->setStreetNumber($streetNumber);
        }
        if (!is_null($zip)) {
            $this->setZip($zip);
        }
        if (!is_null($city)) {
            $this->setCity($city);
        }
        if (!is_null($country)) {
            $this->setCountry($country);
        }
    }

    /**
     * This function sets the value for the street
     *
     * @param string $street
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter street was not submitted as string
     */
    public function setStreet($street)
    {
        if ($this->_validation->validateIsString($street)) {
            $this->_street = $street;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(108);
        }
    }

    /**
     * This function returns the value of the parameter street
     *
     * @return string or null
     */
    public function getStreet()
    {
        return $this->_street;
    }

    /**
     * This function sets the value for the streetnumber
     *
     * @param string $streetNumber
     * @throws PiRatepay_Paypage_Util_ValidationException 'The parameter streetNumber was submitted with an unsupported format'
     */
    public function setStreetNumber($streetNumber)
    {
        if ($this->_validation->validateWithRegex("^\d.*", $streetNumber) || $streetNumber == '') {
            $this->_streetNumber = $streetNumber;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(306);
        }
    }

    /**
     * This function returns the value of the parameter streetNumber
     *
     * @return string or null
     */
    public function getStreetNumber()
    {
        return $this->_streetNumber;
    }

    /**
     * This function sets the value for the Zip
     *
     * @param string $zip
     * @throws PiRatepay_Paypage_Util_ValidationException 'The parameter zip was not submitted as string'
     */
    public function setZip($zip)
    {
        if ($this->_validation->validateIsString($zip)) {
            $this->_zip = $zip;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(109);
        }
    }

    /**
     * This function returns the value of the parameter zip
     *
     * @return string or null
     */
    public function getZip()
    {
        return $this->_zip;
    }

    /**
     * This function sets the value for the city
     *
     * @param string $city
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter city was not submitted as string
     */
    public function setCity($city)
    {
        if ($this->_validation->validateIsString($city)) {
            $this->_city = $city;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(110);
        }
    }

    /**
     * This function returns the value of the parameter city
     *
     * @return string or null
     */
    public function getCity()
    {
        return $this->_city;
    }

    /**
     * This function sets the value for the country
     *
     * @param string $country
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter country was not submitted as string
     */
    public function setCountry($country)
    {
        if ($this->_validation->validateIsString($country)) {
            $this->_country = $country;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(120);
        }
    }

    /**
     * This function returns the value of the parameter country
     *
     * @return string or null
     */
    public function getCountry()
    {
        return $this->_country;
    }

    /**
     * Get model data as array.
     *
     * @return array
     */
    public function toArray()
    {
        $addressArray = array(
            'street'        => $this->getStreet(),
            'street_number' => $this->getStreetNumber(),
            'zip'           => $this->getZip(),
            'city'          => $this->getCity(),
            'country'       => $this->getCountry()
        );
        return $addressArray;
    }

}
