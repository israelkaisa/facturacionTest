<div id="customers-page">
    <h4>Gestión de Clientes</h4>
    <p>Aquí puedes administrar tus clientes.</p>

    <!-- Add Customer Button -->
    <a class="btn-floating btn-large waves-effect waves-light red modal-trigger" href="#modal-customer"><i class="material-icons">add</i></a>

    <!-- Customers Table -->
    <table id="customers-table" class="striped responsive-table">
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

    <!-- Add/Edit Customer Modal -->
    <div id="modal-customer" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4 id="modal-customer-title">Agregar Cliente</h4>
            <form id="form-customer">
                <input type="hidden" id="customer-id" name="id">
                <div class="input-field">
                    <input id="customer-name" type="text" name="name" required>
                    <label for="customer-name">Nombre (Razón Social)</label>
                </div>
                <div class="input-field">
                    <input id="customer-rfc" type="text" name="rfc" required maxlength="13" pattern="^(([ÑA-Z|ña-z|&]{3}|[A-Z|a-z]{4})\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)(\w{2})([A|a|0-9]{1}))$|^(([ÑA-Z|ña-z|&]{3}|[A-Z|a-z]{4})([02468][048]|[13579][26])0229)(\w{2})([A|a|0-9]{1})$" title="Ingrese un RFC válido.">
                    <label for="customer-rfc">RFC</label>
                </div>
                <div class="input-field">
                    <textarea id="customer-address" name="address" class="materialize-textarea" required></textarea>
                    <label for="customer-address">Dirección Fiscal</label>
                </div>
                <div class="input-field">
                    <input id="customer-postal-code" type="text" name="postal_code" required pattern="[0-9]{5,6}" title="5 a 6 dígitos numéricos.">
                    <label for="customer-postal-code">Código Postal</label>
                </div>
                <div class="input-field">
                    <input id="customer-email" type="email" name="email" required pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}" title="Ingrese una dirección de correo válida.">
                    <label for="customer-email">Email</label>
                </div>
                <div class="input-field">
                    <input id="customer-phone" type="tel" name="phone" pattern="[0-9]{10}" title="10 dígitos numéricos.">
                    <label for="customer-phone">Teléfono</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
            <button type="submit" form="form-customer" class="btn waves-effect waves-light">Guardar</button>
        </div>
    </div>
</div>
