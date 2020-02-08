<?php
setcookie('sid', '', -1);//crer un cookie qui sera envoyé avec les en-têtes HTTP. 

header("location: index.php");
exit();

