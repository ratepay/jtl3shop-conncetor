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
class PiRatepay_Paypage_Model_Customer
{

    /**
     * firstname
     * @var string
     */
    private $_firstName;

    /**
     * lastname
     * @var string
     */
    private $_lastName;

    /**
     * title
     * @var string
     */
    private $_title;

    /**
     * emailaddress
     * @var string
     */
    private $_email;

    /**
     * date of birth
     * @var string
     */
    private $_dateOfBirth;

    /**
     * gender
     * @var string
     */
    private $_gender;

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
     * mobile
     * @var string
     */
    private $_mobile;

    /**
     * companyname
     * @var string
     */
    private $_companyName;

    /**
     * value-added-tax id
     * @var string
     */
    private $_vatId;

    /**
     * nationality
     * @var string
     */
    private $_nationality;

    /**
     * billingaddress
     * @var PiRatepay_Paypage_Model_Address
     */
    private $_billingAddress;

    /**
     * shippingaddress
     * @var PiRatepay_Paypage_Model_Address
     */
    private $_shippingAddress;

    /**
     * An instance of the validationclass
     * @var Pi_Util_Validation
     */
    private $_validation;

    /**
     * Construct
     *
     * Instances the Validationobject
     * @param string $firstName
     * @param string $lastName
     * @param string $title
     * @param string $email
     * @param string $dateOfBirth
     * @param string $gender
     * @param string $phone
     * @param string $fax
     * @param string $mobile
     * @param string $companyName
     * @param string $vatId
     * @param string $nationality
     * @param PiRatepay_Paypage_Model_Address $billingAddress
     * @param PiRatepay_Paypage_Model_Address $shippingAddress
     * @param Pi_Util_Validation $validation defaults to null
     */
    public function __construct(
        $firstName = null,
        $lastName = null,
        $title = null,
        $email = null,
        $dateOfBirth = null,
        $gender = null,
        $phone = null,
        $fax = null,
        $mobile = null,
        $companyName = null,
        $vatId = null,
        $nationality = null,
        PiRatepay_Paypage_Model_Address $billingAddress = null,
        PiRatepay_Paypage_Model_Address $shippingAddress = null,
        Pi_Util_Validation $validation = null
    )
    {
        $this->_validation = is_null($validation)? new Pi_Util_Validation() : $validation;

        if (!is_null($firstName)) {
            $this->setFirstName($firstName);
        }
        if (!is_null($lastName)) {
            $this->setLastName($lastName);
        }
        if (!is_null($title)) {
            $this->setTitle($title);
        }
        if (!is_null($email)) {
            $this->setEmail($email);
        }
        if (!is_null($dateOfBirth)) {
            $this->setDateOfBirth($dateOfBirth);
        }
        if (!is_null($gender)) {
            $this->setGender($gender);
        }
        if (!is_null($phone)) {
            $this->setPhone($phone);
        }
        if (!is_null($fax)) {
            $this->setFax($fax);
        }
        if (!is_null($mobile)) {
            $this->setMobile($mobile);
        }
        if (!is_null($companyName)) {
            $this->setCompanyName($companyName);
        }
        if (!is_null($vatId)) {
            $this->setVatId($vatId);
        }
        if (!is_null($nationality)) {
            $this->setNationality($nationality);
        }
        if (!is_null($billingAddress)) {
            $this->setBillingAddress($billingAddress);
        }
        if (!is_null($shippingAddress)) {
            $this->setShippingAddress($shippingAddress);
        }
    }

    /**
     * This function returns the value of the parameter firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->_firstName;
    }

    /**
     * This function sets the value for the parameter firstName
     *
     * @param string $firstName
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter firstname was not submitted as string
     */
    public function setFirstName($firstName)
    {
        if ($this->_validation->validateIsString($firstName)) {
            $this->_firstName = $firstName;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(117);
        }
    }

    /**
     * This function returns the value of the parameter lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->_lastName;
    }

    /**
     * This function sets the value for the parameter lastName
     *
     * @param string $lastName
     * @throws PiRatepay_Paypage_Util_ValidationException
     */
    public function setLastName($lastName)
    {
        if ($this->_validation->validateIsString($lastName)) {
            $this->_lastName = $lastName;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(118);
        }
    }

