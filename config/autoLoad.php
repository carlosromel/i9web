<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2009-2012 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
function __autoLoad($classe) {
    $raiz    = "components";
    $caminho = "";

    if (preg_match("/(\w*)(Control|Model|DAO)$/", $classe, $resultado)) {
        $caminho    = "$raiz/$classe.php";
        $componente = $resultado[1];
        $controle   = lcfirst($resultado[2]);
        if (file_exists($caminho)) {
            require_once ($caminho);
        } else {
            $caminho = "$raiz/";
            if (strpos($componente, "_")) {
                $caminho .= lcfirst(substr($componente, 0, strpos($componente, "_")));
            } else {
                $caminho .= lcfirst("$componente");
            }
            $caminho .= "/$controle/$classe.php";
        }
    } else if (strpos($classe, "_")) { // Classes no estilo PEAR.
        $caminho = "lib/PEAR/" . str_replace("_", "/", $classe) . ".php";
    } else {
        $caminho = "$raiz/$classe.php";
    }
    
    if (file_exists($caminho)) {
        require_once ($caminho);
    } else {
        d($classe, true);
    }
}

function d($objeto, $pilha = false) {
    echo "<div style=\"border: 1px solid blue; background: yellow; margin: 10px; padding: 10px;\"><pre>";
    var_dump($objeto);
    if ($pilha) {
        echo "<hr>";
        $e = new Exception();
        echo $e->getTraceAsString();
    }
    echo "</pre></div>";
}
?>