<div id="orders-page">
    <h4>Órdenes de Venta</h4>
    <p>Aquí puedes administrar tus órdenes de venta.</p>

    <!-- Add Order Button -->
    <a href="index.php?page=order_form" class="btn-floating btn-large waves-effect waves-light green">
        <i class="material-icons">add</i>
    </a>

    <!-- Orders Table -->
    <table class="striped responsive-table">
        <thead>
            <tr>
                <th>Folio</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="orders-table-body">
            <!-- Order rows will be inserted here by JavaScript -->
        </tbody>
    </table>
</div>
