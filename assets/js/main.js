const API_BASE_URL = 'api/';

/**
 * Creates and displays a Bootstrap/CoreUI toast notification.
 * @param {string} message - The message to display.
 * @param {string} type - The type of toast ('success', 'error', 'warning').
 */
function showToast(message, type = 'success') {
    const toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) return;

    let bgClass = 'bg-success';
    if (type === 'error') bgClass = 'bg-danger';
    if (type === 'warning') bgClass = 'bg-warning';

    const toastEl = document.createElement('div');
    toastEl.classList.add('toast', bgClass, 'text-white');
    toastEl.setAttribute('role', 'alert');
    toastEl.setAttribute('aria-live', 'assertive');
    toastEl.setAttribute('aria-atomic', 'true');
    toastEl.innerHTML = `
        <div class="toast-body">${message}</div>
    `;

    toastContainer.appendChild(toastEl);

    const toast = new coreui.Toast(toastEl, {
        delay: 5000
    });
    toast.show();

    // Remove the toast from DOM after it's hidden
    toastEl.addEventListener('hidden.coreui.toast', () => {
        toastEl.remove();
    });
}


document.addEventListener('DOMContentLoaded', function() {
    // Page-specific handlers
    const pageId = document.body.querySelector('div[id$="-page"]')?.id;

    if (document.getElementById('customers-page')) handleCustomersPage();
    if (document.getElementById('products-page')) handleProductsPage();
    if (document.getElementById('sat-catalog-page')) handleSatCatalogPage();
    if (document.getElementById('invoices-page')) handleInvoicesPage();
    if (document.getElementById('invoice-form-page')) handleDocumentFormPage('invoice');
    if (document.getElementById('quotes-page')) handleQuotesPage();
    if (document.getElementById('quote-form-page')) handleDocumentFormPage('quote');
    if (document.getElementById('orders-page')) handleOrdersPage();
    if (document.getElementById('order-form-page')) handleDocumentFormPage('order');
    if (document.getElementById('document-view-page')) handleDocumentViewPage();
    if (document.getElementById('dashboard-page')) handleDashboardPage();
});

// --- Page Handlers ---

function handleDashboardPage() {
    const apiUrl = `${API_BASE_URL}dashboard.php`;
    const customerCountEl = document.getElementById('customer-count-stat');
    const productCountEl = document.getElementById('product-count-stat');
    const recentDocsBody = document.getElementById('recent-documents-body');
    const loadingRow = document.getElementById('loading-docs-row');

    fetch(apiUrl)
        .then(response => {
            if (response.status === 401) {
                showToast('Sesión expirada. Redirigiendo al login.', 'error');
                setTimeout(() => window.location.href = 'index.php?page=login', 2000);
                throw new Error('Unauthorized');
            }
            return response.json();
        })
        .then(result => {
            if (result.status === 'success') {
                const data = result.data;
                customerCountEl.textContent = data.customer_count;
                productCountEl.textContent = data.product_count;

                if (data.recent_documents && data.recent_documents.length > 0) {
                    recentDocsBody.innerHTML = data.recent_documents.map(doc => {
                        let statusClass = 'bg-secondary';
                        switch (doc.status) {
                            case 'paid': case 'completed': statusClass = 'bg-success'; break;
                            case 'cancelled': statusClass = 'bg-danger'; break;
                            case 'sent': case 'pending': statusClass = 'bg-info'; break;
                            case 'draft': statusClass = 'bg-light text-dark'; break;
                        }
                        return `
                            <tr>
                                <td><a href="index.php?page=document_view&id=${doc.id}">${doc.folio}</a></td>
                                <td>${doc.type.charAt(0).toUpperCase() + doc.type.slice(1)}</td>
                                <td>${doc.customer_name}</td>
                                <td><span class="badge ${statusClass}">${doc.status}</span></td>
                                <td class="text-end">$${parseFloat(doc.total).toFixed(2)}</td>
                                <td>${new Date(doc.created_at).toLocaleDateString()}</td>
                            </tr>
                        `;
                    }).join('');
                } else {
                    loadingRow.innerHTML = '<td colspan="6" class="text-center">No hay documentos recientes.</td>';
                }
            } else {
                throw new Error(result.message);
            }
        })
        .catch(error => {
            if (error.message !== 'Unauthorized') {
                console.error('Error fetching dashboard data:', error);
                showToast(`Error al cargar el dashboard: ${error.message}`, 'error');
                customerCountEl.textContent = 'Error';
                productCountEl.textContent = 'Error';
                if(loadingRow) loadingRow.innerHTML = '<td colspan="6" class="text-center">Error al cargar documentos.</td>';
            }
        });
}

