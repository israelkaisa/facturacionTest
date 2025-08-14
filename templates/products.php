<div id="products-page">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4>Gestión de Productos</h4>
            <p class="text-medium-emphasis">Aquí puedes administrar tus productos o servicios.</p>
        </div>
        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal-product">
            <i class="cil-plus me-2"></i>
            Agregar Producto
        </button>
    </div>

    <!-- Products Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="products-table" class="table table-striped">
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
            </div>
        </div>
    </div>

    <!-- Add/Edit Product Modal -->
    <div class="modal fade" id="modal-product" tabindex="-1" aria-labelledby="modal-product-title" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form-product">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-product-title-h5">Agregar Producto</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="product-id" name="id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="product-sku" class="form-label">SKU (Código Interno)</label>
                                <input id="product-sku" class="form-control" type="text" name="sku" required maxlength="10">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="product-sat-key" class="form-label">Clave de Producto/Servicio (SAT)</label>
                                <input id="product-sat-key" class="form-control" type="text" name="sat_product_key" required pattern="[0-9]{1,8}" title="Hasta 8 dígitos numéricos.">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="product-name" class="form-label">Nombre (Descripción)</label>
                            <input id="product-name" class="form-control" type="text" name="name" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="product-sat-unit-key" class="form-label">Unidad de Medida (SAT)</label>
                                <input type="text" id="unit-key-search" class="form-control mb-2" placeholder="Buscar unidad...">
                                <select id="product-sat-unit-key" class="form-select" name="sat_unit_key" required>
                                    <option value="" disabled selected>Cargando...</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="product-price" class="form-label">Precio Unitario</label>
                                <input id="product-price" class="form-control" type="number" step="0.01" name="price" required>
                            </div>
                        </div>
                         <div class="mb-3">
                            <label for="product-tax-rate" class="form-label">Tasa de Impuesto (ej. 0.16)</label>
                            <input id="product-tax-rate" class="form-control" type="number" step="0.01" name="tax_rate" required value="0.16">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit" form="form-product">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
