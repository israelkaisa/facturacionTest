<div>
    <h4>Crear Nueva Orden de Venta</h4>
    <div class="card mt-4">
        <div class="card-body">
            <form id="form-order">
                <input type="hidden" id="order-source-folio" name="source_folio">
                <!-- Document Header -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="order-customer" class="form-label">Cliente</label>
                        <select id="order-customer" class="form-select" name="customer_id" required>
                            <option value="" disabled selected>Selecciona un cliente</option>
                            <!-- Customer options will be populated by JS -->
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="order-date" class="form-label">Fecha de Emisión</label>
                        <input type="date" class="form-control" id="order-date" name="date" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="order-due-date" class="form-label">Fecha de Entrega</label>
                        <input type="date" class="form-control" id="order-due-date" name="due_date" required>
                    </div>
                </div>

                <hr class="my-4">
                <h5>Productos</h5>

                <!-- Item Lines -->
                <div id="order-items">
                    <!-- Item rows will be added here by JS -->
                </div>

                <!-- Add Item Button -->
                <div class="row mt-3">
                    <div class="col-12">
                         <button type="button" class="btn btn-outline-primary" id="add-item-btn"><i class="cil-plus me-2"></i>Agregar Producto</button>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Totals -->
                <div class="row justify-content-end">
                    <div class="col-md-5">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Subtotal: <strong id="order-subtotal">$0.00</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                IVA (16%): <strong id="order-tax">$0.00</strong>
                            </li>
                            <li class="list-group-item list-group-item-dark d-flex justify-content-between align-items-center">
                                <h5>Total:</h5> <h5 id="order-total">$0.00</h5>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end mt-4">
                    <a href="index.php?page=orders" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Orden</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Template for a single item row -->
<template id="order-item-template">
    <div class="row align-items-center item-row mb-3">
        <div class="col-md-5">
            <label class="form-label">Producto</label>
            <select class="form-select product-select" name="product_id[]" required>
                <option value="" disabled selected>Selecciona un producto</option>
                <!-- Product options will be populated by JS -->
            </select>
        </div>
        <div class="col-md-2">
             <label class="form-label">Cantidad</label>
            <input type="number" class="form-control quantity" name="quantity[]" value="1" min="1" required>
        </div>
        <div class="col-md-2">
             <label class="form-label">Precio</label>
            <input type="text" class="form-control price" name="price[]" readonly>
        </div>
        <div class="col-md-2">
             <label class="form-label">Total</label>
            <input type="text" class="form-control total" name="total[]" readonly>
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <button type="button" class="btn btn-danger remove-item-btn"><i class="cil-trash"></i></button>
        </div>
    </div>
</template>
