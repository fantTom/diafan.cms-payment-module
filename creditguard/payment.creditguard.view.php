<?php
/**
 * Шаблон платежа через систему Credit Guard
 *
 * @package    DIAFAN.CMS
 * @author     fant-tom@mail.ru
 * @version    5.4
 */

if (!defined('DIAFAN')) {
    $path = __FILE__;
    $i = 0;
    while (!file_exists($path . '/includes/404.php')) {
        if ($i == 10) exit;
        $i++;
        $path = dirname($path);
    }
    include $path . '/includes/404.php';
}
if (@$result["pay"]['error']) {
    echo '<p>' . $this->diafan->_('Ошибка получения токена платежа. Сообщение:') . ' ' . $result["pay"]['error_message'] . '</p>';
} else if ($result["response"]["doDeal"] ["status"] == '329') {
    echo '<p>' . $this->diafan->_('Ошибка получения токена платежа. Сообщение:') . ' ' . $result["response"]["userMessage"] . '</p>';
} else {
    echo '<img src="https://cgmpiuat.creditguard.co.il/CGMPI_Server/merchantPages/ResponsiveWebSources/images/Logo.gif">';
    echo "<div style='display:flex;     flex-direction: column;'>";
    echo $result["pay"]["desc"] . "<br>";
    echo $result["pay"]["text"] . "<br>";
    echo $result["response"]["dateTime"] . "<br>";
    echo $result["response"]["userMessage"] . "<br>";
    //echo '<pre>'.print_r($result,1)."</pre>";
    ?>
    <span>token: <?= $_SESSION["payment"]['txId'] ?></span>
    <span>Имя: <?= $result["pay"]["details"]["name"] ?></span>
    <span>e-mail: <?= $result["pay"]["details"]["email"] ?></span>
    <span>номер телефона: <?= $result["pay"]["details"]["phone"] ?></span>
    <span>оплата на сумму: <?= $result["pay"]["summ"] ?></span>
    <a href="<?php echo $result['url']; ?>"><?php echo $this->diafan->_('Перейти к оплате', false); ?></a>
    </div>
    <?php
}