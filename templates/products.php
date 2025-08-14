<div id="products-page">
    <h4>Gestión de Productos</h4>
    <p>Aquí puedes administrar tus productos o servicios.</p>

    <!-- Add Product Button -->
    <a class="btn-floating btn-large waves-effect waves-light red modal-trigger" href="#modal-product"><i class="material-icons">add</i></a>

    <!-- Products Table -->
    <table id="products-table" class="striped responsive-table">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Clave SAT</th>
                <th>Nombre (Descripción)</th>
                <th>Unidad</th>
                <th>Precio Unitario</th>
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
                <div class="row">
                    <div class="input-field col s6">
                        <input id="product-sku" type="text" name="sku" required maxlength="10">
                        <label for="product-sku">SKU (Código Interno)</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="product-sat-key" type="text" name="sat_product_key" required pattern="[0-9]{1,8}" title="Hasta 8 dígitos numéricos.">
                        <label for="product-sat-key">Clave de Producto/Servicio (SAT)</label>
                    </div>
                </div>
                <div class="input-field">
                    <input id="product-name" type="text" name="name" required>
                    <label for="product-name">Nombre (Descripción)</label>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <input type="text" id="unit-key-search" placeholder="Buscar unidad...">
                        <select id="product-sat-unit-key" name="sat_unit_key" required>
                            <option value="" disabled selected>Cargando...</option>
                        </select>
                        <label for="product-sat-unit-key">Unidad de Medida (SAT)</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="product-price" type="number" step="0.01" name="price" required>
                        <label for="product-price">Precio Unitario</label>
                    </div>
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
