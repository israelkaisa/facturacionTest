<div id="invoice-view-page">
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <div class="invoice-header row">
                        <div class="col s12 m6">
                            <h4>Factura <span id="view-folio"></span></h4>
                            <p><strong>Estado:</strong> <span class="new badge" id="view-status"></span></p>
                        </div>
                        <div class="col s12 m6 right-align">
                            <p><strong>Fecha de Emisión:</strong> <span id="view-created-at"></span></p>
                            <p><strong>Fecha de Vencimiento:</strong> <span id="view-due-date"></span></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col s12 m6">
                            <h5>Cliente:</h5>
                            <p id="view-customer-name"></p>
                            <p id="view-customer-rfc"></p>
                            <p id="view-customer-address"></p>
                        </div>
                        <div class="col s12 m6">
                             <h5>Datos Fiscales:</h5>
                             <p><strong>Uso de CFDI:</strong> <span id="view-cfdi-use"></span></p>
                             <p><strong>Método de Pago:</strong> <span id="view-payment-method"></span></p>
                             <p><strong>Folio Fiscal (UUID):</strong> <span id="view-uuid">N/A</span></p>
                        </div>
                    </div>

                    <h5>Productos</h5>
                    <table class="striped">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Descripción</th>
                                <th class="center-align">Cantidad</th>
                                <th class="right-align">Precio Unit.</th>
                                <th class="right-align">Total</th>
                            </tr>
                        </thead>
                        <tbody id="view-items-table-body">
                            <!-- Items will be inserted here by JS -->
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col s12 m6 offset-m6">
                            <ul class="collection">
                                <li class="collection-item"><h6>Subtotal: <span class="right" id="view-subtotal">$0.00</span></h6></li>
                                <li class="collection-item"><h6>IVA: <span class="right" id="view-tax">$0.00</span></h6></li>
                                <li class="collection-item active"><h5>Total: <span class="right" id="view-total">$0.00</span></h5></li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="card-action">
                    <a href="index.php?page=invoices" class="btn grey">Volver a la lista</a>
                    <a href="#" class="btn red" id="cancel-invoice-btn">Cancelar Factura</a>
                    <a href="#modal-payment" class="btn green modal-trigger" id="record-payment-btn">Registrar Pago</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments Section (to be implemented later) -->
    <div class="card">
        <div class="card-content">
            <h5>Historial de Pagos</h5>
            <table class="striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Método</th>
                        <th>Referencia</th>
                    </tr>
                </thead>
                <tbody id="payments-history-body">
                    <!-- Payments will be listed here -->
                    <tr><td colspan="4">No se han registrado pagos.</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Payment Modal (to be implemented later) -->
<div id="modal-payment" class="modal">
    <div class="modal-content">
        <h4>Registrar Pago</h4>
        <form id="form-payment">
            <input type="hidden" id="payment-invoice-id" name="invoice_id">
            <div class="input-field">
                <input type="number" id="payment-amount" name="amount" step="0.01" required>
                <label for="payment-amount">Monto del Pago</label>
            </div>
            <div class="input-field">
                <input type="text" class="datepicker" id="payment-date" name="payment_date" required>
                <label for="payment-date">Fecha del Pago</label>
            </div>
             <div class="input-field">
                <select id="payment-method" name="payment_method" required>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Transferencia">Transferencia Electrónica</option>
                    <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                    <option value="Tarjeta de Débito">Tarjeta de Débito</option>
                    <option value="Otro">Otro</option>
                </select>
                <label>Método de Pago</label>
            </div>
            <div class="input-field">
                <input type="text" id="payment-reference" name="reference">
                <label for="payment-reference">Referencia o Nota</label>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
        <button type="submit" form="form-payment" class="btn waves-effect waves-light">Guardar Pago</button>
    </div>
</div>
