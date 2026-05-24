<?php

// IP del servidor LDAP
$ldap_host = "192.168.18.22";

// Base del LDAP (raíz)
$ldap_dn = "dc=webnom,dc=cat";

// Recoger usuario y contraseña del formulario
$user = $_POST['username'];
$pass = $_POST['password'];

// Conectar con el servidor LDAP
$conn = ldap_connect($ldap_host);

// Usar LDAP versión 3
ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);

// Si hay conexión
if ($conn) {

    // Buscar el usuario en todo el LDAP
    $search = ldap_search($conn, $ldap_dn, "(uid=$user)");

    // Si la búsqueda funciona
    if ($search) {

        // Obtener resultados
        $entries = ldap_get_entries($conn, $search);

        // Si existe el usuario
        if ($entries["count"] > 0) {

            // Sacar el DN real del usuario
            $user_dn = $entries[0]["dn"];

            // Intentar login con usuario y contraseña
            $bind = @ldap_bind($conn, $user_dn, $pass);

            // Si login correcto
            if ($bind) {
                header("Location: success.php");
                exit();
            } else {
                header("Location: error.html");
                exit();
            }

        } else {
            // Usuario no existe
            header("Location: error.html");
            exit();
        }

    } else {
        // Error en la búsqueda LDAP
        echo "Error en la búsqueda LDAP";
    }

} else {
    // Error de conexión
    echo "Error LDAP";
}

?>
