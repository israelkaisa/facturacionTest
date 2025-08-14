<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Facturación - CoreUI</title>
    <!-- CoreUI CSS -->
    <link rel="stylesheet" href="assets/coreui/css/coreui.min.css">
    <!-- CoreUI Icons -->
    <link rel="stylesheet" href="assets/coreui/css/coreui-icons.min.css">
    <!-- TomSelect CSS -->
    <link rel="stylesheet" href="assets/tom-select/css/tom-select.default.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="assets/datatables/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="assets/datatables/buttons.dataTables.min.css">
    <!-- A generic style for the body -->
    <style>
      body {
        background-color: #f0f2f5;
      }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <i class="cil-wallet sidebar-brand-full" width="118" height="46"></i>
        <span class="ms-2">Facturación</span>
        <i class="cil-wallet sidebar-brand-narrow" width="46" height="46"></i>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
            <a class="nav-link" href="index.php?page=dashboard">
                <i class="nav-icon cil-speedometer"></i> Dashboard
            </a>
        </li>
        <li class="nav-title">Documentos</li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?page=quotes">
                <i class="nav-icon cil-description"></i> Cotizaciones
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?page=orders">
                <i class="nav-icon cil-basket"></i> Órdenes de Venta
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?page=invoices">
                <i class="nav-icon cil-notes"></i> Facturas
            </a>
        </li>
        <li class="nav-title">Gestión</li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?page=products">
                <i class="nav-icon cil-devices"></i> Productos
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?page=customers">
                <i class="nav-icon cil-people"></i> Clientes
            </a>
        </li>
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <i class="nav-icon cil-puzzle"></i> Catálogos SAT
            </a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="index.php?page=sat_catalog_view&name=sat_cfdi_uses"><span class="nav-icon"></span> Uso de CFDI</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=sat_catalog_view&name=sat_payment_forms"><span class="nav-icon"></span> Formas de Pago</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=sat_catalog_view&name=sat_payment_methods"><span class="nav-icon"></span> Métodos de Pago</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=sat_catalog_view&name=sat_units"><span class="nav-icon"></span> Unidades</a></li>
            </ul>
        </li>
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>

<!-- Main Content -->
<div class="wrapper d-flex flex-column min-vh-100 bg-light">
    <header class="header header-sticky mb-4">
        <div class="container-fluid">
            <button class="header-toggler px-md-4 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                <i class="cil-menu"></i>
            </button>
            <ul class="header-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=logout">
                        <i class="cil-account-logout"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </header>
    <div class="body flex-grow-1 px-3">
        <div class="container-lg">
            <!-- The main content from other PHP files will be injected here -->
