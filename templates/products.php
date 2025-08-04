<div id="products-page">
    <h4>Gestión de Productos</h4>
    <p>Aquí puedes administrar tus productos o servicios.</p>

    <!-- Add Product Button -->
    <a class="btn-floating btn-large waves-effect waves-light red modal-trigger" href="#modal-product"><i class="material-icons">add</i></a>

    <!-- Products Table -->
    <table id="products-table" class="striped responsive-table">
        <thead>
            <tr>
                <th>SKU (Clave SAT)</th>
                <th>Nombre (Descripción)</th>
                <th>Precio Unitario</th>
                <th>Tasa de Impuesto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="products-table-body">
            <!-- Product rows will be inserted here by JavaScript -->
        </tbody>
    </table>

    <!-- Add/Edit Product Modal -->
    <div id="modal-product" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4 id="modal-product-title">Agregar Producto</h4>
            <form id="form-product">
                <input type="hidden" id="product-id" name="id">
                <div class="input-field">
                    <input id="product-sku" type="text" name="sku" required>
                    <label for="product-sku">SKU (Clave Producto/Servicio)</label>
                </div>
                <div class="input-field">
                    <input id="product-name" type="text" name="name" required>
                    <label for="product-name">Nombre (Descripción)</label>
                </div>
                <div class="input-field">
                    <input id="product-unit-key" type="text" name="unit_key" required>
                    <label for="product-unit-key">Clave de Unidad (SAT)</label>
                </div>
                <div class="input-field">
                    <input id="product-price" type="number" step="0.01" name="price" required>
                    <label for="product-price">Precio Unitario</label>
                </div>
                <div class="input-field">
                    <input id="product-tax-rate" type="number" step="0.01" name="tax_rate" required value="0.16">
                    <label for="product-tax-rate">Tasa de Impuesto (ej. 0.16)</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
            <button type="submit" form="form-product" class="btn waves-effect waves-light">Guardar</button>
        </div>
    </div>
</div>
