<?php

setcookie("filter", '',time() - 3600, "/hpr");
setcookie("search", '',time() - 3600, "/hpr");

//echo "sheet finished, cookies should be unset";

header( 'Location: ../backend' ) ;

?>
