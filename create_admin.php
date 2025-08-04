<?php
// A simple CLI script to create a default admin user.
// Execute from the command line: php create_admin.php

// We are in the root, so paths are relative to it.
require_once 'src/config/config.php';
require_once 'src/models/User.php';

echo "Intentando crear usuario administrador...\n";

try {
    $user_model = new User();

    // --- Check if user already exists ---
    $username = 'admin';
    if ($user_model->findByUsername($username)) {
        echo "El usuario '$username' ya existe. No se ha realizado ninguna acción.\n";
        exit(0);
    }

    // --- Create the new user ---
    $data = [
        'username' => $username,
        'password' => 'admin' // The register method will hash this.
    ];

    if ($user_model->register($data)) {
        echo "¡Éxito! Se ha creado el usuario administrador.\n";
        echo "Usuario: $username\n";
        echo "Contraseña: admin\n";
    } else {
        echo "Error: No se pudo crear el usuario administrador.\n";
    }

} catch (Exception $e) {
    echo "Ocurrió un error crítico: " . $e->getMessage() . "\n";
}
?>
