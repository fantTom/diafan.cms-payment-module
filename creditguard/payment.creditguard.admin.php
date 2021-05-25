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

class Payment_creditguard_admin
{
    public $config;

    public function __construct()
    {
        $this->config = array(
            "name" => 'Credit Guard',
            "params" => array(
                'creditguard_username' => 'Логин CG',
                'creditguard_password' => 'Пароль CG',
                'creditguard_terminal' => 'Номер терминала CG',
                'creditguard_mid' => 'mid CG',
                'creditguard_gateway' => 'gateway CG'
            )
        );
    }
}