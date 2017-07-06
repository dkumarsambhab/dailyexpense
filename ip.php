<?php
   $location = file_get_contents('http://freegeoip.net/json/'.$_SERVER['REMOTE_ADDR']);
 print_r($location);

?>