<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2009-2011 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

ini_set("display_errors",  "on");
ini_set("default_charset", "UTF-8");

session_cache_expire(3600); // Uma hora.
session_start();
session_destroy();

/*
 * Go back home!
 */
header("Location: ./");
?>