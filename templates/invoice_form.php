<div id="invoice-form-page">
    <h4>Crear Nueva Factura</h4>
    <div class="card">
        <div class="card-content">
            <form id="form-invoice">
                <input type="hidden" id="invoice-source-folio" name="source_folio">
                <!-- Document Header -->
                <div class="row">
                    <div class="input-field col s12 m6">
                        <select id="invoice-customer" name="customer_id" required>
                            <option value="" disabled selected>Selecciona un cliente</option>
                            <!-- Customer options will be populated by JS -->
                        </select>
                        <label>Cliente</label>
                    </div>
                    <div class="input-field col s6 m3">
                        <input type="text" class="datepicker" id="invoice-date" name="date" required>
                        <label for="invoice-date">Fecha de Emisión</label>
                    </div>
                    <div class="input-field col s6 m3">
                        <input type="text" class="datepicker" id="invoice-due-date" name="due_date" required>
                        <label for="invoice-due-date">Fecha de Vencimiento</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input type="text" id="cfdi-use-search" placeholder="Buscar Uso de CFDI...">
                        <select id="invoice-cfdi-use" name="cfdi_use" required>
                             <!-- Options will be populated by JS -->
                        </select>
                        <label>Uso de CFDI</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input type="text" id="payment-form-search" placeholder="Buscar Forma de Pago...">
                        <select id="invoice-payment-form" name="payment_form" required>
                           <!-- Options will be populated by JS -->
                        </select>
                        <label>Forma de Pago</label>
                    </div>
                </div>

                <hr>
                <h5>Productos</h5>

                <!-- Item Lines -->
                <div id="invoice-items">
                    <!-- Item rows will be added here by JS -->
                </div>

                <!-- Add Item Button -->
                <div class="row">
                    <div class="col s12">
                         <a class="btn waves-effect waves-light" id="add-item-btn"><i class="material-icons left">add</i>Agregar Producto</a>
                    </div>
                </div>

                <hr>

                <!-- Totals -->
                <div class="row">
                    <div class="col s12 m6 offset-m6">
                        <ul class="collection">
                            <li class="collection-item"><h6>Subtotal: <span class="right" id="invoice-subtotal">$0.00</span></h6></li>
                            <li class="collection-item"><h6>IVA (16%): <span class="right" id="invoice-tax">$0.00</span></h6></li>
                            <li class="collection-item active"><h5>Total: <span class="right" id="invoice-total">$0.00</span></h5></li>
                        </ul>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="row">
                    <div class="col s12">
                        <button type="submit" class="btn btn-large waves-effect waves-light right">Guardar Factura</button>
                        <a href="index.php?page=invoices" class="btn-large waves-effect waves-light grey right" style="margin-right: 10px;">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Template for a single item row -->
<template id="invoice-item-template">
    <div class="row item-row">
        <div class="col s12 m5">
            <select class="product-select" name="product_id[]" required>
                <option value="" disabled selected>Selecciona un producto</option>
                <!-- Product options will be populated by JS -->
            </select>
        </div>
        <div class="col s6 m2">
            <input type="number" class="quantity" name="quantity[]" value="1" min="1" required>
            <label>Cantidad</label>
        </div>
        <div class="col s6 m2">
            <input type="text" class="price" name="price[]" readonly>
            <label>Precio</label>
        </div>
        <div class="col s10 m2">
            <input type="text" class="total" name="total[]" readonly>
            <label>Total</label>
        </div>
        <div class="col s2 m1">
            <a href="#!" class="btn-floating red remove-item-btn"><i class="material-icons">remove</i></a>
        </div>
    </div>
</template>
