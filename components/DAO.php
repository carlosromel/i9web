<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2010-2011 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
abstract class DAO {

    abstract static function incluir(Model $objeto);
    
    abstract static function consultar(Model $objeto);

    abstract static function alterar(Model $objeto);

    abstract static function remover(Model $objeto);

    public static function prepare($sql, $objeto) {

        $conexao         = ConnectionControl::obterConexao();
        $formatoCurto    = "(\d\d)[-\/](\d\d)[-\/](\d\d\d\d)";
        $formatoLongo    = "$formatoCurto (\d\d):(\d\d):(\d\d)";
        $formatoParcial  = "$formatoCurto (\d\d):(\d\d)";
        $formatoCompleto = "$formatoLongo(AM|PM)";

        if (is_object($objeto)) {
            $obj_vars = $objeto->get_object_vars();
            $keys     = array_keys($obj_vars);

            foreach ($keys as $key) {

                /*
                 * @TODO: Verificar a maneira correta de remover as tags html,
                 *        sem atrapalhar o base64 das imagens sem que seja
                 *        gerado um 'warning'.
                 */
                $value = @htmlentities($objeto->get($key));
                $param = ":$key";

                if (! is_array($value) && $objeto->hasSet($key) && ($value <> "null")) {
                    /*
                     * Verificamos a existência de aspas anteriores.
                     */
                    if (! (preg_match("/'[%]{$param}[%]'/", $sql) || is_numeric($value))){

                        if (preg_match("/^$formatoCompleto$/", $value, $data)) {
                            /*
                             * Verificamos a existência de uma data nos formatos:
                             * dd-mm-yyyy hh:mm:ssAM ou dd/mm/yyyy hh:mm:ssAM
                             */
                            $value = sprintf("%s-%s-%s %s:%s:%s%s",
                                             $data[3], $data[2], $data[1],
                                             $data[4], $data[5], $data[6], $data[7]);
                        } else if (preg_match("/^$formatoLongo$/", $value, $data)) {
                            /*
                             * Verificamos a existência de uma data nos formatos:
                             * dd-mm-yyyy hh:mm:ss ou dd/mm/yyyy hh:mm:ss
                             */
                            $value = sprintf("%s-%s-%s %s:%s:%s",
                                             $data[3], $data[2], $data[1],
                                             $data[4], $data[5], $data[6]);
                        } else if (preg_match("/^$formatoParcial$/", $value, $data)) {
                            /*
                             * Verificamos a existência de uma data nos formatos:
                             * dd-mm-yyyy hh:mm:ss ou dd/mm/yyyy hh:mm
                             */
                            $value = sprintf("%s-%s-%s %s:%s:%s",
                                             $data[3], $data[2], $data[1],
                                             $data[4], $data[5], "00");
                        } else if (preg_match("/^$formatoCurto$/", $value, $data)) {
                            /*
                             * Verificamos a existência de uma data nos formatos:
                             * dd-mm-yyyy ou dd/mm/yyyy
                             */
                            $value = sprintf("%s-%s-%s", $data[3], $data[2], $data[1]);
                        }

                        $value =  $conexao->quote($value);
                    }
                } else {
                    $value = "null";
                }

                $sql = preg_replace("/($param)/i", $value, $sql);
            }
        }

        /*
         * Parâmetros não utilizados são silenciosamente eliminados.
         */
        $sql = preg_replace("/:\[a-zA-Z_\]*/", "null", $sql);

        return $sql;
    }

    public static function exec($sql, $objeto) {

        $conexao = ConnectionControl::obterConexao();
        $sql     = self::prepare($sql, $objeto);

        return $conexao->exec($sql);
    }

    public static function query($sql, $objeto) {

        $conexao = ConnectionControl::obterConexao();
        $sql     = self::prepare($sql, $objeto);
        $stmt    = $conexao->query($sql, PDO::FETCH_CLASS, get_class($objeto));

        return $stmt->fetchAll();
    }

    public static function criterios(Model $registro, $exclusao = array()) {

        $obj_vars = $registro->get_object_vars();
        $keys     = array_keys($obj_vars);
        $criterio = array();

        foreach ($obj_vars as $obj => $valor) {
            if (! in_array($obj, $exclusao)) {
                if ($registro->hasSet($obj) and $valor) {
                    $criterio[] = "$obj = :$obj";
                }
            }
        }

        return $criterio;
    }
}
?>