<?php

/**
 * Set Parameter for a Request and send them to the Paypage.
 *
 * @category PayIntelligent
 * @package PiRatepay_Paypage_Model
 * @copyright Copyright(c) 2012 PayIntellignet GmbH
 * @license
 * @version 1.0.0
 */
class PiRatepay_Paypage_Model_Merchant
{

    /**
     * name
     * @var string
     */
    private $_name;

    /**
     * street
     * @var string
     */
    private $_street;

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
     * phone
     * @var string
     */
    private $_phone;

    /**
     * fax
     * @var string
     */
    private $_fax;

    /**
     * email
     * @var string
     */
    private $_email;

    /**
     * factorbank
     * @var string
     */
    private $_factorbank;

    /**
     * banklocation
     * @var string
     */
    private $_bankLocation;

    /**
     * An instance of the validationclass
     * @var Pi_Util_Validation
     */
    private $_validation;

    /**
     * Construct
     *
     * Instances the Validationobject
     * @param string $name
     * @param string $street
     * @param string $zip
     * @param string $city
     * @param string $phone
     * @param string $fax
     * @param string $email
     * @param string $factorbank
     * @param string $banklocation
     * @param $validation defaults to null
     */
    public function __construct(
        $name = null,
        $street = null,
        $zip = null,
        $city = null,
        $phone = null,
        $fax = null,
        $email = null,
        $factorbank = null,
        $bankLocation = null,
        $validation = null
    )
    {
        $this->_validation = is_null($validation)? new Pi_Util_Validation() : $validation;

        if (!is_null($name)) {
            $this->setName($name);
        }
        if (!is_null($street)) {
            $this->setStreet($street);
        }
        if (!is_null($zip)) {
            $this->setZip($zip);
        }
        if (!is_null($city)) {
            $this->setCity($city);
        }
        if (!is_null($phone)) {
            $this->setPhone($phone);
        }
        if (!is_null($fax)) {
            $this->setFax($fax);
        }
        if (!is_null($email)) {
            $this->setEmail($email);
        }
        if (!is_null($factorbank)) {
            $this->setFactorBank($factorbank);
        }
        if (!is_null($bankLocation)) {
            $this->setBankLocation($bankLocation);
        }
    }

    /**
     * This function returns the value of the parameter name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * This function sets the value for the parameter name
     *
     * @param string $name
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter fristname was not submitted as string
     */
    public function setName($name)
    {
        if ($this->_validation->validateIsString($name)) {
            $this->_name = $name;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(107);
        }
    }

    /**
     * This function returns the value of the parameter street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->_street;
    }

    /**
     * This function sets the value for the parameter street
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
     * This function returns the value of the parameter zip
     *
     * @return string
     */
    public function getZip()
    {
        return $this->_zip;
    }

    /**
     * This function sets the value for the parameter zip
     *
     * @param string $zip
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter zip was not submitted as string
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
     * This function returns the value of the parameter city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->_city;
    }

    /**
     * This function sets the value for the parameter city
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
     * This function returns the value of the parameter phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * This function sets the value for the parameter phone
     *
     * @param string $phone
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter phone was not submitted as string
     */
    public function setPhone($phone)
    {
        if ($this->_validation->validateIsString($phone)) {
            $this->_phone = $phone;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(111);
        }
    }

    /**
     * This function returns the value of the parameter fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->_fax;
    }

    /**
     * This function sets the value for the parameter fax
     *
     * @param string $fax
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter fax was not submitted as string
     */
    public function setFax($fax)
    {
        if ($this->_validation->validateIsString($fax)) {
            $this->_fax = $fax;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(112);
        }
    }

    /**
     * This function returns the value of the parameter email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * This function sets the value for the parameter email
     *
     * @param string $email
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter email was submitted with an unsupported format
     */
    public function setEmail($email)
    {
        if ($this->_validation->validateWithRegex("^.*@.*\..*$", $email)) {
            $this->_email = $email;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(300);
        }
    }

    /**
     * This function returns the value of the parameter factorBank
     *
     * @return string
     */
    public function getFactorbank()
    {
        return $this->_factorbank;
    }

    /**
     * This function sets the value for the parameter factorBank
     *
     * @param string $factorBank
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter factorBank was not submitted as string
     */
    public function setFactorBank($factorBank)
    {
        if ($this->_validation->validateIsString($factorBank)) {
            $this->_factorbank = $factorBank;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(113);
        }
    }

    /**
     * This function returns the value of the parameter bankLocation
     *
     * @return string
     */
    public function getBankLocation()
    {
        return $this->_bankLocation;
    }

    /**
     * This function sets the value for the parameter bankLocation
     *
     * @param string $bankLocation
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter factorBank was not submitted as string
     */
    public function setBankLocation($bankLocation)
    {
        if ($this->_validation->validateIsString($bankLocation)) {
            $this->_bankLocation = $bankLocation;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(114);
        }
    }

    /**
     * This function converts the whole data of the object into an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'name'          => $this->getName(),
            'street'        => $this->getStreet(),
            'zip'           => $this->getZip(),
            'city'          => $this->getCity(),
            'phone'         => $this->getPhone(),
            'fax'           => $this->getFax(),
            'email'         => $this->getEmail(),
            'factorbank'    => $this->getFactorbank(),
            'bank_location' => $this->getBankLocation()
        );
    }

}
