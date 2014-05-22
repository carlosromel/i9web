<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2011 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class MenuControl extends Control {

    public function index() {
        $this->interface->setVariable("sayCheese", "");
        
        return $this->interface;
    }
}

?>