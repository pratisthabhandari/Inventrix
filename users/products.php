<?php
require_once '../admin/auth.php';
include 'sidebar.html';
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="./css/product.css">

<style>
:root {
    --blue-900: #0c1e3d;
    --blue-800: #1a3460;
    --blue-700: #1e4080;
    --blue-600: #1d4ed8;
    --blue-500: #2563eb;
    --blue-400: #3b82f6;
    --blue-100: #dbeafe;
    --blue-50:  #eff6ff;
    --white:    #ffffff;
    --gray-50:  #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-400: #94a3b8;
    --gray-600: #475569;
    --gray-800: #1e293b;
    --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
    --shadow-md: 0 4px 16px rgba(30,78,180,0.12);
    --shadow-lg: 0 8px 40px rgba(30,78,180,0.18);
    --radius: 12px;
    --font: 'Plus Jakarta Sans', sans-serif;
}
* { box-sizing: border-box; }
body, .main-content, table, input, button { font-family: var(--font) !important; }

.main-content {
    background: var(--gray-40);
    min-height: 100vh;
    padding: 2rem 2.5rem 6rem 2.5rem;
    margin-left: 0 !important;
}

/* ── Page header ── */
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
}
.page-header-left h2 {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--blue-900);
    letter-spacing: -0.03em;
}
.page-header-left p {
    font-size: 0.82rem;
    color: var(--gray-400);
    margin-top: 3px;
}
.header-badge {
    background: linear-gradient(135deg, var(--blue-800), var(--blue-500));
    color: #fff;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 0.35rem 1rem;
    border-radius: 999px;
    box-shadow: 0 2px 8px rgba(37,99,235,0.3);
}

/* ── Search ── */
.search-wrap {
    margin-bottom: 1.25rem;
    position: relative;
    max-width: 380px;
}
.search-icon {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
    pointer-events: none;
}
.search-box {
    width: 100%;
    padding: 0.65rem 1rem 0.65rem 2.6rem;
    border: 1.5px solid var(--gray-200);
    border-radius: 999px;
    background: var(--white);
    font-family: var(--font);
    font-size: 0.85rem;
    color: var(--gray-800);
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    box-shadow: var(--shadow-sm);
}
.search-box:focus { border-color: var(--blue-400); box-shadow: 0 0 0 3px rgba(59,130,246,0.15); }
.search-box::placeholder { color: var(--gray-400); }

/* ── Table ── */
.table-container {
    background: var(--white);
    border-radius: var(--radius);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    border: 1px solid var(--gray-200);
}
table { width: 100%; border-collapse: collapse; }

thead { background: linear-gradient(135deg, var(--blue-900), var(--blue-600)); }
thead th {
    padding: 1rem 1.1rem;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.8);
    text-align: left;
    white-space: nowrap;
}
thead th:first-child { width: 48px; text-align: center; }
thead th:last-child  { text-align: center; }

