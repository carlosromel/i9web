<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2010-2011 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class ConnectionControl extends Control {

    static private $conexao;

    static function obterConexao() {

        if (! self::$conexao) {
            self::$conexao = new PDO(DBDSN, DBUSUARIO, DBSENHA);
        }

        return self::$conexao;
    }

    public static function authenticate() {
        $mensagem      = "";
        $autenticado   = false;
        self::$conexao = self::obterConexao();
        
        /*
         * Quando a credencial vem do formulário, o campo é chamado usuário.
         * Nos demais casos é credencial.
         */
        if (isset($_REQUEST["usuario"])) {
            $credencial = $_REQUEST["usuario"];
        } else if (isset($_SESSION["credencial"])) {
            $credencial = $_SESSION["credencial"];
        } else {
            $credencial = "";
        }
        
        if (isset($_REQUEST["senha"])) {
            $senha = md5($_REQUEST["senha"]);
        } else if (isset($_SESSION["senha"])) {
            $senha = $_SESSION["senha"];
        } else {
            $senha = "";
        }

        if ($credencial && $senha) {
            /*
             * TODO: Levar esse código para uma classe DAO correspondente.
             */
            $sql       = "select u.id_usuario,
                                 u.credencial
                            from usuario u
                                 left outer join email e
                                     on e.id_usuario = u.id_usuario
                           where '$credencial' in (u.credencial, e.email)
                             and u.senha = '$senha'";
            $resultado = self::$conexao->query($sql);

            /*
             * Caso o usuário seja encontrado, persistimos o objeto na
             * sessão aberta.
             */
            if($resultado->rowCount()) {
                SessionControl::$usuario = $resultado->fetchObject("UsuarioModel");
                $_SESSION["credencial"] = SessionControl::$usuario->get("credencial");
                /*
                 * A senha armazenada será a que foi informada, nunca do
                 * banco de dados.
                 */
                $_SESSION["senha"] = $senha;
                $autenticado = true;
            } else {
                $mensagem = "Credencial inválida.";
            }
        }
        
        if (! $autenticado) {
            $login = new LoginControl();
            $login->index($mensagem)->show();
        }
        
        return $autenticado;
    }
}

?>