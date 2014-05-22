<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2010 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class PessoaDAO extends DAO {

    public static function incluir(Model $pessoa) {

        $sql = "insert into Pessoa (nome) values (:nome)";

        return self::exec($sql, $pessoa);
    }

    public static function consultar(Model $pessoa) {

        $criterios = self::criterios($pessoa);
        $sql       = "select *
                        from Pessoa";

        if ($criterios) {
            $criterios = implode(" and ", $criterios);
            $sql      .= " where $criterios";
        }

        $sql .= " order by nome";

        return self::query($sql, $pessoa);
    }

    public static function alterar(Model $pessoa) {

        $criterios = self::criterios($pessoa, array("idPessoa"));

        if ($pessoa->get("idPessoa")) {

            $criterios = implode(", ", $criterios);
            $sql       = "update Pessoa
                             set $criterios
                           where idPessoa = :idPessoa";
        }

        return self::exec($sql, $pessoa);
    }

    public static function remover(Model $pessoa) {

        $sql = "delete
                  from Pessoa
                 where idPessoa = :idPessoa";

        return self::exec($sql, $pessoa);
    }
}
?>