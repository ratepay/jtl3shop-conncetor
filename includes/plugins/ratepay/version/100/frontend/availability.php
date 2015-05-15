<?php

$error_failure_1 = 'Leider ist eine Bezahlung mit RatePAY nicht m&ouml;glich. Diese Entscheidung ist auf Grundlage einer automatisierten Datenverarbeitung getroffen worden. Einzelheiten finden sie in den ';
$error_failure_2 = 'zus&auml;tzlichen Allgemeinen Gesch&auml;ftsbedingungen und dem Datenschutzhinweis f&uuml;r RatePAY-Zahlungsarten';
$privacy_policy_url = 'https://www.ratepay.com/zusaetzliche-geschaeftsbedingungen-und-datenschutzhinweis-de';

if ($_GET['ratepayFailure'] == "1") {
    global $hinweis;
    $hinweis = $error_failure_1 . '<a href="' . $privacy_policy_url . '" target="_blank">' . $error_failure_2 . '</a>';
}