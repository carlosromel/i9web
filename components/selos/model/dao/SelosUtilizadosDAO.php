<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2010 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class SelosUtilizadosDAO extends DAO {

    public static function incluir(Model $selosUtilizados) {}

    public static function consultar(Model $selosUtilizados) {
        $criterios = array();

        if ($selosUtilizados->get("numero_recibo")) {
            $criterios[] = "numero_recibo = :numero_recibo";
        }

        if ($selosUtilizados->get("id_tipo")) {
            $criterios[] = "id_tipo = :id_tipo";
        }

        if ($selosUtilizados->get("data")) {
            $criterios[] = "data = :data";
        } else if ($selosUtilizados->get("data_inicial") and $selosUtilizados->get("data_final")) {
            $criterios[] = "data between :data_inicial and :data_final";
        } else if ($selosUtilizados->get("data_inicial")) {
            $criterios[] = "data >= :data_inicial";
        } else if ($selosUtilizados->get("data_final")) {
            $criterios[] = "data <= :data_final";
        }

        if ($selosUtilizados->get("cobrar_selo")) {
            $criterios[] = "cobrar_selo = :cobrar_selo";
        }

        if ($selosUtilizados->get("codigo_oficial")) {
            $criterios[] = "codigo_oficial = :codigo_oficial";
        }

        if ($selosUtilizados->get("valor_emolumento")) {
            $criterios[] = "valor_emolumento = :valor_emolumento";
        }

        if ($selosUtilizados->get("valor_de_referencia")) {
            $criterios[] = "valor_de_referencia = :valor_de_referencia";
        }

        if ($selosUtilizados->get("selo")) {
            $criterios[] = "selo = :selo";
        }
        
        $sql = "select *
                  from selos_utilizados";
        
        if ($criterios) {
            $sql .= " where " . implode(" and ", $criterios);
        }
        
        $sql .= " order by data, numero_recibo";

        return self::query($sql, $selosUtilizados);
    }

    public static function alterar(Model $selosUtilizados) {}

    public static function remover(Model $selosUtilizados) {}
}
?>
