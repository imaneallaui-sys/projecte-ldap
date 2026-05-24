<?php

// =========================================
// Conexión al servidor LDAP
// Validación de usuario y contraseña
// Redirección según resultado
// =========================================

// Configuración LDAP
$ldap_host = "192.168.18.22";
$ldap_dn = "dc=webnom,dc=cat";

// Recoger datos del formulario
$user = $_POST['username'];
$pass = $_POST['password'];

// Conectar con el servidor LDAP
$conn = ldap_connect($ldap_host);

// Usar protocolo LDAP v3 
ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);

// Comprobar conexión
if ($conn) {

    // Intento de autenticación (bind LDAP)
    // OJO: buscamos el usuario dentro de ou=grup1
    $bind = @ldap_bind($conn, "uid=$user,ou=grup1,$ldap_dn", $pass);

    // Si la autenticación es correcta
    if ($bind) {
        header("Location: success.php");
        exit();
    } 
    // Si falla la autenticación
    else {
        header("Location: error.html");
        exit();
    }

} else {
    // Si no se puede conectar al LDAP
    echo "Error de conexión con el servidor LDAP";
}

?>