function handleSatCatalogPage() {
    const urlParams = new URLSearchParams(window.location.search);
    const catalogName = urlParams.get('name');
    const titleEl = document.getElementById('catalog-title');
    const tableBody = document.getElementById('catalog-table-body');
    const catalogTitles = {
        'sat_cfdi_uses': 'Catálogo de Uso de CFDI',
        'sat_payment_forms': 'Catálogo de Formas de Pago',
        'sat_payment_methods': 'Catálogo de Métodos de Pago',
        'sat_units': 'Catálogo de Unidades de Medida'
    };

    if (!catalogName || !catalogTitles[catalogName]) {
        titleEl.textContent = 'Catálogo no válido';
        return;
    }
    titleEl.textContent = catalogTitles[catalogName];

    fetch(`${API_BASE_URL}sat_catalogs.php`)
        .then(res => res.json())
        .then(result => {
            if (result.status === 'success') {
                const keyName = catalogName.replace('sat_', '');
                const catalogData = result.data[keyName];
                if (catalogData) {
                    const tableRows = Object.entries(catalogData).map(([key, value]) => `<tr><td>${key}</td><td>${value}</td></tr>`).join('');
                    tableBody.innerHTML = tableRows;
                    initializeDataTable('#catalog-table', catalogTitles[catalogName]);
                } else {
                    tableBody.innerHTML = `<tr><td colspan="2">No se encontraron datos.</td></tr>`;
                }
            } else {
                showToast('Error al cargar el catálogo.', 'error');
            }
        })
        .catch(error => {
            console.error('Error loading catalog:', error);
            showToast('Error de red al cargar el catálogo.', 'error');
        });
}

function initializeDataTable(tableSelector, pageTitle) {
    if ($.fn.DataTable.isDataTable(tableSelector)) {
        return $(tableSelector).DataTable();
    }
    return $(tableSelector).DataTable({
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        language: { url: '//cdn.datatables.net/plug-ins/2.0.8/i18n/es-ES.json' },
        responsive: true
    });
}

