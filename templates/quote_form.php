<div id="quote-form-page">
    <h4>Crear Nueva Cotización</h4>
    <div class="card">
        <div class="card-content">
            <form id="form-quote">
                <!-- Document Header -->
                <div class="row">
                    <div class="input-field col s12 m6">
                        <select id="quote-customer" name="customer_id" required>
                            <option value="" disabled selected>Selecciona un cliente</option>
                            <!-- Customer options will be populated by JS -->
                        </select>
                        <label>Cliente</label>
                    </div>
                    <div class="input-field col s6 m3">
                        <input type="text" class="datepicker" id="quote-date" name="date" required>
                        <label for="quote-date">Fecha de Emisión</label>
                    </div>
                    <div class="input-field col s6 m3">
                        <input type="text" class="datepicker" id="quote-due-date" name="due_date" required>
                        <label for="quote-due-date">Válido Hasta</label>
                    </div>
                </div>
                <!-- CFDI fields are not typically in quotes, so I'll omit them for now -->

                <hr>
                <h5>Productos</h5>

                <!-- Item Lines -->
                <div id="quote-items">
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
                            <li class="collection-item"><h6>Subtotal: <span class="right" id="quote-subtotal">$0.00</span></h6></li>
                            <li class="collection-item"><h6>IVA (16%): <span class="right" id="quote-tax">$0.00</span></h6></li>
                            <li class="collection-item active"><h5>Total: <span class="right" id="quote-total">$0.00</span></h5></li>
                        </ul>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="row">
                    <div class="col s12">
                        <button type="submit" class="btn btn-large waves-effect waves-light right">Guardar Cotización</button>
                        <a href="index.php?page=quotes" class="btn-large waves-effect waves-light grey right" style="margin-right: 10px;">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Template for a single item row (can be reused, but let's give it a unique id for clarity) -->
<template id="quote-item-template">
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
