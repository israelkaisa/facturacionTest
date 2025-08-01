<?php

class Document {
    private $db;

    public function __construct() {
        // We need the Database class
        require_once __DIR__ . '/../lib/Database.php';
        $this->db = new Database();
    }

    /**
     * Get all documents of a specific type (e.g., 'invoice')
     * Joins with customers table to get customer name
     */
    public function getAll($type = 'invoice') {
        $this->db->query("
            SELECT d.*, c.name as customer_name
            FROM documents d
            JOIN customers c ON d.customer_id = c.id
            WHERE d.type = :type
            ORDER BY d.created_at DESC
        ");
        $this->db->bind(':type', $type);
        return $this->db->resultSet();
    }

    /**
     * Get a single document by its ID, including its items
     */
    public function getById($id) {
        // Get document details
        $this->db->query("
            SELECT d.*, c.name as customer_name, c.rfc, c.address
            FROM documents d
            JOIN customers c ON d.customer_id = c.id
            WHERE d.id = :id
        ");
        $this->db->bind(':id', $id);
        $document = $this->db->single();

        if ($document) {
            // Get document items
            $this->db->query("
                SELECT di.*, p.name as product_name, p.sku
                FROM document_items di
                JOIN products p ON di.product_id = p.id
                WHERE di.document_id = :id
            ");
            $this->db->bind(':id', $id);
            $document['items'] = $this->db->resultSet();
        }

        return $document;
    }

    /**
     * Create a new document (quote, order, or invoice)
     * This function uses a transaction.
     * @param array $data Contains document info (customer_id, type, etc.) and an 'items' array.
     */
    public function create($data) {
        try {
            $this->db->dbh->beginTransaction();

            // 1. Insert into documents table
            $this->db->query("
                INSERT INTO documents (customer_id, type, folio, status, cfdi_use, payment_method, payment_form, subtotal, tax, total, due_date)
                VALUES (:customer_id, :type, :folio, :status, :cfdi_use, :payment_method, :payment_form, :subtotal, :tax, :total, :due_date)
            ");

            // Generate a simple folio for now
            $folio = strtoupper(substr($data['type'], 0, 1)) . '-' . time();

            $this->db->bind(':customer_id', $data['customer_id']);
            $this->db->bind(':type', $data['type']);
            $this->db->bind(':folio', $folio);
            $this->db->bind(':status', 'draft'); // Start as draft
            $this->db->bind(':cfdi_use', $data['cfdi_use'] ?? null);
            $this->db->bind(':payment_method', $data['payment_method'] ?? null);
            $this->db->bind(':payment_form', $data['payment_form'] ?? null);
            $this->db->bind(':subtotal', $data['subtotal']);
            $this->db->bind(':tax', $data['tax']);
            $this->db->bind(':total', $data['total']);
            $this->db->bind(':due_date', $data['due_date']);

            $this->db->execute();
            $documentId = $this->db->lastInsertId();

            // 2. Insert into document_items table
            $this->db->query("
                INSERT INTO document_items (document_id, product_id, quantity, unit_price, tax, total)
                VALUES (:document_id, :product_id, :quantity, :unit_price, :tax, :total)
            ");

            foreach ($data['items'] as $item) {
                $this->db->bind(':document_id', $documentId);
                $this->db->bind(':product_id', $item['id']);
                $this->db->bind(':quantity', $item['quantity']);
                $this->db->bind(':unit_price', $item['price']);
                $this->db->bind(':tax', $item['tax']);
                $this->db->bind(':total', $item['total']);
                $this->db->execute();
            }

            $this->db->dbh->commit();
            return $documentId;

        } catch (Exception $e) {
            $this->db->dbh->rollBack();
            // In a real app, log the error
            error_log('Document creation failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Cancel a document (invoice)
     * @param int $id Document ID
     * @param string $reason Cancellation reason
     */
    public function cancel($id, $reason = 'Cancelado por el usuario.') {
        $this->db->query("UPDATE documents SET status = 'cancelled', cancellation_reason = :reason WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->bind(':reason', $reason);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Updates the status of an invoice based on its payments.
     * @param int $invoiceId
     */
    public function updatePaymentStatus($invoiceId) {
        // We need the Payment model to get the total paid amount
        require_once __DIR__ . '/Payment.php';
        $paymentModel = new Payment();

        // Get invoice total
        $invoice = $this->getById($invoiceId);
        if (!$invoice) return false;

        $totalPaid = $paymentModel->getTotalPaidForInvoice($invoiceId);

        $newStatus = $invoice['status'];
        if ($totalPaid >= $invoice['total']) {
            $newStatus = 'paid';
        } elseif ($totalPaid > 0) {
            $newStatus = 'partial'; // A new status for partially paid
        }

        // Update status if it has changed
        if ($newStatus !== $invoice['status']) {
            $this->db->query("UPDATE documents SET status = :status WHERE id = :id");
            $this->db->bind(':status', $newStatus);
            $this->db->bind(':id', $invoiceId);
            return $this->db->execute();
        }

        return true; // No update was needed, but operation is successful
    }
}
?>