function handleCustomersPage() {
    const apiUrl = `${API_BASE_URL}customers.php`;
    const postalCodeApiUrl = `${API_BASE_URL}postal_code_proxy.php`;
    const form = document.getElementById('form-customer');
    const modalEl = document.getElementById('modal-customer');
    const modal = new coreui.Modal(modalEl);
    const modalTitle = document.getElementById('modal-customer-title-h5');
    const customersTable = initializeDataTable('#customers-table', 'Lista de Clientes');

    const postalCodeInput = document.getElementById('customer-postal-code');
    const neighborhoodSelectEl = document.getElementById('customer-neighborhood');
    const cityInput = document.getElementById('customer-city');
    const stateInput = document.getElementById('customer-state');
    let neighborhoodTomSelect;

    const fetchAddressInfo = (postalCode) => {
        if (postalCode.length !== 5) return;
        if (neighborhoodTomSelect) neighborhoodTomSelect.destroy();

        neighborhoodTomSelect = new TomSelect(neighborhoodSelectEl, {
            valueField: 'asentamiento',
            labelField: 'asentamiento',
            searchField: ['asentamiento'],
            load: function(query, callback) {
                fetch(`${postalCodeApiUrl}?cp=${postalCode}`)
                    .then(res => res.json())
                    .then(res => {
                        if (res.data && res.data.length > 0) {
                            cityInput.value = res.data[0].municipio;
                            stateInput.value = res.data[0].estado;
                        }
                        callback(res.data);
                    }).catch(() => callback());
            },
            render: {
                no_results: function(data, escape) {
                    return '<div class="no-results">No se encontraron resultados.</div>';
                },
            }
        });
        neighborhoodTomSelect.load('');
    };

    postalCodeInput.addEventListener('change', (e) => fetchAddressInfo(e.target.value));

    const loadCustomers = () => {
        fetch(apiUrl)
            .then(res => res.json())
            .then(result => {
                if (result.status === 'success') {
                    const tableData = result.data.map(customer => [
                        customer.name,
                        customer.rfc,
                        customer.email,
                        `${customer.street_address}, ${customer.neighborhood}`,
                        customer.postal_code,
                        `<button class="btn btn-sm btn-info edit-btn" data-id="${customer.id}"><i class="cil-pencil"></i></button>
                         <button class="btn btn-sm btn-danger delete-btn" data-id="${customer.id}"><i class="cil-trash"></i></button>`
                    ]);
                    customersTable.clear().rows.add(tableData).draw();
                } else {
                    showToast(`Error al cargar clientes: ${result.message}`, 'error');
                }
            })
            .catch(err => showToast('Error de red al cargar clientes', 'error'));
    };

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        const id = data.id;
        const method = id ? 'PUT' : 'POST';
        const url = id ? `${apiUrl}?id=${id}` : apiUrl;

        fetch(url, { method: method, headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data) })
            .then(res => res.json())
            .then(result => {
                if (result.status === 'success') {
                    showToast(`Cliente ${id ? 'actualizado' : 'creado'} con éxito`);
                    modal.hide();
                    loadCustomers();
                } else {
                    showToast(`Error: ${result.message}`, 'error');
                }
            })
            .catch(err => showToast('Error al guardar cliente', 'error'));
    });

    document.getElementById('customers-table-body').addEventListener('click', (e) => {
        const editBtn = e.target.closest('.edit-btn');
        const deleteBtn = e.target.closest('.delete-btn');

        if (editBtn) {
            const id = editBtn.dataset.id;
            fetch(`${apiUrl}?id=${id}`)
                .then(res => res.json())
                .then(result => {
                    if (result.status === 'success') {
                        const customer = result.data;
                        modalTitle.textContent = 'Editar Cliente';
                        Object.keys(customer).forEach(key => {
                            if (form.elements[key]) form.elements[key].value = customer[key];
                        });
                        fetchAddressInfo(customer.postal_code);
                        setTimeout(() => {
                           if(neighborhoodTomSelect) neighborhoodTomSelect.setValue(customer.neighborhood);
                        }, 500); // wait for options to load
                        modal.show();
                    }
                });
        }

        if (deleteBtn) {
            if (confirm('¿Estás seguro de que quieres eliminar este cliente?')) {
                const id = deleteBtn.dataset.id;
                fetch(`${apiUrl}?id=${id}`, { method: 'DELETE' })
                    .then(res => res.json())
                    .then(result => {
                        if (result.status === 'success') {
                            showToast('Cliente eliminado con éxito');
                            loadCustomers();
                        } else {
                            showToast(`Error: ${result.message}`, 'error');
                        }
                    });
            }
        }
    });

    modalEl.addEventListener('show.coreui.modal', () => {
        // This is triggered for both new and edit
        const id = form.elements['id'].value;
        if (!id) { // It's a new customer
            modalTitle.textContent = 'Agregar Cliente';
            form.reset();
            if (neighborhoodTomSelect) {
                neighborhoodTomSelect.destroy();
                neighborhoodTomSelect = null;
            }
             neighborhoodSelectEl.innerHTML = '<option value="" disabled selected>Ingresa un C.P. para cargar colonias</option>';
        }
    });

    loadCustomers();
}

