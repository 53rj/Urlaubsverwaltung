<?php
include "include/meta.html";
include "include/header.html";
?>
<title>Logout</title>

<?php
session_start();
$_SESSION = array();                                //////////////////////////////
if (ini_get("session.use_cookies")) {               //                          //
    $params = session_get_cookie_params();          //                          //
    setcookie(session_name(), '', time() - 42000,   //        ChatGPT           //
        $params["path"], $params["domain"],         //                          //
        $params["secure"], $params["httponly"]      //                          //
    );                                              //                          //
}                                                   //////////////////////////////
session_destroy(); 
include "include/footer.html";
?>