tbody tr {
    border-bottom: 1px solid var(--gray-100);
    transition: background 0.14s;
    cursor: pointer;
}
tbody tr:last-child { border-bottom: none; }
tbody tr:hover { background: var(--blue-50); }
tbody tr.is-selected { background: #eff6ff; border-left: 3px solid var(--blue-400); }

tbody td {
    padding: 0.85rem 1.1rem;
    font-size: 0.85rem;
    color: var(--gray-800);
    vertical-align: middle;
}
tbody td:first-child { text-align: center; }
tbody td:last-child  { text-align: center; }

.product-name-cell { font-weight: 600; color: var(--blue-900); }

.cat-pill {
    display: inline-block;
    font-size: 0.68rem;
    font-weight: 600;
    padding: 0.2rem 0.65rem;
    border-radius: 999px;
    background: var(--blue-100);
    color: var(--blue-700);
}

.stock-ok  { color: #16a34a; font-weight: 600; }
.stock-low { color: #dc2626; font-weight: 600; }

/* Checkbox */
.cb {
    appearance: none;
    width: 17px; height: 17px;
    border: 2px solid var(--gray-200);
    border-radius: 5px;
    cursor: pointer;
    background: var(--white);
    position: relative;
    transition: all 0.15s;
    vertical-align: middle;
}
.cb:checked { background: var(--blue-500); border-color: var(--blue-500); }
.cb:checked::after {
    content: '';
    position: absolute;
    top: 1px; left: 4px;
    width: 5px; height: 9px;
    border: 2px solid #fff;
    border-top: none; border-left: none;
    transform: rotate(45deg);
}

/* Qty input */
.qty-input {
    width: 72px;
    padding: 0.38rem 0.5rem;
    border: 1.5px solid var(--gray-200);
    border-radius: 7px;
    font-family: var(--font);
    font-size: 0.84rem;
    font-weight: 600;
    text-align: center;
    color: var(--blue-800);
    background: var(--white);
    outline: none;
    transition: border-color 0.18s, box-shadow 0.18s;
}
.qty-input:focus { border-color: var(--blue-400); box-shadow: 0 0 0 3px rgba(59,130,246,0.12); }
.qty-input:disabled { opacity: 0.3; cursor: not-allowed; background: var(--gray-100); }

/* ── Cart bar ── */
.cart-bar {
    display: none;
    position: fixed;
    bottom: 0; left: 0; right: 0;
    background: linear-gradient(135deg, var(--blue-900) 0%, var(--blue-700) 100%);
    color: #fff;
    padding: 1rem 2.5rem;
    align-items: center;
    gap: 2.5rem;
    z-index: 200;
    box-shadow: 0 -4px 30px rgba(30,64,175,0.4);
}
.cart-bar.visible { display: flex; animation: slideUp 0.25s ease; }
@keyframes slideUp { from { transform:translateY(100%); opacity:0; } to { transform:none; opacity:1; } }

.cart-bar-stat { display: flex; flex-direction: column; gap: 2px; }
.cart-bar-label { font-size: 0.63rem; text-transform: uppercase; letter-spacing: 0.1em; opacity: 0.6; }
.cart-bar-value { font-size: 1rem; font-weight: 700; }

.cart-bar-actions { margin-left: auto; display: flex; gap: 0.75rem; align-items: center; }

.btn-clear {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.25);
    color: #fff;
    padding: 0.55rem 1.1rem;
    border-radius: 8px;
    font-family: var(--font);
    font-size: 0.84rem;
    cursor: pointer;
    transition: background 0.15s;
}
.btn-clear:hover { background: rgba(255,255,255,0.2); }

.btn-checkout {
    background: #fff;
    color: var(--blue-700);
    border: none;
    padding: 0.62rem 1.5rem;
    border-radius: 8px;
    font-family: var(--font);
    font-size: 0.88rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.18s;
    box-shadow: 0 2px 10px rgba(0,0,0,0.15);
}
.btn-checkout:hover { transform: translateY(-1px); box-shadow: 0 4px 18px rgba(0,0,0,0.2); }

/* ── Modals ── */
.modal-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(12,30,61,0.6);
    backdrop-filter: blur(5px);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}
.modal-overlay.open { display: flex; }

.modal-box {
    background: var(--white);
    border-radius: 16px;
    width: 92%;
    max-width: 580px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: var(--shadow-lg);
    animation: modalIn 0.22s ease;
    position: relative;
}
@keyframes modalIn {
    from { transform: translateY(18px) scale(0.97); opacity: 0; }
    to   { transform: none; opacity: 1; }
}

.modal-header {
    background: linear-gradient(135deg, var(--blue-900), var(--blue-600));
    padding: 1.4rem 1.75rem;
    border-radius: 16px 16px 0 0;
}
.modal-header h3 { font-size: 1.15rem; font-weight: 800; color: #fff; letter-spacing: -0.02em; }
.modal-header p  { font-size: 0.78rem; color: rgba(255,255,255,0.6); margin-top: 2px; }

.close-btn {
    position: absolute;
    top: 1rem; right: 1.4rem;
    font-size: 1.5rem;
    color: rgba(255,255,255,0.65);
    cursor: pointer;
    line-height: 1;
    transition: color 0.15s;
    z-index: 1;
}
.close-btn:hover { color: #fff; }

.modal-body   { padding: 1.5rem 1.75rem; }
.modal-footer {
    padding: 1rem 1.75rem;
    border-top: 1px solid var(--gray-100);
    display: flex;
    justify-content: flex-end;
    gap: 0.65rem;
}

.confirm-table { width: 100%; border-collapse: collapse; font-size: 0.84rem; }
.confirm-table th {
    text-align: left;
    padding: 0.5rem 0.7rem;
    background: var(--gray-50);
    color: var(--gray-600);
    font-size: 0.68rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    border-bottom: 2px solid var(--gray-200);
}
.confirm-table td { padding: 0.62rem 0.7rem; border-bottom: 1px solid var(--gray-100); color: var(--gray-800); }
.confirm-table tfoot td {
    font-weight: 700;
    color: var(--blue-800);
    font-size: 0.94rem;
    border-top: 2px solid var(--gray-200);
    border-bottom: none;
    padding-top: 0.85rem;
}

.btn-primary {
    background: var(--blue-500);
    color: #fff;
    border: none;
    padding: 0.6rem 1.3rem;
    border-radius: 8px;
    font-family: var(--font);
    font-size: 0.86rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.18s;
}
.btn-primary:hover { background: var(--blue-600); transform: translateY(-1px); }

.btn-secondary {
    background: var(--gray-100);
    color: var(--gray-600);
    border: 1px solid var(--gray-200);
    padding: 0.6rem 1.1rem;
    border-radius: 8px;
    font-family: var(--font);
    font-size: 0.86rem;
    cursor: pointer;
    transition: background 0.15s;
}
.btn-secondary:hover { background: var(--gray-200); }

/* ── Bill / Receipt ── */
.bill-modal-box { max-width: 560px; }

.bill-head {
    background: linear-gradient(135deg, var(--blue-900) 0%, var(--blue-600) 100%);
    padding: 2.2rem 2rem 1.75rem;
    text-align: center;
    position: relative;
    overflow: hidden;
    border-radius: 16px 16px 0 0;
}
.bill-head::before {
    content: '';
    position: absolute;
    top: -50px; right: -50px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
}
.bill-head::after {
    content: '';
    position: absolute;
    bottom: -40px; left: -40px;
    width: 140px; height: 140px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}
.bill-logo {
    font-family: 'Playfair Display', serif;
    font-size: 1.65rem;
    color: #fff;
    font-weight: 700;
    position: relative;
    z-index: 1;
}
.bill-tagline {
    font-size: 0.68rem;
    color: rgba(255,255,255,0.5);
    letter-spacing: 0.2em;
    text-transform: uppercase;
    margin-top: 3px;
    position: relative;
    z-index: 1;
}
.bill-badge {
    display: inline-block;
    margin-top: 1rem;
    background: rgba(255,255,255,0.14);
    border: 1px solid rgba(255,255,255,0.22);
    color: #fff;
    font-size: 0.67rem;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    padding: 0.25rem 0.9rem;
    border-radius: 999px;
    position: relative;
    z-index: 1;
}

.bill-meta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    padding: 1.1rem 1.75rem;
    background: var(--gray-50);
    border-bottom: 1px dashed var(--gray-200);
    gap: 0.5rem 0;
}
.bill-meta-item.right { text-align: right; }
.bill-meta-label { font-size: 0.63rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--gray-400); }
.bill-meta-value { font-size: 0.83rem; font-weight: 600; color: var(--blue-900); margin-top: 2px; }

.bill-items { padding: 1.25rem 1.75rem; }
.bill-items-header {
    display: grid;
    grid-template-columns: 1fr 60px 95px 95px;
    gap: 0.5rem;
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--gray-400);
    font-weight: 700;
    padding-bottom: 0.6rem;
    border-bottom: 2px solid var(--blue-100);
    margin-bottom: 0.2rem;
}
.bill-item-row {
    display: grid;
    grid-template-columns: 1fr 60px 95px 95px;
    gap: 0.5rem;
    padding: 0.65rem 0;
    border-bottom: 1px solid var(--gray-100);
    font-size: 0.84rem;
    align-items: center;
}
.bill-item-row:last-child { border-bottom: none; }
.bill-item-name  { font-weight: 600; color: var(--blue-900); }
.bill-item-qty   { color: var(--gray-600); text-align: center; }
.bill-item-price { color: var(--gray-600); text-align: right; font-size: 0.8rem; }
.bill-item-total { color: var(--blue-600); font-weight: 700; text-align: right; }

