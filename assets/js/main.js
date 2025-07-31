document.addEventListener('DOMContentLoaded', function() {
    // Initialize all Materialize components
    M.AutoInit();

    const API_BASE_URL = 'api/';

    // Check which page is currently active
    if (document.getElementById('customers-page')) {
        handleCustomersPage();
    }
    if (document.getElementById('products-page')) {
        handleProductsPage();
    }
});

/**
 * Handles all logic for the Customers page
 */
function handleCustomersPage() {
    const apiUrl = `${API_BASE_URL}customers.php`;
    const tableBody = document.getElementById('customers-table-body');
    const form = document.getElementById('form-customer');
    const modal = M.Modal.getInstance(document.getElementById('modal-customer'));
    const modalTitle = document.getElementById('modal-customer-title');
    const customerIdField = document.getElementById('customer-id');

    // --- Load Customers ---
    const loadCustomers = async () => {
        try {
            const response = await fetch(apiUrl);
            const result = await response.json();
            if (result.status === 'success') {
                tableBody.innerHTML = result.data.map(customer => `
                    <tr>
                        <td>${customer.name}</td>
                        <td>${customer.rfc}</td>
                        <td>${customer.email}</td>
                        <td>${customer.phone}</td>
                        <td>
                            <a href="#" class="btn-small waves-effect waves-light blue edit-btn" data-id="${customer.id}"><i class="material-icons">edit</i></a>
                            <a href="#" class="btn-small waves-effect waves-light red delete-btn" data-id="${customer.id}"><i class="material-icons">delete</i></a>
                        </td>
                    </tr>
                `).join('');
            }
        } catch (error) {
            console.error('Error loading customers:', error);
            M.toast({ html: 'Error al cargar clientes' });
        }
    };

    // --- Form Submission (Create/Update) ---
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        const id = data.id;

        const method = id ? 'PUT' : 'POST';
        const url = id ? `${apiUrl}?id=${id}` : apiUrl;

        try {
            const response = await fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.status === 'success') {
                M.toast({ html: `Cliente ${id ? 'actualizado' : 'creado'} con éxito` });
                modal.close();
                loadCustomers();
            } else {
                M.toast({ html: `Error: ${result.message}` });
            }
        } catch (error) {
            console.error('Error saving customer:', error);
            M.toast({ html: 'Error al guardar cliente' });
        }
    });

    // --- Event Delegation for Edit and Delete buttons ---
    tableBody.addEventListener('click', async (e) => {
        const target = e.target.closest('a');
        if (!target) return;

        const id = target.dataset.id;

        // --- Edit Button ---
        if (target.classList.contains('edit-btn')) {
            e.preventDefault();
            try {
                const response = await fetch(`${apiUrl}?id=${id}`);
                const result = await response.json();
                if (result.status === 'success') {
                    const customer = result.data;
                    modalTitle.textContent = 'Editar Cliente';
                    customerIdField.value = customer.id;
                    form.elements['name'].value = customer.name;
                    form.elements['rfc'].value = customer.rfc;
                    form.elements['address'].value = customer.address;
                    form.elements['email'].value = customer.email;
                    form.elements['phone'].value = customer.phone;
                    M.updateTextFields(); // Important for Materialize labels
                    modal.open();
                }
            } catch (error) {
                console.error('Error fetching customer for edit:', error);
            }
        }

        // --- Delete Button ---
        if (target.classList.contains('delete-btn')) {
            e.preventDefault();
            if (confirm('¿Estás seguro de que quieres eliminar este cliente?')) {
                try {
                    const response = await fetch(`${apiUrl}?id=${id}`, { method: 'DELETE' });
                    const result = await response.json();
                    if (result.status === 'success') {
                        M.toast({ html: 'Cliente eliminado con éxito' });
                        loadCustomers();
                    } else {
                        M.toast({ html: `Error: ${result.message}` });
                    }
                } catch (error) {
                    console.error('Error deleting customer:', error);
                }
            }
        }
    });

    // --- Reset form when opening modal for new customer ---
    document.querySelector('a[href="#modal-customer"]').addEventListener('click', () => {
        modalTitle.textContent = 'Agregar Cliente';
        form.reset();
        customerIdField.value = '';
    });

    // Initial load
    loadCustomers();
}

/**
 * Handles all logic for the Products page
 */
