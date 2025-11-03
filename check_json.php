<?php
$p='C:\\Users\\Eduardo\ Soares\ Dev\\Documents\\condoImage\\_\\httpdocs\\staging\\application\\resources\\views\\presets\\default\\sections\\builder\\builder\.json';
$j=file_get_contents($p);
if($j===false){echo 'read_fail'; exit;}
$a=json_decode($j,true);
if($a===null){ echo 'decode_null:'.json_last_error_msg(); } else { echo 'ok'; }
