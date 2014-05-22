<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2010-2012 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class SessionControl {
    const MODULO = 0;
    const CLASSE = 1;
    const METODO = 2;
    const ID     = 3;

    public static $modulo;
    public static $usuario;
    public static $componente;
    public static $metodo;
    public static $id;

    public static function getSessionParameters() {
        $modulo = "";
        /*
         * Representa o usuário autenticado.
         */
        self::$usuario = new UsuarioModel();
        /*
         * Representa o módulo que será executado.
         * 
         * Somente classes do tipo Control podem ser invocadas e, obviamente,
         * a classe precisa existir (vide autoLoad.php)
         */
        if (isset($_REQUEST["componente"]) && class_exists($_REQUEST["componente"] . "Control")) {
            $modulo = $_REQUEST["componente"];
            /*
             * Representa a classe que será instanciada.
             */
            self::$componente = $modulo . "Control";
            /*
             * Representa o método que será invocado.
             */
            if (isset($_REQUEST["metodo"]) && method_exists(self::$componente, $_REQUEST["metodo"])) {
                self::$metodo = $_REQUEST["metodo"];
            } else {
                self::$metodo = "index";
            }
        }
        /*
         * Representa um identificador, válido no contexto da classe.
         */
        if (isset($_REQUEST["id"])) {
            self::$id = $_REQUEST["id"];
        } else {
            self::$id = 0;
        }
    }
}
?>