function handleProductsPage() {
    const apiUrl = `${API_BASE_URL}products.php`;
    const tableBody = document.getElementById('products-table-body');
    const form = document.getElementById('form-product');
    const modal = M.Modal.getInstance(document.getElementById('modal-product'));
    const modalTitle = document.getElementById('modal-product-title');
    const productIdField = document.getElementById('product-id');

    // --- Load Products ---
    const loadProducts = async () => {
        try {
            const response = await fetch(apiUrl);
            const result = await response.json();
            if (result.status === 'success') {
                tableBody.innerHTML = result.data.map(product => `
                    <tr>
                        <td>${product.sku}</td>
                        <td>${product.name}</td>
                        <td>$${parseFloat(product.price).toFixed(2)}</td>
                        <td>${(parseFloat(product.tax_rate) * 100).toFixed(0)}%</td>
                        <td>
                            <a href="#" class="btn-small waves-effect waves-light blue edit-btn" data-id="${product.id}"><i class="material-icons">edit</i></a>
                            <a href="#" class="btn-small waves-effect waves-light red delete-btn" data-id="${product.id}"><i class="material-icons">delete</i></a>
                        </td>
                    </tr>
                `).join('');
            }
        } catch (error) {
            console.error('Error loading products:', error);
            M.toast({ html: 'Error al cargar productos' });
        }
    };

    // --- Form Submission (Create/Update) ---
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        const id = data.id;

        const method = id ? 'PUT' : 'POST';
        const url = id ? `${apiUrl}?id=${id}` : apiUrl;

        try {
            const response = await fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.status === 'success') {
                M.toast({ html: `Producto ${id ? 'actualizado' : 'creado'} con éxito` });
                modal.close();
                loadProducts();
            } else {
                M.toast({ html: `Error: ${result.message}` });
            }
        } catch (error) {
            console.error('Error saving product:', error);
            M.toast({ html: 'Error al guardar producto' });
        }
    });

    // --- Event Delegation for Edit and Delete buttons ---
    tableBody.addEventListener('click', async (e) => {
        const target = e.target.closest('a');
        if (!target) return;

        const id = target.dataset.id;

        // --- Edit Button ---
        if (target.classList.contains('edit-btn')) {
            e.preventDefault();
            try {
                const response = await fetch(`${apiUrl}?id=${id}`);
                const result = await response.json();
                if (result.status === 'success') {
                    const product = result.data;
                    modalTitle.textContent = 'Editar Producto';
                    productIdField.value = product.id;
                    form.elements['sku'].value = product.sku;
                    form.elements['name'].value = product.name;
                    form.elements['unit_key'].value = product.unit_key;
                    form.elements['price'].value = product.price;
                    form.elements['tax_rate'].value = product.tax_rate;
                    M.updateTextFields();
                    modal.open();
                }
            } catch (error) {
                console.error('Error fetching product for edit:', error);
            }
        }

        // --- Delete Button ---
        if (target.classList.contains('delete-btn')) {
            e.preventDefault();
            if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
                try {
                    const response = await fetch(`${apiUrl}?id=${id}`, { method: 'DELETE' });
                    const result = await response.json();
                    if (result.status === 'success') {
                        M.toast({ html: 'Producto eliminado con éxito' });
                        loadProducts();
                    } else {
                        M.toast({ html: `Error: ${result.message}` });
                    }
                } catch (error) {
                    console.error('Error deleting product:', error);
                }
            }
        }
    });

    // --- Reset form when opening modal for new product ---
    document.querySelector('a[href="#modal-product"]').addEventListener('click', () => {
        modalTitle.textContent = 'Agregar Producto';
        form.reset();
        productIdField.value = '';
        form.elements['tax_rate'].value = '0.16'; // Default tax rate
    });

    // Initial load
    loadProducts();
}

/**
 * Handles all logic for the Invoices List page
 */
function handleInvoicesPage() {
    const apiUrl = `${API_BASE_URL}documents.php?type=invoice`;
    const tableBody = document.getElementById('invoices-table-body');

    const loadInvoices = async () => {
        try {
            const response = await fetch(apiUrl);
            const result = await response.json();
            if (result.status === 'success') {
                tableBody.innerHTML = result.data.map(invoice => `
                    <tr>
                        <td>${invoice.folio}</td>
                        <td>${invoice.customer_name}</td>
                        <td>${new Date(invoice.created_at).toLocaleDateString()}</td>
                        <td>$${parseFloat(invoice.total).toFixed(2)}</td>
                        <td><span class="new badge" data-badge-caption="${invoice.status}"></span></td>
                        <td>
                            <a href="index.php?page=invoice_view&id=${invoice.id}" class="btn-small waves-effect waves-light"><i class="material-icons">visibility</i></a>
                        </td>
                    </tr>
                `).join('');
                 // Re-initialize badges if necessary
                M.AutoInit();
            }
        } catch (error) {
            console.error('Error loading invoices:', error);
            M.toast({ html: 'Error al cargar facturas' });
        }
    };

    loadInvoices();
}


