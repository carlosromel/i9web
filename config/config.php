<?php
/**
 * @author Carlos Romel Pereira da Silva <carlos.romel@gmail.com>
 * @copyright Copyright(c) 2009-2012 Carlos Romel Pereira da Silva
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/*
 * Os valores possíveis são: mysql, pgsql, mssql, oci
 */
define("DBDRIVE",    "mysql");
/*
 * A porta padrão.
 */
define("DBPORT",     "3306");
/*
 * O servidor da aplicação.
 */
define("DBHOST",     "localhost");
define("DBNAME",     "");
define("DBUSER",     "");
define("DBPASSWORD", "");
define("DBDSN",      DBDRIVE . ":dbname=" . DBNAME . ";host=" . DBHOST . ";port=" . DBPORT);
define("SITE",       "http://localhost/~c131644/i9web/");

require_once("autoLoad.php");

ini_set("display_errors", 1);

SessionControl::getSessionParameters();

?>