.bill-summary {
    margin: 0 1.75rem;
    border-top: 2px dashed var(--gray-200);
    padding: 0.9rem 0 0;
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}
.bill-summary-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.82rem;
    color: var(--gray-600);
}

.bill-grand {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, var(--blue-900), var(--blue-600));
    margin: 1.1rem 1.75rem;
    border-radius: 10px;
    padding: 1rem 1.3rem;
    color: #fff;
    box-shadow: 0 4px 16px rgba(37,99,235,0.3);
}
.bill-grand-label  { font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.1em; opacity: 0.7; }
.bill-grand-amount {
    font-family: 'Playfair Display', serif;
    font-size: 1.6rem;
    font-weight: 700;
    letter-spacing: -0.02em;
}

.bill-footer {
    text-align: center;
    padding: 1rem 1.75rem 1.5rem;
    border-top: 1px dashed var(--gray-200);
}
.bill-thanks { font-family: 'Playfair Display', serif; font-size: 1rem; color: var(--blue-600); margin-bottom: 4px; }
.bill-footer p { font-size: 0.71rem; color: var(--gray-400); line-height: 1.65; }

.bill-actions {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    padding: 1rem 1.75rem 1.4rem;
    border-top: 1px solid var(--gray-100);
}

/* ── Toast ── */
#toast-container {
    position: fixed;
    bottom: 5.5rem;
    right: 1.5rem;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}
