<div id="quotes-page">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4>Cotizaciones</h4>
            <p class="text-medium-emphasis">Aquí puedes administrar tus cotizaciones.</p>
        </div>
        <a href="index.php?page=quote_form" class="btn btn-primary">
            <i class="cil-plus me-2"></i>
            Crear Cotización
        </a>
    </div>

    <!-- Quotes Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="quotes-table" class="table table-striped">
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
                    <tbody id="quotes-table-body">
                        <!-- Quote rows will be inserted here by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
