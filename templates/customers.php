<div id="customers-page">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4>Gestión de Clientes</h4>
            <p class="text-medium-emphasis">Aquí puedes administrar tus clientes.</p>
        </div>
        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal-customer">
            <i class="cil-plus me-2"></i>
            Agregar Cliente
        </button>
    </div>

    <!-- Customers Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="customers-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre (Razón Social)</th>
                            <th>RFC</th>
                            <th>Email</th>
                            <th>Dirección</th>
                            <th>C.P.</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="customers-table-body">
                        <!-- Customer rows will be inserted here by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add/Edit Customer Modal -->
    <div class="modal fade" id="modal-customer" tabindex="-1" aria-labelledby="modal-customer-title" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form-customer">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-customer-title-h5">Agregar Cliente</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="customer-id" name="id">
                        <div class="mb-3">
                            <label for="customer-name" class="form-label">Nombre (Razón Social)</label>
                            <input id="customer-name" class="form-control" type="text" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer-rfc" class="form-label">RFC</label>
                            <input id="customer-rfc" class="form-control" type="text" name="rfc" required maxlength="13" pattern="^(([ÑA-Z|ña-z|&]{3}|[A-Z|a-z]{4})\\d{2}((0[1-9]|1[012])(0[1-9]|1\\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)(\\w{2})([A|a|0-9]{1}))$|^(([ÑA-Z|ña-z|&]{3}|[A-Z|a-z]{4})([02468][048]|[13579][26])0229)(\\w{2})([A|a|0-9]{1})$" title="Ingrese un RFC válido.">
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="customer-street-address" class="form-label">Calle y Número</label>
                                <input id="customer-street-address" class="form-control" type="text" name="street_address" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="customer-postal-code" class="form-label">Código Postal</label>
                                <input id="customer-postal-code" class="form-control" type="text" name="postal_code" required pattern="[0-9]{5}" title="5 dígitos numéricos." maxlength="5">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="customer-neighborhood" class="form-label">Colonia</label>
                            <select id="customer-neighborhood" class="form-select" name="neighborhood" required>
                                <option value="" disabled selected>Ingresa un C.P. para cargar colonias</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer-city" class="form-label">Ciudad / Municipio</label>
                                <input id="customer-city" class="form-control" type="text" name="city" required readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="customer-state" class="form-label">Estado</label>
                                <input id="customer-state" class="form-control" type="text" name="state" required readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="customer-email" class="form-label">Email</label>
                            <input id="customer-email" class="form-control" type="email" name="email" required pattern="[a-z0-9._%+\\-]+@[a-z0-9.\\-]+\\.[a-z]{2,}" title="Ingrese una dirección de correo válida.">
                        </div>
                        <div class="mb-3">
                            <label for="customer-phone" class="form-label">Teléfono</label>
                            <input id="customer-phone" class="form-control" type="tel" name="phone" pattern="[0-9]{10}" title="10 dígitos numéricos.">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit" form="form-customer">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
