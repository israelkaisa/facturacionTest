<?php

class SatCatalog {
    private $db;

    public function __construct() {
        require_once __DIR__ . '/../lib/Database.php';
        $this->db = new Database();
    }

    /**
     * Get all entries from a specific catalog table.
     * The table name is validated against a whitelist.
     * @param string $tableName The name of the catalog table (e.g., 'sat_cfdi_uses')
     * @return array|false
     */
    public function getAll($tableName) {
        // Whitelist of allowed table names to prevent SQL injection
        $allowedTables = [
            'sat_cfdi_uses',
            'sat_payment_methods',
            'sat_payment_forms',
            'sat_units'
        ];

        if (!in_array($tableName, $allowedTables)) {
            return false; // Invalid table name
        }

        // The table name is safe to use now
        $this->db->query("SELECT `key`, `value` FROM " . $tableName . " ORDER BY `key` ASC");

        // Fetch as an associative array where the key is the 'key' column
        $results = $this->db->resultSet();
        $associativeArray = [];
        foreach ($results as $row) {
            $associativeArray[$row['key']] = $row['value'];
        }

        return $associativeArray;
    }
}
?>
