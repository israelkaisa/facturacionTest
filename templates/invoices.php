<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4>Facturas</h4>
            <p class="text-medium-emphasis">Aquí puedes administrar tus facturas.</p>
        </div>
        <a href="index.php?page=invoice_form" class="btn btn-primary">
            <i class="cil-plus me-2"></i>
            Crear Factura
        </a>
    </div>

    <!-- Invoices Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="invoices-table" class="table table-striped">
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
        </div>
    </div>
</div>
