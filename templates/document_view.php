<div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Documento <span id="view-folio"></span></h4>
                <p class="mb-0"><strong>Estado:</strong> <span class="badge bg-primary" id="view-status"></span></p>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Fecha de Emisión:</strong> <span id="view-created-at"></span></p>
                    <p><strong>Fecha de Vencimiento:</strong> <span id="view-due-date"></span></p>
                </div>
            </div>
            <hr>
            <div class="row my-4">
                <div class="col-md-6">
                    <h5>Cliente:</h5>
                    <p id="view-customer-name"></p>
                    <p id="view-customer-rfc"></p>
                    <p id="view-customer-address"></p>
                </div>
                <div class="col-md-6" id="fiscal-data-section">
                     <h5>Datos Fiscales:</h5>
                     <p><strong>Uso de CFDI:</strong> <span id="view-cfdi-use"></span></p>
                     <p><strong>Forma de Pago:</strong> <span id="view-payment-form"></span></p>
                     <p><strong>Folio Fiscal (UUID):</strong> <span id="view-uuid">N/A</span></p>
                </div>
            </div>

            <h5>Productos</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Descripción</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Precio Unit.</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody id="view-items-table-body">
                        <!-- Items will be inserted here by JS -->
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-end mt-4">
                <div class="col-md-5">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Subtotal: <strong id="view-subtotal">$0.00</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            IVA: <strong id="view-tax">$0.00</strong>
                        </li>
                        <li class="list-group-item list-group-item-dark d-flex justify-content-between align-items-center">
                            <h5>Total:</h5> <h5 id="view-total">$0.00</h5>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="#" class="btn btn-secondary" id="back-to-list-btn">Volver a la lista</a>
            <!-- Generate Buttons -->
            <a href="#" class="btn btn-info" id="generate-order-btn" style="display: none;">Generar Orden</a>
            <a href="#" class="btn btn-info" id="generate-invoice-btn" style="display: none;">Generar Factura</a>
            <!-- Action Buttons -->
            <a href="#" class="btn btn-danger" id="cancel-invoice-btn">Cancelar</a>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-payment" id="record-payment-btn" style="display: none;">Registrar Pago</button>
        </div>
    </div>

    <!-- Payments Section -->
    <div class="card mt-4">
        <div class="card-header">
            <h5>Historial de Pagos</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th>Método</th>
                            <th>Referencia</th>
                        </tr>
                    </thead>
                    <tbody id="payments-history-body">
                        <tr><td colspan="4">No se han registrado pagos.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Payment Modal -->
<div class="modal fade" id="modal-payment" tabindex="-1" aria-labelledby="modal-payment-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-payment">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-payment-title-h5">Registrar Pago</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="payment-invoice-id" name="invoice_id">
                    <div class="mb-3">
                        <label for="payment-amount" class="form-label">Monto del Pago</label>
                        <input type="number" class="form-control" id="payment-amount" name="amount" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="payment-date" class="form-label">Fecha del Pago</label>
                        <input type="date" class="form-control" id="payment-date" name="payment_date" required>
                    </div>
                     <div class="mb-3">
                        <label for="payment-method" class="form-label">Método de Pago</label>
                        <select class="form-select" id="payment-method" name="payment_method" required>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia Electrónica</option>
                            <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                            <option value="Tarjeta de Débito">Tarjeta de Débito</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="payment-reference" class="form-label">Referencia o Nota</label>
                        <input type="text" class="form-control" id="payment-reference" name="reference">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="submit" form="form-payment">Guardar Pago</button>
                </div>
            </form>
        </div>
    </div>
</div>