.toast {
    padding: 0.7rem 1.1rem;
    border-radius: 8px;
    font-family: var(--font);
    font-size: 0.82rem;
    font-weight: 500;
    box-shadow: var(--shadow-md);
    max-width: 300px;
    animation: toastIn 0.25s ease, toastOut 0.3s ease 3.7s forwards;
}
.toast-success { background: #ecfdf5; border: 1px solid #6ee7b7; color: #065f46; }
.toast-error   { background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; }
@keyframes toastIn  { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:none; } }
@keyframes toastOut { from { opacity:1; } to { opacity:0; } }
</style>

<div class="main-content">
    <div class="page-header">
        <div class="page-header-left">
            <h2>Available Products</h2>
            <p>Select items, set quantities, then checkout to generate a bill</p>
        </div>
       
    </div>

    <div class="search-wrap">
        <svg class="search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" class="search-box" id="searchBox" placeholder="Search products, categories, suppliers…" oninput="filterTable()">
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" class="cb" id="masterCb" onchange="masterToggle(this)" title="Select all"></th>
                    <th>Product Name</th>
                    <th>Unit Price</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Stock Value</th>
                    <th>Supplier</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody id="productTable"></tbody>
        </table>
    </div>

    <div class="cart-bar" id="cartBar">
        <div class="cart-bar-stat">
            <span class="cart-bar-label">Products</span>
            <span class="cart-bar-value" id="cartItems">0</span>
        </div>
        <div class="cart-bar-stat">
            <span class="cart-bar-label">Units</span>
            <span class="cart-bar-value" id="cartUnits">0</span>
        </div>
        <div class="cart-bar-stat">
            <span class="cart-bar-label">Total</span>
            <span class="cart-bar-value" id="cartTotal">NRs. 0.00</span>
        </div>
        <div class="cart-bar-actions">
            <button class="btn-clear" onclick="clearSelection()">Clear</button>
            <button class="btn-checkout" onclick="openConfirmModal()">Review &amp; Checkout →</button>
        </div>
    </div>
