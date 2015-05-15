<?php
include_once (PFAD_ROOT.PFAD_INCLUDES_MODULES.'PaymentMethod.class.php');
require_once(dirname(__FILE__) . '/bootstrap.php');

class Ratepay extends PaymentMethod
{
    public function init($nAgainCheckout = 0)
    {
        parent::init($nAgainCheckout);
        $this->name = 'RatePAY';
        $this->caption = 'RatePAY';
    }

    public function preparePaymentProcess($order) {
        global $oPlugin;

        $requestObject = $this->_getRequestObject($order);
        $requestModel = $this->_getRequestModel($order);
        //die(print_r((array) $requestModel));

        $token = $requestObject->initialisation($requestModel);

        $helperConnection = new RatepayHelperConnection;
        $helperData = new RatepayData;

        $sandbox = $helperData->isConfigSet($oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_sandbox']);

        header('Location: ' . $helperConnection->getRatepayPayPageUrl($sandbox) . $token);
    }

    public function handleNotification($order, $hash, $args) {
        if($this->verifyNotification($order, $hash, $args)) {
            $requestObject = $this->_getRequestObject($order);
            $requestModel = $this->_getRequestModel($order);
            $result = $requestObject->finalisation($requestModel, $args['token']);

            if ($result !== true) {
                $this->cancelOrder($order->kBestellung);
                header('Location: ' . gibShopURL() . '/bestellvorgang.php?editZahlungsart=1');
            }

            $this->setOrderStatusToPaid($order);

            $zahlungseingang->kBestellung = $order->kBestellung;
            $zahlungseingang->cZahlungsanbieter = "RatePAY";
            $zahlungseingang->fBetrag = $order->fGesamtsumme;
            $zahlungseingang->cISO = $order->Waehrung->cISO;
            $zahlungseingang->cHinweis = $args['descriptor'];
            $zahlungseingang->dZeit = strftime('%Y-%m-%d %H:%M:%S', time());
            $zahlungseingang->cAbgeholt = 'N';

            $GLOBALS['DB']->insertRow('tzahlungseingang', $zahlungseingang);

            $this->sendMail($order->kBestellung, MAILTEMPLATE_BESTELLUNG_BEZAHLT);

            header('Location: ' . $this->getReturnURL($order));
        } else {
            $this->cancelOrder($order->kBestellung);
            header('Location: ' . gibShopURL() . '/bestellvorgang.php?editZahlungsart=1');
        }
    }

    public function verifyNotification($order, $hash, $args) {
        return true;
    }

    public function finalizeOrder($order, $hash, $args)
    {
        return $this->verifyNotification($order, $hash, $args);
    }

    public function isValid($customer, $cart)
    {
        $kPlugin = gibkPluginAuscModulId($this->cModulId);
        $oPlugin = new Plugin($kPlugin);
        $helperData = new RatepayData;

        $config['sandbox'] = $helperData->isConfigSet($oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_sandbox']);
        $config['ala']     = $helperData->isConfigSet($oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_ala']);
        $config['b2b']     = $helperData->isConfigSet($oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_b2b']);
        $config['min']     = (int) $oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_min'];
        $config['max']     = (int) $oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_max'];

        if ($_GET['ratepayFailure'] == "1" && !$config['sandbox']) {
            return false;
        }

        if ($customer->cLand != "DE") {
            return false;
        }

        $total = $this->_getTotalByCartArticles($cart->PositionenArr);
        if ($total < $config['min'] || $total > $config['max']) {
            return false;
        }

        if (!empty($customer->cFirma) && !$config['b2b']) {
            return false;
        }

        $billingAdr  = $this->_getAddressArray($customer);
        $shippingAdr = $this->_getAddressArray($GLOBALS["HTTP_SESSION_VARS"]["Lieferadresse"]);

        if (count(array_diff($billingAdr, $shippingAdr)) > 0 && !$config['ala']) {
            return false;
        }

        return true;

    }

    public function noOrder() {
        header("HTTP/1.1 400 Bad Request");
        header("Status: 400 Bad Request");
        return;
    }

    public function _getAddressArray($object) {
        return array(
            'vorname' => $object->cVorname,
            'nachname' => $object->cNachname,
            'firma' => $object->cFirma,
            'strasse' => $object->cStrasse,
            'hausnummer' => $object->cHausnummer,
            'plz' => $object->cPLZ,
            'ort' => $object->cOrt,
            'land' => $object->cLand);
    }



    private function _getRequestObject($order) {
        global $oPlugin;
        $helperConnection = new RatepayHelperConnection;
        $helperData = new RatepayData;

        $config['profile_id']    = $oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_profile_id'];
        $config['security_code'] = $oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_security_code'];
        $config['sandbox']       = $helperData->isConfigSet($oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_sandbox']);

        $requestObject = new PiRatepay_Paypage_Request_Curl();
        $requestObject->setSandBox($config['sandbox']);
        $requestObject->setId(
            md5(
                $config['profile_id'] .
                $config['security_code'] .
                $order->cBestellNr
            )
        );

        if ($config['sandbox']) {
            $requestObject->setSandBoxUrl($helperConnection->getRatepayPayPageApiUrl(true));
        } else {
            $requestObject->setLiveUrl($helperConnection->getRatepayPayPageApiUrl(false));
        }

        return $requestObject;
    }

    private function _getRequestModel($order) {
        global $oPlugin;

        $helperData = new RatepayData;

        $config['profile_id']    = $oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_profile_id'];
        $config['security_code'] = $oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_security_code'];
        $config['editable']      = $helperData->isConfigSet($oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_editable']);
        $config['basketitems']   = $helperData->isConfigSet($oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_basketitems']);

        $requestModel = new PiRatepay_Paypage_Model_Request();

        $requestModel->setProfileId($config['profile_id']);
        $requestModel->setSecurityCode($config['security_code']);
        $requestModel->setSuccessUrl(gibShopURL() . '/includes/modules/notify.php?sh=' . $this->generateHash($order));
        $requestModel->setFailureUrl(gibShopURL() . '/bestellvorgang.php?editZahlungsart=1&ratepayFailure=1');
        $requestModel->setOrderId($order->cBestellNr);

        $basketModel = new PiRatepay_Paypage_Model_Basket($order->Waehrung->cISO, $order->fGesamtsumme);

        foreach ($order->Positionen as $article) {
            if($article->fPreis <> 0) {
                $einzelpreisNetto =  (is_array($article->cEinzelpreisLocalized[1])) ? $article->cEinzelpreisLocalized[1]['EUR'] : $article->cEinzelpreisLocalized[1];
                $gesamtpreisNetto =  (is_array($article->cGesamtpreisLocalized[1])) ? $article->cGesamtpreisLocalized[1]['EUR'] : $article->cGesamtpreisLocalized[1];
                $gesamtpreisBrutto = (is_array($article->cGesamtpreisLocalized[0])) ? $article->cGesamtpreisLocalized[0]['EUR'] : $article->cGesamtpreisLocalized[0];
                switch ((int) $article->nPosTyp) {
                    case 5:
                        $artikelnummer = "paymentfee";
                        $artikelname = "Zahlartenaufschlag " . $article->cName;
                        break;
                    case 3:
                        $artikelnummer = "discount";
                        $artikelname = $article->cName;
                        break;
                    case 2:
                        $artikelnummer = "delivery";
                        if (isset($order->oVersandart)) {
                            $artikelname = $order->oVersandart->cName;
                        } else {
                            $artikelname = $article->cName;
                        }
                        break;
                    case 1:
                        $artikelnummer = $article->cArtNr;
                        $artikelname   = $article->Artikel->cName;
                        break;
                }
                $basketModel->addItem(
                    new PiRatepay_Paypage_Model_Item(
                        $artikelnummer,
                        $artikelname,
                        $article->nAnzahl,
                        $helperData->getPriceByLocalFormat($einzelpreisNetto),
                        $helperData->getPriceByLocalFormat($gesamtpreisNetto),
                        $helperData->getPriceByLocalFormat($gesamtpreisBrutto) - $helperData->getPriceByLocalFormat($gesamtpreisNetto)
                    )
                );
            }
        }

        $requestModel->setTax($order->fSteuern);

        $requestModel->setBasket($basketModel);

        $merchantModel = new PiRatepay_Paypage_Model_Merchant();
        $merchantModel->setName('Dummy');
        $merchantModel->setStreet('Dummy');
        $merchantModel->setZip('12345');
        $merchantModel->setCity('Dummy');
        $merchantModel->setPhone('123456');
        $merchantModel->setEmail('Dummy@dummy.de');
        $merchantModel->setFax('');
        $merchantModel->setFactorbank('Dummy');
        $merchantModel->setBanklocation('Dummy');
        $requestModel->setMerchant($merchantModel);

        $customerObject = new PiRatepay_Paypage_Model_Customer();
        $customerObject->setFirstName(html_entity_decode($order->oRechnungsadresse->cVorname));
        $customerObject->setLastName(html_entity_decode($order->oRechnungsadresse->cNachname));
        $customerObject->setEmail($order->oRechnungsadresse->cMail);
        if (!empty($_SESSION['Kunde']->dGeburtstag)) {
            $customerObject->setDateOfBirth($helperData->changeDateFormat($_SESSION['Kunde']->dGeburtstag));
        }
        $customerObject->setGender($helperData->getGender($order->oRechnungsadresse->cAnrede));
        $customerObject->setPhone($order->oRechnungsadresse->cTel);
        $customerObject->setMobile($order->oRechnungsadresse->cMobil);
        $customerObject->setFax($order->oRechnungsadresse->cFax);
        $customerObject->setCompanyName(html_entity_decode($order->oRechnungsadresse->cFirma));
        $customerObject->setVatId($order->oRechnungsadresse->cUSTID);
        $customerObject->setNationality($order->oRechnungsadresse->cLand);

        $billingAddress = new PiRatepay_Paypage_Model_Address(
            html_entity_decode($order->oRechnungsadresse->cStrasse),
            $order->oRechnungsadresse->cHausnummer,
            $order->oRechnungsadresse->cPLZ,
            html_entity_decode($order->oRechnungsadresse->cOrt),
            $order->oRechnungsadresse->cLand);
        $customerObject->setBillingAddress($billingAddress);

        if (isset($order->Lieferadresse)) {
            $shippingAddress = new PiRatepay_Paypage_Model_Address(
                html_entity_decode($order->Lieferadresse->cStrasse),
                $order->Lieferadresse->cHausnummer,
                $order->Lieferadresse->cPLZ,
                html_entity_decode($order->Lieferadresse->cOrt),
                $order->Lieferadresse->cLand);
            $customerObject->setShippingAddress($shippingAddress);
        }

        $requestModel->setCustomer($customerObject);

        $requestModel->setFlags(
            array(
                'edit_customer' => $config['editable'],
                'disable_items' => !$config['basketitems']
            )
        );

        return $requestModel;
    }

    private function _getTotalByCartArticles($positionen) {
        $helperData = new RatepayData;
        $total = 0;
        foreach ($positionen as $artikel) {
            $total += $helperData->getPriceByLocalFormat($artikel->cGesamtpreisLocalized[0]['EUR']);
        }
        return $total;
    }
}
?>