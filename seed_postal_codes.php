<?php

/**
 * Seeds the postal_codes table from the data file.
 *
 * @param PDO $dbh The database handler.
 */
function seed_postal_codes(PDO $dbh) {
    echo "Iniciando siembra de la tabla 'postal_codes'...\n";
    $file_path = __DIR__ . '/data/CPdescarga.txt';

    if (!file_exists($file_path)) {
        echo "Error: El archivo de datos 'data/CPdescarga.txt' no se encuentra.\n";
        return;
    }

    try {
        // Check if the table is already populated to avoid duplicate seeding
        $check_stmt = $dbh->query("SELECT COUNT(*) FROM postal_codes");
        if ($check_stmt->fetchColumn() > 0) {
            echo "La tabla 'postal_codes' ya contiene datos. Saltando siembra.\n";
            return;
        }

        $dbh->beginTransaction();

        $stmt = $dbh->prepare(
            "INSERT INTO postal_codes (d_codigo, d_asenta, d_tipo_asenta, d_mnpio, d_estado, d_ciudad) VALUES (:d_codigo, :d_asenta, :d_tipo_asenta, :d_mnpio, :d_estado, :d_ciudad)"
        );

        $handle = fopen($file_path, "r");
        if ($handle) {
            // Skip header line
            fgets($handle);

            $count = 0;
            while (($line = fgets($handle)) !== false) {
                // The file is UTF-8, but might have some encoding issues.
                $line = mb_convert_encoding($line, 'UTF-8', 'UTF-8');
                $parts = explode('|', trim($line));

                // The header has 15 columns, let's bind the ones we need
                if (count($parts) >= 7) {
                    $stmt->execute([
                        ':d_codigo' => $parts[0],       // d_codigo
                        ':d_asenta' => $parts[1],       // d_asenta
                        ':d_tipo_asenta' => $parts[2],  // d_tipo_asenta
                        ':d_mnpio' => $parts[3],        // D_mnpio
                        ':d_estado' => $parts[4],       // d_estado
                        ':d_ciudad' => $parts[5]        // d_ciudad
                    ]);
                    $count++;
                }
            }
            fclose($handle);
        }

        $dbh->commit();
        echo "OK: $count registros han sido insertados en 'postal_codes'.\n";

    } catch (Exception $e) {
        if ($dbh->inTransaction()) {
            $dbh->rollBack();
        }
        echo "Error durante la siembra de 'postal_codes': " . $e->getMessage() . "\n";
    }
}
