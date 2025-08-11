<?php

class Customer {
    private $db;

    public function __construct() {
        // The Database class will be included from a central point later
        require_once __DIR__ . '/../lib/Database.php';
        $this->db = new Database();
    }

    /**
     * Get all customers
     */
    public function getAll() {
        $this->db->query("SELECT * FROM customers ORDER BY name ASC");
        return $this->db->resultSet();
    }

    /**
     * Get customer by ID
     */
    public function getById($id) {
        $this->db->query("SELECT * FROM customers WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Get customer by RFC
     */
    public function findByRfc($rfc) {
        $this->db->query("SELECT * FROM customers WHERE UPPER(rfc) = UPPER(:rfc)");
        $this->db->bind(':rfc', $rfc);
        return $this->db->single();
    }

    /**
     * Create a new customer
     * @param array $data Associative array with customer data (name, rfc, address, email, phone)
     */
    public function create($data) {
        $this->db->query("INSERT INTO customers (name, rfc, address, email, phone) VALUES (:name, :rfc, :address, :email, :phone)");

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':rfc', $data['rfc']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update an existing customer
     * @param int $id Customer ID
     * @param array $data Associative array with customer data
     */
    public function update($id, $data) {
        $this->db->query("UPDATE customers SET name = :name, rfc = :rfc, address = :address, email = :email, phone = :phone WHERE id = :id");

        // Bind values
        $this->db->bind(':id', $id);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':rfc', $data['rfc']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete a customer
     * @param int $id Customer ID
     */
    public function delete($id) {
        $this->db->query("DELETE FROM customers WHERE id = :id");

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
