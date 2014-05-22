<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2010 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class TipoDAO extends DAO {

    public static function incluir(Model $tipo) {}

    public static function consultar(Model $tipo) {
        $criterios = array();

        if ($tipo->get("id_tipo")) {
            $criterios[] = "id_tipo = :id_tipo";
        }

        if ($tipo->get("descricao_tipo")) {
            $criterios[] = "descricao_tipo = :descricao_tipo";
        }
        
        $sql = "select *
                  from tipo";
        
        if ($criterios) {
            $sql .= " where " . implode(" and ", $criterios);
        }
        
        $sql .= " order by descricao_tipo";

        return self::query($sql, $tipo);
    }

    public static function alterar(Model $tipo) {}

    public static function remover(Model $tipo) {}
}
?>
