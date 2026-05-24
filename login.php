<?php

//aqui Connexió LDAP

$ldap_host = "192.168.18.22";
$ldap_dn = "dc=webnom,dc=cat";

$user = $_POST['username'];
$pass = $_POST['password'];

$conn = ldap_connect($ldap_host);

ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);

if ($conn) {

    $bind = @ldap_bind($conn, "uid=$user,ou=grup1,$ldap_dn", $pass);

    if ($bind) {
        header("Location: success.php");
    } else {
        header("Location: error.html");
    }
}
?>
