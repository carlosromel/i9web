<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2012 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
/*
 * TODO: Incluir o modelo de internacionalização.
 */
if (isset($_REQUEST)) {
    list($component, $script) = explode("/", key($_REQUEST));

    $pattern  = "components/%s/view/js/%s";
    $script   = ! $script ? "index" : $script;
    $artifact = sprintf($pattern, $component, $script);
echo "[$artifact]";
    if (file_exists($artifact)) {
        echo file_get_contents($artifact);
    } else {
        $alternativeArtifact = sprintf("$pattern.js", $component, $script);
        if (file_exists($alternativeArtifact)) {
            echo file_get_contents($alternativeArtifact);
        }
    }
}
?>