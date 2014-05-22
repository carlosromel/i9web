<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2012 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (isset($_REQUEST)) {
    list($component, $styleSheet) = explode("/", key($_REQUEST));

    $styleSheet = $styleSheet ? $styleSheet : "index";
    $artifact   = sprintf("components/%s/view/css/%s.css", $component, $styleSheet);

    if (file_exists($artifact)) {
        echo file_get_contents($artifact);
    }
}
?>