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

// Usar protocolo LDAP v3 (obligatorio)
ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);

// Comprobar conexión
if ($conn) {

    // Intento de autenticación (bind LDAP)
    // Busca el usuario en TODO el LDAP (grup1 + grup2)
    $bind = @ldap_bind($conn, "uid=$user,$ldap_dn", $pass);

    // Si la autenticación es correcta
    if ($bind) {
        header("Location: success.php");
        exit();
    } 
    // Si la autenticación falla
    else {
        header("Location: error.html");
        exit();
    }

} else {
    echo "Error de conexión con el servidor LDAP";
}

?>
