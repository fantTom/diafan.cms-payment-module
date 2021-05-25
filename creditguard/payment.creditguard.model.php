<?php
/**
 * Шаблон платежа через систему Credit Guard
 *
 * @package    DIAFAN.CMS
 * @author     fant-tom@mail.ru
 * @version    5.4
 */
/*
 * test	$creditGuard = new CreditGuard("israeli", "I!fr43s!34", "0962832", "938", "https://cguat2.creditguard.co.il/xpo/Relay");
 */

if (!defined('DIAFAN')) {
    include dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/includes/404.php';
}


$autoloader = require '/var/www/html/vendor/autoload.php';
$autoloader->add('App', '/');

use TomerOfer\CreditGuard\CreditGuard;


class Payment_creditguard_model extends Diafan
{

    /**
     * Формирует данные для формы платежной системы "Credit Guard"
     *
     * @param array $params настройки платежной системы
     * @param array $pay данные о платеже
     * @return void
     */

    public function get($params, $pay)
    {

        $cart = $this->diafan->_cart->get();
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https' ? 'https' : 'http';
        $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
        $host = $_SERVER['SERVER_NAME'];
        $successURL = $protocol . '://' . $host . "/payment/get/creditguard/success/";
        $errorURL = $protocol . '://' . $host . "/payment/get/creditguard/fail/";
        $canselURL = $protocol . '://' . $host . "/dive-shop/cart/step2/show" . $pay["element_id"] . "/";
        $creditGuard = new CreditGuard($params['creditguard_username'], $params['creditguard_password'], $params['creditguard_terminal'], $params['creditguard_mid'], $params['creditguard_gateway']);
        $creditGuard->setLanguage("Eng"); // default: Eng
        $creditGuard->setSuccessUrl($successURL);
        $creditGuard->setErrorUrl($errorURL);
        $creditGuard->setCancelUrl($canselURL);
        $response = $creditGuard->getRedirectUrl(uniqid(), $pay["summ"], 0, $pay["id"], key($cart), $pay["details"]["email"], $pay["details"]["name"], $pay["details"]["phone"]);
        $result["url"] = $response['doDeal']['mpiHostedPageUrl'];
        $result["pay"] = $pay;
        $result["response"] = $response;
        $_SESSION["payment"]['id'] = $pay["id"];
        $_SESSION["payment"]['txId'] = $response['doDeal']['token'];

        return $result;

    }
}
