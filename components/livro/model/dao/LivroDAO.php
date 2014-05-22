<?php
/**
 * Livro.
 *
 * @author Selvino Wilmar Rodrigues Junior <selvinojunior@gmail.com>
 */
class LivroDAO extends DAO {

    public static function incluir(Model $livro) {

        $sql = "insert into Livro (numero) values (:numero)";

        return self::exec($sql, $livro);
    }

    public static function consultar(Model $livro) {

        $criterios = self::criterios($livro);
        $sql       = "select *
                        from Livro";

        if ($criterios) {
            $criterios = implode(" and ", $criterios);
            $sql      .= " where $criterios";
        }

        $sql .= " order by numero";

        return self::query($sql, $livro);
    }

    public static function alterar(Model $livro) {

        $criterios = self::criterios($livro, array("idLivro"));

        if ($livro->get("idLivro")) {

            $criterios = implode(", ", $criterios);
            $sql       = "update Livro
                             set $criterios
                           where idLivro = :idLivro";
        }

        return self::exec($sql, $livro);
    }

    public static function remover(Model $livro) {

        $sql = "delete
                  from Livro
                 where idLivro = :idLivro";

        return self::exec($sql, $livro);
    }
}
?>