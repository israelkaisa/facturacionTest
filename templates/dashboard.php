<div>
    <h4 class="mb-4">Resumen General</h4>
    <p class="text-medium-emphasis">Una vista rápida de la actividad de tu negocio.</p>

    <!-- Stat Cards -->
    <div class="row">
        <div class="col-md-6">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="cil-people me-3" style="font-size: 3rem;"></i>
                        <div>
                            <div class="text-medium-emphasis text-uppercase fw-semibold">Clientes Totales</div>
                            <div id="customer-count-stat" class="fs-4 fw-semibold">...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-primary mb-3">
                 <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="cil-devices me-3" style="font-size: 3rem;"></i>
                        <div>
                            <div class="text-medium-emphasis text-uppercase fw-semibold">Productos Totales</div>
                            <div id="product-count-stat" class="fs-4 fw-semibold">...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Documents -->
    <div class="card mt-4">
        <div class="card-header">
            <strong>Documentos Recientes</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="recent-documents-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Tipo</th>
                            <th>Cliente</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="recent-documents-body">
                        <!-- JS will populate this -->
                        <tr>
                            <td colspan="6" class="text-center" id="loading-docs-row">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                                <span class="ms-2">Cargando documentos...</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
