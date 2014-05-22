<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2012 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (isset($_REQUEST)) {
    list($component, $image) = explode("/", key($_REQUEST));

    $image      = $image ? $image : "logo";
    $artifact   = "components/$component/view/img/$image";
    $extensions = array("gif", "png", "jpg", "jpeg");

    foreach ($extensions as $extension) {
        if (substr($artifact, - strlen($extension)) == $extension) {
            $image = substr($artifact, 0, strlen($artifact) - strlen($extension) - 1) . "." . $extension;
            if (file_exists($image)) {
                echo file_get_contents($image);
                break;
            }
        }
    }
}
?>