/**
 * Handles all logic for the Invoice Form page
 */
async function handleInvoiceFormPage() {
    const form = document.getElementById('form-invoice');
    const customerSelect = document.getElementById('invoice-customer');
    const cfdiUseSelect = document.getElementById('invoice-cfdi-use');
    const paymentMethodSelect = document.getElementById('invoice-payment-method');
    const itemsContainer = document.getElementById('invoice-items');
    const addItemBtn = document.getElementById('add-item-btn');
    const itemTemplate = document.getElementById('invoice-item-template');

    let products = []; // To store product data

    // --- Fetch initial data (Customers, Products, SAT Catalogs) ---
    const fetchData = async () => {
        try {
            const [customersRes, productsRes, satRes] = await Promise.all([
                fetch(`${API_BASE_URL}customers.php`),
                fetch(`${API_BASE_URL}products.php`),
                fetch(`${API_BASE_URL}sat_catalogs.php`)
            ]);
            const customersResult = await customersRes.json();
            const productsResult = await productsRes.json();
            const satResult = await satRes.json();

            // Populate customers
            if (customersResult.status === 'success') {
                customersResult.data.forEach(c => {
                    customerSelect.innerHTML += `<option value="${c.id}">${c.name} (${c.rfc})</option>`;
                });
            }

            // Store products and populate product selects
            if (productsResult.status === 'success') {
                products = productsResult.data;
            }

            // Populate SAT catalogs
            if (satResult.status === 'success') {
                for (const [key, value] of Object.entries(satResult.data.cfdi_uses)) {
                    cfdiUseSelect.innerHTML += `<option value="${key}">${key} - ${value}</option>`;
                }
                for (const [key, value] of Object.entries(satResult.data.payment_methods)) {
                    paymentMethodSelect.innerHTML += `<option value="${key}">${key} - ${value}</option>`;
                }
            }

            // Re-initialize Materialize selects
            M.FormSelect.init(document.querySelectorAll('select'));

        } catch (error) {
            console.error('Error fetching initial data:', error);
            M.toast({ html: 'Error al cargar datos iniciales del formulario.' });
        }
    };

    // --- Add Item Row ---
    const addItemRow = () => {
        const templateContent = itemTemplate.content.cloneNode(true);
        const productSelect = templateContent.querySelector('.product-select');

        // Populate products in the new row's select
        products.forEach(p => {
            productSelect.innerHTML += `<option value="${p.id}" data-price="${p.price}" data-tax-rate="${p.tax_rate}">${p.name}</option>`;
        });

        itemsContainer.appendChild(templateContent);
        M.FormSelect.init(itemsContainer.querySelectorAll('select:last-of-type'));
    };

    // --- Update Totals ---
    const updateTotals = () => {
        let subtotal = 0;
        let tax = 0;

        itemsContainer.querySelectorAll('.item-row').forEach(row => {
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            const price = parseFloat(row.querySelector('.price').value) || 0;

            const productSelect = row.querySelector('.product-select');
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const taxRate = parseFloat(selectedOption.dataset.taxRate) || 0;

            const rowTotal = quantity * price;
            const rowTax = rowTotal * taxRate;

            row.querySelector('.total').value = rowTotal.toFixed(2);
            subtotal += rowTotal;
            tax += rowTax;
        });

        document.getElementById('invoice-subtotal').textContent = `$${subtotal.toFixed(2)}`;
        document.getElementById('invoice-tax').textContent = `$${tax.toFixed(2)}`;
        document.getElementById('invoice-total').textContent = `$${(subtotal + tax).toFixed(2)}`;
    };

    // --- Event Listeners ---
    addItemBtn.addEventListener('click', addItemRow);

    itemsContainer.addEventListener('click', (e) => {
        if (e.target.closest('.remove-item-btn')) {
            e.target.closest('.item-row').remove();
            updateTotals();
        }
    });

    itemsContainer.addEventListener('change', (e) => {
        // When a product is selected
        if (e.target.classList.contains('product-select')) {
            const selectedOption = e.target.options[e.target.selectedIndex];
            const price = selectedOption.dataset.price || 0;
            const row = e.target.closest('.item-row');
            row.querySelector('.price').value = parseFloat(price).toFixed(2);
        }
        updateTotals();
    });

    itemsContainer.addEventListener('input', (e) => {
        // When quantity is changed
        if (e.target.classList.contains('quantity')) {
            updateTotals();
        }
    });

    // --- Form Submission ---
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const subtotal = parseFloat(document.getElementById('invoice-subtotal').textContent.replace('$', ''));
        const tax = parseFloat(document.getElementById('invoice-tax').textContent.replace('$', ''));
        const total = parseFloat(document.getElementById('invoice-total').textContent.replace('$', ''));

        const items = [];
        itemsContainer.querySelectorAll('.item-row').forEach(row => {
            const productId = row.querySelector('.product-select').value;
            const product = products.find(p => p.id == productId);
            const quantity = parseFloat(row.querySelector('.quantity').value);
            const price = parseFloat(row.querySelector('.price').value);

            if (product) {
                 items.push({
                    id: productId,
                    quantity: quantity,
                    price: price,
                    tax: (quantity * price) * product.tax_rate,
                    total: quantity * price
                });
            }
        });

        const formData = new FormData(form);
        const data = {
            customer_id: formData.get('customer_id'),
            type: 'invoice', // Hardcoded for now
            cfdi_use: formData.get('cfdi_use'),
            payment_method: formData.get('payment_method'),
            due_date: formData.get('due_date'),
            subtotal: subtotal,
            tax: tax,
            total: total,
            items: items
        };

        try {
            const response = await fetch(`${API_BASE_URL}documents.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.status === 'success') {
                M.toast({ html: 'Factura creada con éxito!' });
                // Redirect to the invoices list
                window.location.href = 'index.php?page=invoices';
            } else {
                 M.toast({ html: `Error: ${result.message}` });
            }
        } catch (error) {
            console.error('Error creating invoice:', error);
            M.toast({ html: 'Error al crear la factura.' });
        }
    });

    // --- Initial setup ---
    await fetchData();
    // Add one item row to start with
    addItemRow();
    // Initialize datepickers
    M.Datepicker.init(document.querySelectorAll('.datepicker'), {
        format: 'yyyy-mm-dd',
        autoClose: true
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all Materialize components
    M.AutoInit();

    const API_BASE_URL = 'api/';

    // Check which page is currently active
    if (document.getElementById('customers-page')) {
        handleCustomersPage();
    }
    if (document.getElementById('products-page')) {
        handleProductsPage();
    }
    if (document.getElementById('invoices-page')) {
        handleInvoicesPage();
    }
    if (document.getElementById('invoice-form-page')) {
        handleInvoiceFormPage();
    }
    if (document.getElementById('invoice-view-page')) {
        handleInvoiceViewPage();
    }
});

/**
 * Handles all logic for the Invoice View page
 */
function handleInvoiceViewPage() {
    const urlParams = new URLSearchParams(window.location.search);
    const invoiceId = urlParams.get('id');

    if (!invoiceId) {
        window.location.href = 'index.php?page=invoices';
        return;
    }

    const loadInvoiceData = async () => {
        try {
            const response = await fetch(`${API_BASE_URL}documents.php?id=${invoiceId}`);
            const result = await response.json();

            if (result.status === 'success') {
                const doc = result.data;

                // --- Populate Header ---
                document.getElementById('view-folio').textContent = doc.folio;
                const statusBadge = document.getElementById('view-status');
                statusBadge.textContent = doc.status;
                statusBadge.dataset.badgeCaption = doc.status;
                // Add color based on status
                statusBadge.className = 'new badge'; // reset
                if (doc.status === 'paid' || doc.status === 'completed') statusBadge.classList.add('green');
                if (doc.status === 'cancelled') statusBadge.classList.add('red');


                document.getElementById('view-created-at').textContent = new Date(doc.created_at).toLocaleDateString();
                document.getElementById('view-due-date').textContent = new Date(doc.due_date).toLocaleDateString();

                // --- Populate Customer Info ---
                document.getElementById('view-customer-name').textContent = doc.customer_name;
                document.getElementById('view-customer-rfc').textContent = `RFC: ${doc.rfc}`;
                document.getElementById('view-customer-address').textContent = doc.address;

                // --- Populate Fiscal Info ---
                document.getElementById('view-cfdi-use').textContent = `${doc.cfdi_use} - ${SAT_USO_CFDI[doc.cfdi_use] || ''}`;
                document.getElementById('view-payment-method').textContent = `${doc.payment_method} - ${SAT_METODO_PAGO[doc.payment_method] || ''}`;
                if(doc.uuid) document.getElementById('view-uuid').textContent = doc.uuid;

                // --- Populate Items Table ---
                const itemsBody = document.getElementById('view-items-table-body');
                itemsBody.innerHTML = doc.items.map(item => `
                    <tr>
                        <td>${item.product_sku}</td>
                        <td>${item.product_name}</td>
                        <td class="center-align">${item.quantity}</td>
                        <td class="right-align">$${parseFloat(item.unit_price).toFixed(2)}</td>
                        <td class="right-align">$${parseFloat(item.total).toFixed(2)}</td>
                    </tr>
                `).join('');

                // --- Populate Totals ---
                document.getElementById('view-subtotal').textContent = `$${parseFloat(doc.subtotal).toFixed(2)}`;
                document.getElementById('view-tax').textContent = `$${parseFloat(doc.tax).toFixed(2)}`;
                document.getElementById('view-total').textContent = `$${parseFloat(doc.total).toFixed(2)}`;

                // --- Handle button visibility based on status ---
                if (doc.status === 'cancelled' || doc.status === 'paid') {
                    document.getElementById('cancel-invoice-btn').classList.add('disabled');
                    document.getElementById('record-payment-btn').classList.add('disabled');
                }

            } else {
                M.toast({ html: `Error: ${result.message}` });
                // setTimeout(() => window.location.href = 'index.php?page=invoices', 2000);
            }
        } catch (error) {
            console.error('Error loading invoice data:', error);
            M.toast({ html: 'Error al cargar los datos de la factura.' });
        }
    };

    // --- Need SAT catalogs for display ---
    // This is a bit inefficient, but simple. A better way would be to cache this.
    const fetchSatCatalogs = async () => {
        try {
            const response = await fetch(`${API_BASE_URL}sat_catalogs.php`);
            const result = await response.json();
            if (result.status === 'success') {
                // Make them globally available for this page's scope
                window.SAT_USO_CFDI = result.data.cfdi_uses;
                window.SAT_METODO_PAGO = result.data.payment_methods;
            }
        } catch (error) {
            console.error('Error fetching SAT catalogs:', error);
        }
    };

    const init = async () => {
        await fetchSatCatalogs();
        await loadInvoiceData();
    };

    // --- Event Listener for Cancel Button ---
    document.getElementById('cancel-invoice-btn').addEventListener('click', async (e) => {
        e.preventDefault();
        if (e.target.classList.contains('disabled')) return;

        if (confirm('¿Estás seguro de que quieres cancelar esta factura? Esta acción no se puede deshacer.')) {
            try {
                const response = await fetch(`${API_BASE_URL}documents.php?id=${invoiceId}`, {
                    method: 'DELETE'
                });
                const result = await response.json();
                if (result.status === 'success') {
                    M.toast({ html: 'Factura cancelada con éxito.' });
                    // Reload data to reflect changes
                    loadInvoiceData();
                } else {
                    M.toast({ html: `Error: ${result.message}` });
                }
            } catch (error) {
                console.error('Error cancelling invoice:', error);
                M.toast({ html: 'Error al cancelar la factura.' });
            }
        }
    });

    // --- Payment Logic ---
    const paymentForm = document.getElementById('form-payment');
    const paymentsHistoryBody = document.getElementById('payments-history-body');
    const paymentModal = M.Modal.getInstance(document.getElementById('modal-payment'));

    const loadPayments = async () => {
        try {
            const response = await fetch(`${API_BASE_URL}payments.php?invoice_id=${invoiceId}`);
            const result = await response.json();
            if (result.status === 'success' && result.data.length > 0) {
                paymentsHistoryBody.innerHTML = result.data.map(p => `
                    <tr>
                        <td>${new Date(p.payment_date).toLocaleDateString()}</td>
                        <td>$${parseFloat(p.amount).toFixed(2)}</td>
                        <td>${p.payment_method}</td>
                        <td>${p.reference || ''}</td>
                    </tr>
                `).join('');
            } else {
                 paymentsHistoryBody.innerHTML = `<tr><td colspan="4">No se han registrado pagos.</td></tr>`;
            }
        } catch (error) {
            console.error('Error loading payments:', error);
        }
    };

    paymentForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(paymentForm);
        const data = Object.fromEntries(formData.entries());
        data.invoice_id = invoiceId; // Add invoiceId to the data

        try {
            const response = await fetch(`${API_BASE_URL}payments.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.status === 'success') {
                M.toast({ html: 'Pago registrado con éxito.' });
                paymentModal.close();
                paymentForm.reset();
                // Reload both invoice data (for status) and payment history
                loadInvoiceData();
                loadPayments();
            } else {
                M.toast({ html: `Error: ${result.message}` });
            }
        } catch (error) {
            console.error('Error saving payment:', error);
            M.toast({ html: 'Error al registrar el pago.' });
        }
    });


    init();
    loadPayments();
}
