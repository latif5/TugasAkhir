<?php

//just for simple security - all php files must called from index.php
define ( 'MUST_FROM_INDEX', 'SAMPLE_WS2011.2' );
//load nusoap library
require 'C:/xampp/htdocs/sit/gmapnusoap/0.lib/nusoap/lib/nusoap.php';
//load db configuration
require 'db_config.php';
//run ws server
require 'ws_server.php';
?>
