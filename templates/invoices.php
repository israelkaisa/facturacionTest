<div id="invoices-page">
    <h4>Facturas</h4>
    <p>Aquí puedes administrar tus facturas.</p>

    <!-- Add Invoice Button -->
    <a href="index.php?page=invoice_form" class="btn-floating btn-large waves-effect waves-light red">
        <i class="material-icons">add</i>
    </a>

    <!-- Invoices Table -->
    <table class="striped responsive-table">
        <thead>
            <tr>
                <th>Folio</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="invoices-table-body">
            <!-- Invoice rows will be inserted here by JavaScript -->
        </tbody>
    </table>
</div>
