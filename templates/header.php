<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Facturación</title>
    <!-- Materialize CSS -->
    <link rel="stylesheet" href="assets/css/materialize.min.css">
    <!-- Google Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="assets/datatables/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="assets/datatables/buttons.dataTables.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <nav class="blue-grey darken-4">
        <div class="nav-wrapper container">
            <a href="index.php?page=dashboard" class="brand-logo">Facturación</a>
            <a href="#" data-target="mobile-nav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li><a href="index.php?page=dashboard">Dashboard</a></li>
                <li><a href="index.php?page=quotes">Cotizaciones</a></li>
                <li><a href="index.php?page=orders">Órdenes de Venta</a></li>
                <li><a href="index.php?page=invoices">Facturas</a></li>
                <li><a href="index.php?page=products">Productos</a></li>
                <li><a href="index.php?page=customers">Clientes</a></li>
                <li><a class="dropdown-trigger" href="#!" data-target="dropdown-sat-catalogs">Catálogos SAT<i class="material-icons right">arrow_drop_down</i></a></li>
                <li><a href="index.php?page=logout" class="btn red lighten-1">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Dropdown Structure -->
    <ul id="dropdown-sat-catalogs" class="dropdown-content">
        <li><a href="index.php?page=sat_catalog_view&name=sat_cfdi_uses">Uso de CFDI</a></li>
        <li><a href="index.php?page=sat_catalog_view&name=sat_payment_forms">Formas de Pago</a></li>
        <li><a href="index.php?page=sat_catalog_view&name=sat_payment_methods">Métodos de Pago</a></li>
        <li><a href="index.php?page=sat_catalog_view&name=sat_units">Unidades de Medida</a></li>
    </ul>

    <ul class="sidenav" id="mobile-nav">
        <li><a href="index.php?page=dashboard">Dashboard</a></li>
        <li><a href="index.php?page=quotes">Cotizaciones</a></li>
        <li><a href="index.php?page=orders">Órdenes de Venta</a></li>
        <li><a href="index.php?page=invoices">Facturas</a></li>
        <li><a href="index.php?page=products">Productos</a></li>
        <li><a href="index.php?page=customers">Clientes</a></li>
        <li class="divider"></li>
        <li><a class="subheader">Catálogos del SAT</a></li>
        <li><a href="index.php?page=sat_catalog_view&name=sat_cfdi_uses">Uso de CFDI</a></li>
        <li><a href="index.php?page=sat_catalog_view&name=sat_payment_forms">Formas de Pago</a></li>
        <li><a href="index.php?page=sat_catalog_view&name=sat_payment_methods">Métodos de Pago</a></li>
        <li><a href="index.php?page=sat_catalog_view&name=sat_units">Unidades de Medida</a></li>
        <li class="divider"></li>
        <li><a href="index.php?page=logout">Cerrar Sesión</a></li>
    </ul>
</header>

<main class="container">