    /**
     * This function returns the value of the parameter title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * This function sets the value for the parameter title
     *
     * @param string $title
     * @throws PiRatepay_Paypage_Util_ValidationException
     */
    public function setTitle($title)
    {
        if ($this->_validation->validateIsString($title)) {
            $this->_title = $title;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(119);
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
     * This function returns the value of the parameter firstName
     *
     * @return date
     */
    public function getDateOfBirth()
    {
        return $this->_dateOfBirth;
    }

    /**
     * This function sets the value for the parameter dateOfBirth
     *
     * @param date $dateOfBirth YYYY-MM-DD
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter dateOfBirth was submitted with an unsupported format. YYYY-MM-DD is required
     */
    public function setDateOfBirth($dateOfBirth)
    {
        if ($this->_validation->validateWithRegex("\d{4}-\d{2}-\d{2}", $dateOfBirth)) {
            $this->_dateOfBirth = $dateOfBirth;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(303);
        }
    }

    /**
     * This function returns the value of the parameter gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * This function sets the value for the parameter gender
     *
     * @param string $gender M, F or U
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter gender was submitted with an unsupported format. M,F or U is required
     */
    public function setGender($gender)
    {
        if ($this->_validation->validateWithRegex("^[MFU]$", $gender)) {
            $this->_gender = $gender;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(304);
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
     * This function returns the value of the parameter mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->_mobile;
    }

    /**
     * This function sets the value for the parameter mobile
     *
     * @param string $mobile
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter mobile was not submitted as string
     */
    public function setMobile($mobile)
    {
        if ($this->_validation->validateIsString($mobile)) {
            $this->_mobile = $mobile;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(102);
        }
    }

    /**
     * This function returns the value of the parameter companyName
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->_companyName;
    }

    /**
     * This function sets the value for the parameter companyName
     *
     * @param string $companyName
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter companyName was not submitted as string
     */
    public function setCompanyName($companyName)
    {
        if ($this->_validation->validateIsString($companyName)) {
            $this->_companyName = $companyName;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(103);
        }
    }

    /**
     * This function returns the value of the parameter vatId
     *
     * @return string
     */
    public function getVatId()
    {
        return $this->_vatId;
    }

    /**
     * This function sets the value for the parameter vatId
     *
     * @param string $vatId
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter vatId was not submitted as string
     */
    public function setVatId($vatId)
    {
        if ($this->_validation->validateIsString($vatId)) {
            $this->_vatId = $vatId;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(104);
        }
    }

    /**
     * This function returns the value of the parameter nationality
     *
     * @return string
     */
    public function getNationality()
    {
        return $this->_nationality;
    }

    /**
     * This function sets the value for the parameter nationality
     *
     * @param string $nationality
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter nationality was not submitted as string
     */
    public function setNationality($nationality)
    {
        if ($this->_validation->validateIsString($nationality)) {
            $this->_nationality = $nationality;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(105);
        }
    }

    /**
     * This function returns the value of the parameter billingaddress
     *
     * @return AddressModel
     */
    public function getBillingAddress()
    {
        return $this->_billingAddress;
    }

    /**
     * This function sets the value for the parameter billingAddress
     *
     * @param AddressModel $billingAddress
     */
    public function setBillingAddress(PiRatepay_Paypage_Model_Address $billingAddress)
    {
        $this->_billingAddress = $billingAddress;
    }

    /**
     * This function returns the value of the parameter shippingAddress
     *
     * @return AddressModel
     */
    public function getShippingAddress()
    {
        return $this->_shippingAddress;
    }

    /**
     * This function sets the value for the parameter shippingAddress
     *
     * @param AddressModel $shippingAddress
     */
    public function setShippingAddress(PiRatepay_Paypage_Model_Address $shippingAddress)
    {
        $this->_shippingAddress = $shippingAddress;
    }

    /**
     * This function converts the whole data of the object into an array.
     *
     * @return array
     */
    public function toArray()
    {
        $billing = $this->getBillingAddress();

        $returnArray = array(
                'first_name'      => $this->getFirstName(),
                'last_name'       => $this->getLastName(),
                'title'           => $this->getTitle(),
                'email'           => $this->getEmail(),
                'date_of_birth'   => $this->getDateOfBirth(),
                'gender'          => $this->getGender(),
                'phone'           => $this->getPhone(),
                'fax'             => $this->getFax(),
                'mobile'          => $this->getMobile(),
                'company_name'    => $this->getCompanyName(),
                'vat_id'          => $this->getVatId(),
                'nationality'     => $this->getNationality(),
                'billing_address' => $billing->toArray()
        );

        $shippingAddress = $this->getShippingAddress();

        if (!is_null($shippingAddress)) {
            $returnArray['customer']['shipping_address'] = $shippingAddress->toArray();
        }

        return $returnArray;
    }

}