</div>

<!-- Confirm Modal -->
<div class="modal-overlay" id="confirmModal">
    <div class="modal-box">
        <div class="modal-header">
            <span class="close-btn" onclick="closeModal('confirmModal')">&times;</span>
            <h3>Review Checkout</h3>
            <p>Verify items and quantities before confirming</p>
        </div>
        <div class="modal-body">
            <table class="confirm-table">
                <thead>
                    <tr><th>Product</th><th>Unit Price</th><th>Qty</th><th>Line Total</th></tr>
                </thead>
                <tbody id="confirmBody"></tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">Grand Total</td>
                        <td id="confirmTotalQty"></td>
                        <td id="confirmGrandTotal"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="modal-footer">
            <button class="btn-secondary" onclick="closeModal('confirmModal')">Cancel</button>
            <button class="btn-primary" onclick="processBulkCheckout()">✓ Confirm Checkout</button>
        </div>
    </div>
</div>

<!-- Bill Modal -->
<div class="modal-overlay" id="billModal">
    <div class="modal-box bill-modal-box">
        <span class="close-btn" style="color:rgba(255,255,255,0.7);top:1rem;right:1.3rem" onclick="closeModal('billModal')">&times;</span>
        <div id="billContent"></div>
        <div class="bill-actions">
            <button class="btn-secondary" onclick="closeModal('billModal')">Close</button>
            <button class="btn-primary" onclick="printBill()">🖨&nbsp; Print Bill</button>
        </div>
    </div>
</div>

<div id="toast-container"></div>

<script>
let allProducts = [];
let selectedIds = new Set();

document.addEventListener('DOMContentLoaded', () => {
    fetch('../admin/fetch_product.php')
        .then(r => r.json())
        .then(products => { allProducts = products; renderTable(products); });
});

function renderTable(products) {
    const tbody = document.getElementById('productTable');
    if (!products.length) {
        tbody.innerHTML = `<tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--gray-400)">No products found</td></tr>`;
        return;
    }
    tbody.innerHTML = products.map(p => {
        const stockVal   = (p.stock * p.unit_price).toFixed(2);
        const stockClass = parseInt(p.stock) <= 5 ? 'stock-low' : 'stock-ok';
        const sel        = selectedIds.has(p.id);
        return `
        <tr id="productRow${p.id}" class="${sel ? 'is-selected' : ''}" onclick="rowClick(event,${p.id})">
            <td><input type="checkbox" class="cb row-cb" data-id="${p.id}" ${sel ? 'checked' : ''}
                onclick="event.stopPropagation()" onchange="toggleRow(this)"></td>
            <td class="product-name-cell">${esc(p.product_name)}</td>
            <td>NRs. ${parseFloat(p.unit_price).toFixed(2)}</td>
            <td><span class="cat-pill">${esc(p.category)}</span></td>
            <td id="stockCell${p.id}" class="${stockClass}">${p.stock}</td>
            <td id="totalPriceCell${p.id}">NRs. ${stockVal}</td>
            <td>${esc(p.supplier)}</td>
            <td>
                <input type="number" class="qty-input" id="qty${p.id}"
                    min="1" max="${p.stock}" value="1"
                    ${sel ? '' : 'disabled'}
                    data-id="${p.id}" data-price="${p.unit_price}" data-stock="${p.stock}"
                    onclick="event.stopPropagation()"
                    oninput="onQtyChange(this)">
            </td>
        </tr>`;
    }).join('');
}

function filterTable() {
    const q = document.getElementById('searchBox').value.toLowerCase();
    renderTable(allProducts.filter(p =>
        p.product_name.toLowerCase().includes(q) ||
        p.category.toLowerCase().includes(q) ||
        (p.supplier||'').toLowerCase().includes(q)
    ));
}

