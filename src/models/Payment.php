<?php

class Payment {
    private $db;

    public function __construct() {
        require_once __DIR__ . '/../lib/Database.php';
        $this->db = new Database();
    }

    /**
     * Get all payments for a specific invoice
     * @param int $invoiceId
     */
    public function getByInvoiceId($invoiceId) {
        $this->db->query("SELECT * FROM payments WHERE invoice_id = :invoice_id ORDER BY payment_date DESC");
        $this->db->bind(':invoice_id', $invoiceId);
        return $this->db->resultSet();
    }

    /**
     * Create a new payment record
     * @param array $data Contains payment info (invoice_id, amount, payment_date, etc.)
     */
    public function create($data) {
        $this->db->query("
            INSERT INTO payments (invoice_id, amount, payment_date, payment_method, reference)
            VALUES (:invoice_id, :amount, :payment_date, :payment_method, :reference)
        ");

        $this->db->bind(':invoice_id', $data['invoice_id']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':payment_date', $data['payment_date']);
        $this->db->bind(':payment_method', $data['payment_method']);
        $this->db->bind(':reference', $data['reference']);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    /**
     * Get the total amount paid for a specific invoice
     */
    public function getTotalPaidForInvoice($invoiceId) {
        $this->db->query("SELECT SUM(amount) as total_paid FROM payments WHERE invoice_id = :invoice_id");
        $this->db->bind(':invoice_id', $invoiceId);
        $result = $this->db->single();
        return $result['total_paid'] ?? 0;
    }
}
?>