function handleProductsPage() {
    const apiUrl = `${API_BASE_URL}products.php`;
    const satApiUrl = `${API_BASE_URL}sat_catalogs.php`;
    const form = document.getElementById('form-product');
    const modalEl = document.getElementById('modal-product');
    const modal = new coreui.Modal(modalEl);
    const modalTitle = document.getElementById('modal-product-title-h5');
    const productsTable = initializeDataTable('#products-table', 'Lista de Productos');
    const unitSelectEl = document.getElementById('product-sat-unit-key');
    let unitTomSelect;

    const loadInitialData = () => {
        fetch(satApiUrl)
            .then(res => res.json())
            .then(result => {
                if (result.status === 'success') {
                    const units = result.data.units;
                    const unitOptions = Object.entries(units).map(([key, value]) => ({ value: key, text: `${key} - ${value}` }));

                    unitTomSelect = new TomSelect(unitSelectEl, {
                        options: unitOptions,
                        create: false,
                        sortField: { field: "text", direction: "asc" }
                    });

                    loadProducts(units);
                }
            });
    };

    const loadProducts = (units = {}) => {
        fetch(apiUrl)
            .then(res => res.json())
            .then(result => {
                if (result.status === 'success') {
                    const tableData = result.data.map(p => [
                        p.sku, p.sat_product_key, p.name,
                        `${p.sat_unit_key} - ${units[p.sat_unit_key] || 'N/A'}`,
                        `$${parseFloat(p.price).toFixed(2)}`,
                        `<button class="btn btn-sm btn-info edit-btn" data-id="${p.id}"><i class="cil-pencil"></i></button>
                         <button class="btn btn-sm btn-danger delete-btn" data-id="${p.id}"><i class="cil-trash"></i></button>`
                    ]);
                    productsTable.clear().rows.add(tableData).draw();
                }
            });
    };

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        const id = data.id;
        const method = id ? 'PUT' : 'POST';
        const url = id ? `${apiUrl}?id=${id}` : apiUrl;

        fetch(url, { method: method, headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data) })
            .then(res => res.json())
            .then(result => {
                if (result.status === 'success') {
                    showToast(`Producto ${id ? 'actualizado' : 'creado'} con éxito`);
                    modal.hide();
                    loadInitialData(); // Reload everything
                } else {
                    showToast(`Error: ${result.message}`, 'error');
                }
            });
    });

    document.getElementById('products-table-body').addEventListener('click', (e) => {
        const editBtn = e.target.closest('.edit-btn');
        const deleteBtn = e.target.closest('.delete-btn');

        if (editBtn) {
            const id = editBtn.dataset.id;
            fetch(`${apiUrl}?id=${id}`)
                .then(res => res.json())
                .then(result => {
                    if (result.status === 'success') {
                        modalTitle.textContent = 'Editar Producto';
                        const product = result.data;
                        Object.keys(product).forEach(key => {
                            if (form.elements[key]) form.elements[key].value = product[key];
                        });
                        if (unitTomSelect) unitTomSelect.setValue(product.sat_unit_key);
                        modal.show();
                    }
                });
        }

        if (deleteBtn) {
            if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
                const id = deleteBtn.dataset.id;
                fetch(`${apiUrl}?id=${id}`, { method: 'DELETE' })
                    .then(res => res.json())
                    .then(result => {
                        if (result.status === 'success') {
                            showToast('Producto eliminado con éxito');
                            loadInitialData(); // Reload everything
                        } else {
                            showToast(`Error: ${result.message}`, 'error');
                        }
                    });
            }
        }
    });

    modalEl.addEventListener('show.coreui.modal', () => {
        const id = form.elements['id'].value;
        if (!id) {
            modalTitle.textContent = 'Agregar Producto';
            form.reset();
            form.elements['tax_rate'].value = '0.16';
            if (unitTomSelect) unitTomSelect.clear();
        }
    });

    loadInitialData();
}

function handleListPage(docType) {
    const apiUrl = `${API_BASE_URL}documents.php?type=${docType}`;
    const table = initializeDataTable(`#${docType}s-table`, `Lista de ${docType}s`);

    fetch(apiUrl)
        .then(res => res.json())
        .then(result => {
            if (result.status === 'success') {
                const tableData = result.data.map(doc => {
                     let statusClass = 'bg-secondary';
                        switch (doc.status) {
                            case 'paid': case 'completed': statusClass = 'bg-success'; break;
                            case 'cancelled': statusClass = 'bg-danger'; break;
                            case 'sent': case 'pending': statusClass = 'bg-info'; break;
                            case 'draft': statusClass = 'bg-light text-dark'; break;
                        }
                    return [
                        doc.folio, doc.customer_name, new Date(doc.created_at).toLocaleDateString(),
                        `$${parseFloat(doc.total).toFixed(2)}`,
                        `<span class="badge ${statusClass}">${doc.status}</span>`,
                        `<a href="index.php?page=document_view&id=${doc.id}" class="btn btn-sm btn-info"><i class="cil-magnifying-glass"></i></a>`
                    ]
                });
                table.clear().rows.add(tableData).draw();
            }
        });
}

