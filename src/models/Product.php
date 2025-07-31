<?php

class Product {
    private $db;

    public function __construct() {
        // The Database class will be included from a central point later
        require_once __DIR__ . '/../lib/Database.php';
        $this->db = new Database();
    }

    /**
     * Get all products
     */
    public function getAll() {
        $this->db->query("SELECT * FROM products ORDER BY name ASC");
        return $this->db->resultSet();
    }

    /**
     * Get product by ID
     */
    public function getById($id) {
        $this->db->query("SELECT * FROM products WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Create a new product
     * @param array $data Associative array with product data (sku, name, unit_key, price, tax_rate)
     */
    public function create($data) {
        $this->db->query("INSERT INTO products (sku, name, unit_key, price, tax_rate) VALUES (:sku, :name, :unit_key, :price, :tax_rate)");

        // Bind values
        $this->db->bind(':sku', $data['sku']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':unit_key', $data['unit_key']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':tax_rate', $data['tax_rate']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update an existing product
     * @param int $id Product ID
     * @param array $data Associative array with product data
     */
    public function update($id, $data) {
        $this->db->query("UPDATE products SET sku = :sku, name = :name, unit_key = :unit_key, price = :price, tax_rate = :tax_rate WHERE id = :id");

        // Bind values
        $this->db->bind(':id', $id);
        $this->db->bind(':sku', $data['sku']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':unit_key', $data['unit_key']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':tax_rate', $data['tax_rate']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete a product
     * @param int $id Product ID
     */
    public function delete($id) {
        $this->db->query("DELETE FROM products WHERE id = :id");

        // Bind id
        $this->db->bind(':id', $id);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
