<?php
/**
 * Шаблон платежа через систему Credit Guard
 *
 * @package    DIAFAN.CMS
 * @author     fant-tom@mail.ru
 * @version    5.4
 */


if (!defined('DIAFAN')) {
    include dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/includes/404.php';
}


if (empty($_REQUEST["txId"])) {
    Custom::inc('includes/404.php');
}


$pay = $this->diafan->_payment->check_pay($_SESSION["payment"]['id'], 'creditguard');


if ($_GET["rewrite"] == "creditguard/success") {
    $this->diafan->_payment->success($pay, 'pay');
    $this->diafan->_payment->success($pay, 'redirect');
}

$this->diafan->_payment->fail($pay);