function handleInvoicesPage() { handleListPage('invoice'); }
function handleQuotesPage() { handleListPage('quote'); }
function handleOrdersPage() { handleListPage('order'); }


async function handleDocumentFormPage(docType) {
    const form = document.getElementById(`form-${docType}`);
    const itemsContainer = document.getElementById(`${docType}-items`);
    const addItemBtn = document.getElementById('add-item-btn');
    const itemTemplate = document.getElementById(`${docType}-item-template`);

    let products = [];
    let tomSelectInstances = [];

    const createTomSelect = (el, options) => {
        const ts = new TomSelect(el, options);
        tomSelectInstances.push(ts);
        return ts;
    };

    const destroyTomSelects = () => {
        tomSelectInstances.forEach(ts => ts.destroy());
        tomSelectInstances = [];
    };

    const fetchData = async () => {
        const [customersRes, productsRes, satRes] = await Promise.all([
            fetch(`${API_BASE_URL}customers.php`),
            fetch(`${API_BASE_URL}products.php`),
            fetch(`${API_BASE_URL}sat_catalogs.php`)
        ]);
        const customersResult = await customersRes.json();
        const productsResult = await productsRes.json();
        const satResult = await satRes.json();

        if (productsResult.status === 'success') products = productsResult.data;

        // Customer select
        const customerEl = document.getElementById(`${docType}-customer`);
        createTomSelect(customerEl, {
            options: customersResult.data.map(c => ({ value: c.id, text: `${c.name} (${c.rfc})` })),
            placeholder: 'Selecciona un cliente'
        });

        if (docType === 'invoice') {
             const cfdiEl = document.getElementById('invoice-cfdi-use');
             const paymentFormEl = document.getElementById('invoice-payment-form');
             createTomSelect(cfdiEl, { options: Object.entries(satResult.data.cfdi_uses).map(([k, v]) => ({value: k, text: `${k} - ${v}`})) });
             createTomSelect(paymentFormEl, { options: Object.entries(satResult.data.payment_forms).map(([k, v]) => ({value: k, text: `${k} - ${v}`})) });
        }
    };

    const addItemRow = (itemToPopulate = null) => {
        const templateContent = itemTemplate.content.cloneNode(true);
        const newRow = itemsContainer.appendChild(templateContent.firstElementChild);
        const productSelectEl = newRow.querySelector('.product-select');

        const ts = createTomSelect(productSelectEl, {
            options: products.map(p => ({ value: p.id, text: p.name, price: p.price, tax_rate: p.tax_rate })),
            placeholder: 'Selecciona un producto',
            onChange: (value) => {
                 const selectedProduct = ts.options[value];
                 if (selectedProduct) {
                    const row = productSelectEl.closest('.item-row');
                    row.querySelector('.price').value = parseFloat(selectedProduct.price).toFixed(2);
                    updateTotals();
                 }
            }
        });

        if (itemToPopulate) {
            ts.setValue(itemToPopulate.product_id);
            newRow.querySelector('.quantity').value = itemToPopulate.quantity;
        }
    };

    const updateTotals = () => {
        let subtotal = 0, tax = 0;
        itemsContainer.querySelectorAll('.item-row').forEach(row => {
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            const price = parseFloat(row.querySelector('.price').value) || 0;
            const productSelect = row.querySelector('.product-select').tomselect;
            const taxRate = productSelect.options[productSelect.getValue()]?.tax_rate || 0;

            const rowTotal = quantity * price;
            const rowTax = rowTotal * taxRate;
            row.querySelector('.total').value = rowTotal.toFixed(2);
            subtotal += rowTotal;
            tax += rowTax;
        });

        document.getElementById(`${docType}-subtotal`).textContent = `$${subtotal.toFixed(2)}`;
        document.getElementById(`${docType}-tax`).textContent = `$${tax.toFixed(2)}`;
        document.getElementById(`${docType}-total`).textContent = `$${(subtotal + tax).toFixed(2)}`;
    };

    addItemBtn.addEventListener('click', () => addItemRow());

    itemsContainer.addEventListener('click', (e) => {
        if (e.target.closest('.remove-item-btn')) {
            const row = e.target.closest('.item-row');
            const ts = row.querySelector('.product-select').tomselect;
            if(ts) ts.destroy();
            row.remove();
            updateTotals();
        }
    });

    itemsContainer.addEventListener('input', (e) => {
        if (e.target.classList.contains('quantity')) {
            updateTotals();
        }
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        const items = [];
        itemsContainer.querySelectorAll('.item-row').forEach(row => {
            const productId = row.querySelector('.product-select').value;
            const product = products.find(p => p.id == productId);
            if(product){
                items.push({
                    id: productId,
                    quantity: parseFloat(row.querySelector('.quantity').value),
                    price: parseFloat(row.querySelector('.price').value),
                    tax: (parseFloat(row.querySelector('.quantity').value) * parseFloat(row.querySelector('.price').value)) * product.tax_rate,
                    total: parseFloat(row.querySelector('.total').value)
                });
            }
        });

        const payload = {
            ...data,
            type: docType,
            subtotal: parseFloat(document.getElementById(`${docType}-subtotal`).textContent.replace('$', '')),
            tax: parseFloat(document.getElementById(`${docType}-tax`).textContent.replace('$', '')),
            total: parseFloat(document.getElementById(`${docType}-total`).textContent.replace('$', '')),
            items: items
        };

        fetch(`${API_BASE_URL}documents.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(result => {
            if (result.status === 'success') {
                showToast(`${docType.charAt(0).toUpperCase() + docType.slice(1)} creada con éxito! Folio: ${result.data.folio}`);
                window.location.href = `index.php?page=${docType}s`;
            } else {
                showToast(`Error: ${result.message}`, 'error');
            }
        });
    });

    const populateFormFromReference = () => {
        const referenceDoc = JSON.parse(sessionStorage.getItem('referenceDocument'));
        if (referenceDoc) {
            document.getElementById(`${docType}-customer`).tomselect.setValue(referenceDoc.customer_id);
            if(form.elements['source_folio']) form.elements['source_folio'].value = referenceDoc.folio;
            itemsContainer.innerHTML = '';
            referenceDoc.items.forEach(item => addItemRow(item));
            updateTotals();
            sessionStorage.removeItem('referenceDocument');
            return true;
        }
        return false;
    };

    await fetchData();
    if (!populateFormFromReference()) {
        addItemRow();
    }
}

function handleDocumentViewPage() {
    const urlParams = new URLSearchParams(window.location.search);
    const documentId = urlParams.get('id');
    if (!documentId) window.location.href = 'index.php?page=dashboard';

    let documentData; // To store current document data

    const loadDocumentData = async () => {
        const response = await fetch(`${API_BASE_URL}documents.php?id=${documentId}`);
        documentData = (await response.json()).data;

        // Populate view
        document.getElementById('view-folio').textContent = documentData.folio;
        const statusBadge = document.getElementById('view-status');
        statusBadge.textContent = documentData.status;
        statusBadge.className = 'badge'; // reset
        let statusClass = 'bg-secondary';
        switch (documentData.status) {
            case 'paid': case 'completed': statusClass = 'bg-success'; break;
            case 'cancelled': statusClass = 'bg-danger'; break;
            case 'sent': case 'pending': statusClass = 'bg-info'; break;
            case 'draft': statusClass = 'bg-light text-dark'; break;
        }
        statusBadge.classList.add(statusClass);

        document.getElementById('view-created-at').textContent = new Date(documentData.created_at).toLocaleDateString();
        document.getElementById('view-due-date').textContent = new Date(documentData.due_date).toLocaleDateString();
        document.getElementById('view-customer-name').textContent = documentData.customer_name;
        document.getElementById('view-customer-rfc').textContent = `RFC: ${documentData.rfc}`;
        document.getElementById('view-customer-address').textContent = documentData.address;

        if(document.getElementById('fiscal-data-section')) {
            if(documentData.type === 'invoice') {
                document.getElementById('fiscal-data-section').style.display = 'block';
                document.getElementById('view-cfdi-use').textContent = documentData.cfdi_use;
                document.getElementById('view-payment-form').textContent = documentData.payment_form;
                if(documentData.uuid) document.getElementById('view-uuid').textContent = documentData.uuid;
            } else {
                document.getElementById('fiscal-data-section').style.display = 'none';
            }
        }

        document.getElementById('view-items-table-body').innerHTML = documentData.items.map(item => `
            <tr>
                <td>${item.product_sku}</td>
                <td>${item.product_name}</td>
                <td class="text-center">${item.quantity}</td>
                <td class="text-end">$${parseFloat(item.unit_price).toFixed(2)}</td>
                <td class="text-end">$${parseFloat(item.total).toFixed(2)}</td>
            </tr>
        `).join('');

        document.getElementById('view-subtotal').textContent = `$${parseFloat(documentData.subtotal).toFixed(2)}`;
        document.getElementById('view-tax').textContent = `$${parseFloat(documentData.tax).toFixed(2)}`;
        document.getElementById('view-total').textContent = `$${parseFloat(documentData.total).toFixed(2)}`;

        // Handle buttons
        const generateOrderBtn = document.getElementById('generate-order-btn');
        const generateInvoiceBtn = document.getElementById('generate-invoice-btn');
        const recordPaymentBtn = document.getElementById('record-payment-btn');
        const cancelBtn = document.getElementById('cancel-invoice-btn');

        document.getElementById('back-to-list-btn').href = `index.php?page=${documentData.type}s`;

        generateOrderBtn.style.display = documentData.type === 'quote' ? 'inline-block' : 'none';
        generateInvoiceBtn.style.display = documentData.type === 'order' ? 'inline-block' : 'none';
        recordPaymentBtn.style.display = documentData.type === 'invoice' ? 'inline-block' : 'none';

        if (documentData.status === 'cancelled' || documentData.status === 'paid' || documentData.status === 'completed') {
            [generateOrderBtn, generateInvoiceBtn, recordPaymentBtn, cancelBtn].forEach(btn => btn.classList.add('disabled'));
        } else {
             [generateOrderBtn, generateInvoiceBtn, recordPaymentBtn, cancelBtn].forEach(btn => btn.classList.remove('disabled'));
        }
    };

    const handleGeneration = (targetPage) => {
        sessionStorage.setItem('referenceDocument', JSON.stringify(documentData));
        window.location.href = `index.php?page=${targetPage}`;
    };
    document.getElementById('generate-order-btn').addEventListener('click', () => handleGeneration('order_form'));
    document.getElementById('generate-invoice-btn').addEventListener('click', () => handleGeneration('invoice_form'));

    document.getElementById('cancel-invoice-btn').addEventListener('click', async (e) => {
        if (e.target.classList.contains('disabled')) return;
        const reason = prompt('Por favor, ingresa el motivo de la cancelación:');
        if (reason) {
            fetch(`${API_BASE_URL}documents.php?action=cancel`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: documentId, reason: reason })
            })
            .then(res => res.json())
            .then(result => {
                if (result.status === 'success') {
                    showToast('Documento cancelado con éxito.');
                    loadDocumentData();
                } else {
                    showToast(`Error: ${result.message}`, 'error');
                }
            });
        }
    });

    // Payment Logic
    const paymentForm = document.getElementById('form-payment');
    const paymentModalEl = document.getElementById('modal-payment');
    const paymentModal = new coreui.Modal(paymentModalEl);

    const loadPayments = () => {
        fetch(`${API_BASE_URL}payments.php?invoice_id=${documentId}`)
            .then(res => res.json())
            .then(result => {
                const body = document.getElementById('payments-history-body');
                if (result.status === 'success' && result.data.length > 0) {
                    body.innerHTML = result.data.map(p => `
                        <tr>
                            <td>${new Date(p.payment_date).toLocaleDateString()}</td>
                            <td>$${parseFloat(p.amount).toFixed(2)}</td>
                            <td>${p.payment_method}</td>
                            <td>${p.reference || ''}</td>
                        </tr>
                    `).join('');
                } else {
                    body.innerHTML = `<tr><td colspan="4">No se han registrado pagos.</td></tr>`;
                }
            });
    };

    paymentForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(paymentForm);
        const data = Object.fromEntries(formData.entries());
        data.invoice_id = documentId;

        fetch(`${API_BASE_URL}payments.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(result => {
            if (result.status === 'success') {
                showToast('Pago registrado con éxito.');
                paymentModal.hide();
                paymentForm.reset();
                loadDocumentData();
                loadPayments();
            } else {
                showToast(`Error: ${result.message}`, 'error');
            }
        });
    });

    loadDocumentData();
    if(document.getElementById('payments-history-body')) loadPayments();
}