function rowClick(e, id) {
    if (e.target.classList.contains('cb') || e.target.classList.contains('qty-input')) return;
    const cb = document.querySelector(`.row-cb[data-id="${id}"]`);
    if (cb) { cb.checked = !cb.checked; toggleRow(cb); }
}

function toggleRow(cb) {
    const id  = parseInt(cb.dataset.id);
    const qi  = document.getElementById(`qty${id}`);
    const row = document.getElementById(`productRow${id}`);
    if (cb.checked) {
        selectedIds.add(id);
        if (qi)  qi.disabled = false;
        if (row) row.classList.add('is-selected');
    } else {
        selectedIds.delete(id);
        if (qi)  { qi.disabled = true; qi.value = 1; }
        if (row) row.classList.remove('is-selected');
    }
    updateCartBar();
}

function masterToggle(cb) {
    document.querySelectorAll('.row-cb').forEach(c => { c.checked = cb.checked; toggleRow(c); });
}

function clearSelection() {
    selectedIds.clear();
    document.querySelectorAll('.row-cb').forEach(c => { c.checked = false; });
    document.querySelectorAll('.qty-input').forEach(i => { i.disabled = true; i.value = 1; });
    document.querySelectorAll('tbody tr').forEach(r => r.classList.remove('is-selected'));
    document.getElementById('masterCb').checked = false;
    updateCartBar();
}

function onQtyChange(input) {
    let qty = parseInt(input.value) || 1;
    const max = parseInt(input.dataset.stock);
    if (qty < 1) qty = 1;
    if (qty > max) { qty = max; showToast(`Max available stock: ${max}`, 'error'); }
    input.value = qty;
    updateCartBar();
}

function updateCartBar() {
    const bar   = document.getElementById('cartBar');
    const count = selectedIds.size;
    bar.classList.toggle('visible', count > 0);
    if (!count) return;
    let units = 0, total = 0;
    selectedIds.forEach(id => {
        const qi = document.getElementById(`qty${id}`);
        const p  = allProducts.find(x => x.id == id);
        if (qi && p) { const q = parseInt(qi.value)||1; units += q; total += q * parseFloat(p.unit_price); }
    });
    document.getElementById('cartItems').textContent = count;
    document.getElementById('cartUnits').textContent  = units;
    document.getElementById('cartTotal').textContent  = `NRs. ${total.toFixed(2)}`;
}

function openConfirmModal() {
    if (!selectedIds.size) { showToast('No items selected', 'error'); return; }
    let rows = '', totalQty = 0, grand = 0;
    selectedIds.forEach(id => {
        const p   = allProducts.find(x => x.id == id);
        const qty = parseInt(document.getElementById(`qty${id}`)?.value) || 1;
        if (!p) return;
        const line = qty * parseFloat(p.unit_price);
        totalQty += qty; grand += line;
        rows += `<tr>
            <td>${esc(p.product_name)}</td>
            <td>NRs. ${parseFloat(p.unit_price).toFixed(2)}</td>
            <td>${qty}</td>
            <td>NRs. ${line.toFixed(2)}</td>
        </tr>`;
    });
    document.getElementById('confirmBody').innerHTML = rows;
    document.getElementById('confirmTotalQty').textContent   = totalQty;
    document.getElementById('confirmGrandTotal').textContent = `NRs. ${grand.toFixed(2)}`;
    openModal('confirmModal');
}

