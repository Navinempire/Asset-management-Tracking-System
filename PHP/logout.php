<?php
session_start();
session_unset();
session_destroy();
setcookie(session_name(),"",time()-1,"/");
header("Location: ../index.html");
exit();
?>