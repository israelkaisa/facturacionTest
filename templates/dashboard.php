<div id="dashboard-page">
    <h4>Resumen General</h4>
    <p>Una vista rápida de la actividad de tu negocio.</p>

    <!-- Stat Cards -->
    <div class="row">
        <div class="col s12 m6 l6">
            <div class="card-panel teal lighten-1 hoverable">
                <div class="white-text">
                    <div class="valign-wrapper">
                        <i class="material-icons medium left">people</i>
                        <div>
                            <h5>Clientes Totales</h5>
                            <h3 id="customer-count-stat" class="count-stat">...</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="card-panel blue lighten-1 hoverable">
                <div class="white-text">
                    <div class="valign-wrapper">
                        <i class="material-icons medium left">inventory_2</i>
                        <div>
                            <h5>Productos Totales</h5>
                            <h3 id="product-count-stat" class="count-stat">...</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Documents -->
    <div class="card">
        <div class="card-content">
            <span class="card-title">Documentos Recientes</span>
            <table id="recent-documents-table" class="striped responsive-table">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Tipo</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody id="recent-documents-body">
                    <!-- JS will populate this -->
                    <tr>
                        <td colspan="6" class="center-align" id="loading-docs-row">
                            <div class="preloader-wrapper small active">
                                <div class="spinner-layer spinner-blue-only">
                                    <div class="circle-clipper left">
                                        <div class="circle"></div>
                                    </div><div class="gap-patch">
                                        <div class="circle"></div>
                                    </div><div class="circle-clipper right">
                                        <div class="circle"></div>
                                    </div>
                                </div>
                            </div>
                            <span class="valign">Cargando documentos...</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