async function processBulkCheckout() {
    const items = [];
    selectedIds.forEach(id => {
        items.push({ productId: id, quantity: parseInt(document.getElementById(`qty${id}`)?.value)||1 });
    });
    closeModal('confirmModal');
    showToast('Processing checkout…', 'success');

    const results = await Promise.all(items.map(item => {
        const fd = new FormData();
        fd.append('productId', item.productId);
        fd.append('quantity',  item.quantity);
        return fetch('checkout_product.php', { method:'POST', body:fd })
            .then(r => r.json())
            .then(d => ({ ...d, productId: item.productId, quantity: item.quantity }))
            .catch(() => ({ status:'error', productId: item.productId }));
    }));

    const succeeded = results.filter(r => r.status === 'success');
    const failed    = results.filter(r => r.status !== 'success');

    succeeded.forEach(r => {
        const p = allProducts.find(x => x.id == r.productId);
        if (p) p.stock = r.newStock;
        const sc = document.getElementById(`stockCell${r.productId}`);
        const tc = document.getElementById(`totalPriceCell${r.productId}`);
        if (sc) sc.textContent = r.newStock;
        if (tc && p) tc.textContent = `NRs. ${(r.newStock * parseFloat(p.unit_price)).toFixed(2)}`;
    });

    failed.forEach(r => {
        const p = allProducts.find(x => x.id == r.productId);
        showToast(`Failed: ${p?.product_name || 'Item #'+r.productId}`, 'error');
    });

    if (succeeded.length) {
        showToast(`✓ Checked out ${succeeded.length} product(s)`, 'success');
        localStorage.setItem('dashboardRefresh', Date.now());
        clearSelection();
        renderBill(succeeded);
    }
}

function renderBill(results) {
    const now     = new Date();
    const dateStr = now.toLocaleDateString('en-NP', { year:'numeric', month:'long', day:'numeric' });
    const timeStr = now.toLocaleTimeString('en-NP', { hour:'2-digit', minute:'2-digit' });
    const billNo  = 'BL-' + Date.now().toString().slice(-8);

    let itemRows = '', subtotal = 0, totalQty = 0;
    results.forEach(r => {
        const p = allProducts.find(x => x.id == r.productId);
        if (!p) return;
        const line = r.quantity * parseFloat(p.unit_price);
        subtotal += line; totalQty += r.quantity;
        itemRows += `
        <div class="bill-item-row">
            <div class="bill-item-name">${esc(p.product_name)}</div>
            <div class="bill-item-qty">${r.quantity}</div>
            <div class="bill-item-price">NRs. ${parseFloat(p.unit_price).toFixed(2)}</div>
            <div class="bill-item-total">NRs. ${line.toFixed(2)}</div>
        </div>`;
    });

    document.getElementById('billContent').innerHTML = `
    <div class="bill-head">
        <div class="bill-logo">Inventory Manager</div>
        <div class="bill-tagline">Sales Receipt</div>
        <div class="bill-badge">Official Bill</div>
    </div>
    <div class="bill-meta">
        <div class="bill-meta-item">
            <div class="bill-meta-label">Bill No.</div>
            <div class="bill-meta-value">${billNo}</div>
        </div>
        <div class="bill-meta-item right">
            <div class="bill-meta-label">Date</div>
            <div class="bill-meta-value">${dateStr}</div>
        </div>
        <div class="bill-meta-item">
            <div class="bill-meta-label">Time</div>
            <div class="bill-meta-value">${timeStr}</div>
        </div>
        <div class="bill-meta-item right">
            <div class="bill-meta-label">Items</div>
            <div class="bill-meta-value">${results.length} product${results.length>1?'s':''}</div>
        </div>
    </div>
    <div class="bill-items">
        <div class="bill-items-header">
            <div>Product</div>
            <div style="text-align:center">Qty</div>
            <div style="text-align:right">Unit Price</div>
            <div style="text-align:right">Total</div>
        </div>
        ${itemRows}
    </div>
    <div class="bill-summary">
        <div class="bill-summary-row">
            <span>Subtotal (${totalQty} unit${totalQty>1?'s':''})</span>
            <span>NRs. ${subtotal.toFixed(2)}</span>
        </div>
        <div class="bill-summary-row">
            <span>Tax</span>
            <span>NRs. 0.00</span>
        </div>
    </div>
    <div class="bill-grand">
        <div>
            <div class="bill-grand-label">Grand Total</div>
        </div>
        <div class="bill-grand-amount">NRs. ${subtotal.toFixed(2)}</div>
    </div>
    <div class="bill-footer">
        <div class="bill-thanks">Thank you!</div>
        <p>This is a computer-generated bill.<br>Please keep this receipt for your records.</p>
    </div>`;

    openModal('billModal');
}

function printBill() {
    const content = document.getElementById('billContent').innerHTML;
    const win = window.open('', '_blank');
    win.document.write(`<html><head><title>Bill</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Plus Jakarta Sans',sans-serif;background:#fff}
        .wrap{max-width:500px;margin:0 auto;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden}
        .bill-head{background:linear-gradient(135deg,#0c1e3d,#2563eb);padding:2rem;text-align:center;position:relative;overflow:hidden}
        .bill-head::before{content:'';position:absolute;top:-40px;right:-40px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,0.06)}
        .bill-logo{font-family:'Playfair Display',serif;font-size:1.5rem;color:#fff;font-weight:700;position:relative;z-index:1}
        .bill-tagline{font-size:.65rem;color:rgba(255,255,255,.5);letter-spacing:.2em;text-transform:uppercase;margin-top:3px;position:relative;z-index:1}
        .bill-badge{display:inline-block;margin-top:.9rem;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.22);color:#fff;font-size:.63rem;letter-spacing:.14em;text-transform:uppercase;padding:.22rem .8rem;border-radius:999px;position:relative;z-index:1}
        .bill-meta{display:grid;grid-template-columns:1fr 1fr;padding:1rem 1.5rem;background:#f8fafc;border-bottom:1px dashed #e2e8f0;gap:.4rem 0}
        .bill-meta-item{padding:.15rem 0}.right{text-align:right}
        .bill-meta-label{font-size:.6rem;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8}
        .bill-meta-value{font-size:.81rem;font-weight:600;color:#0c1e3d;margin-top:1px}
        .bill-items{padding:1.1rem 1.5rem}
        .bill-items-header{display:grid;grid-template-columns:1fr 55px 90px 90px;gap:.4rem;font-size:.62rem;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;font-weight:700;padding-bottom:.5rem;border-bottom:2px solid #dbeafe;margin-bottom:.1rem}
        .bill-item-row{display:grid;grid-template-columns:1fr 55px 90px 90px;gap:.4rem;padding:.6rem 0;border-bottom:1px solid #f1f5f9;font-size:.82rem;align-items:center}
        .bill-item-row:last-child{border-bottom:none}
        .bill-item-name{font-weight:600;color:#0c1e3d}
        .bill-item-qty{color:#475569;text-align:center}
        .bill-item-price{color:#475569;text-align:right;font-size:.78rem}
        .bill-item-total{color:#1d4ed8;font-weight:700;text-align:right}
        .bill-summary{margin:0 1.5rem;border-top:2px dashed #e2e8f0;padding:.85rem 0 0;display:flex;flex-direction:column;gap:.35rem}
        .bill-summary-row{display:flex;justify-content:space-between;font-size:.8rem;color:#475569}
        .bill-grand{display:flex;justify-content:space-between;align-items:center;background:linear-gradient(135deg,#0c1e3d,#2563eb);margin:1rem 1.5rem;border-radius:10px;padding:.9rem 1.1rem;color:#fff}
        .bill-grand-label{font-size:.68rem;text-transform:uppercase;letter-spacing:.1em;opacity:.7}
        .bill-grand-amount{font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700}
        .bill-footer{text-align:center;padding:.9rem 1.5rem 1.4rem;border-top:1px dashed #e2e8f0}
        .bill-thanks{font-family:'Playfair Display',serif;font-size:.95rem;color:#2563eb;margin-bottom:3px}
        .bill-footer p{font-size:.68rem;color:#94a3b8;line-height:1.65}
    </style></head>
    <body><div class="wrap">${content}</div></body></html>`);
    win.document.close();
    setTimeout(() => win.print(), 700);
}

function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

function showToast(msg, type='success') {
    const c = document.getElementById('toast-container');
    const t = document.createElement('div');
    t.className = `toast toast-${type}`;
    t.textContent = msg;
    c.appendChild(t);
    setTimeout(() => { if(t.parentNode) c.removeChild(t); }, 4000);
}

function esc(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
</script>