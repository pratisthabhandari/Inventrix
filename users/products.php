<?php
require_once '../admin/auth.php';
include 'sidebar.html';
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="./css/product.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root {
    --bg:         #ffffff;
    --blue:       #4bafd4;
    --blue-dark:  #2a8db5;
    --blue-deep:  #1a6e91;
    --blue-pale:  #d0e9f5;
    --blue-faint: #eaf5fb;
    --blue-soft:  #a8d8ec;
    --white:      #ffffff;
    --text:       #0d2a38;
    --text-sec:   #2a5570;
    --muted:      #5589a3;
    --border:     #bcd9e8;
    --green:      #1a8f5e;
    --green-bg:   #edfaf4;
    --red:        #dc2626;
    --red-bg:     #fef2f2;
    --font:       'Nunito', sans-serif;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

html, body {
    font-family: var(--font) !important;
    background: var(--bg) !important;
}

.main-content {
    font-family: var(--font) !important;
    background: var(--bg);
    min-height: 100vh;
    margin-left: 255px;
    padding: 2rem 2.5rem 7rem;
}

/* ── HEADER CARD (matches welcome-banner style) ── */
.header-card {
    background: var(--white);
    border-radius: 18px;
    border: 1.5px solid var(--blue-pale);
    padding: 1.75rem 2rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    box-shadow: 0 2px 12px rgba(42,141,181,0.07);
    position: relative;
    overflow: hidden;
}

/* same decorative circle as welcome-banner */
.header-card::after {
    content: '';
    position: absolute;
    right: -40px; top: -40px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: var(--blue-faint);
    border: 30px solid var(--blue-pale);
    pointer-events: none;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
    z-index: 1;
}

.header-icon {
    width: 48px; height: 48px;
    background: var(--blue-faint);
    border: 2px solid var(--blue-pale);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: var(--blue);
    flex-shrink: 0;
}

.header-texts { display: flex; flex-direction: column; gap: 2px; }

.header-eyebrow {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--blue);
}

.header-title {
    font-size: 1.65rem;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -0.02em;
    line-height: 1.2;
}

.header-sub {
    font-size: 0.84rem;
    color: var(--muted);
    font-weight: 500;
    margin-top: 0.1rem;
}

.header-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.65rem;
    position: relative;
    z-index: 1;
    flex-shrink: 0;
}

/* product count chip — mirrors welcome-icon style */
.header-chip {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--blue-faint);
    border: 1.5px solid var(--blue-pale);
    border-radius: 12px;
    padding: 0.5rem 1rem;
}
.chip-val {
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--text);
    line-height: 1;
}
.chip-lbl {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--muted);
}

/* Search — mirrors clock-pill row */
.search-wrap {
    position: relative;
    width: 260px;
}
.search-icon {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--blue);
    pointer-events: none;
    font-size: 0.72rem;
}
.search-box {
    width: 100%;
    padding: 0.4rem 1rem 0.4rem 2.3rem;
    border: 1.5px solid var(--blue-pale);
    border-radius: 999px;
    background: var(--blue-faint);
    font-family: var(--font);
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--text-sec);
    outline: none;
    transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
}
.search-box:focus {
    border-color: var(--blue);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(75,175,212,0.13);
}
.search-box::placeholder { color: #aac8d8; font-weight: 600; }

/* ── TABLE CONTAINER ── */
.table-container {
    background: var(--white);
    border-radius: 18px;
    border: 1.5px solid var(--border);
    box-shadow: 0 2px 0 var(--blue-pale), 0 4px 20px rgba(42,141,181,0.08);
    overflow: hidden;
}

table { width: 100%; border-collapse: collapse; }

thead {
    background: var(--blue-faint);
    border-bottom: 2px solid var(--blue-pale);
}
thead th {
    padding: 0.9rem 1.1rem;
    font-size: 0.68rem;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--text-sec);
    text-align: left;
    white-space: nowrap;
}
thead th:first-child { width: 48px; text-align: center; }
thead th:last-child  { text-align: center; }

tbody tr {
    border-bottom: 1px solid var(--blue-faint);
    transition: background 0.13s;
    cursor: pointer;
}
tbody tr:last-child { border-bottom: none; }
tbody tr:hover { background: var(--blue-faint); }
tbody tr.is-selected {
    background: #e4f3fa;
    border-left: 3px solid var(--blue);
}

tbody td {
    padding: 0.9rem 1.1rem;
    font-size: 0.85rem;
    color: var(--text);
    vertical-align: middle;
}
tbody td:first-child { text-align: center; }
tbody td:last-child  { text-align: center; }

.product-name-cell { font-weight: 700; color: var(--text); }

.cat-pill {
    display: inline-block;
    font-size: 0.68rem;
    font-weight: 700;
    padding: 0.2rem 0.65rem;
    border-radius: 999px;
    background: var(--blue-faint);
    color: var(--blue-deep);
    border: 1px solid var(--blue-pale);
}

.stock-ok  { color: var(--green); font-weight: 700; }
.stock-low { color: var(--red);   font-weight: 700; }

/* ── CHECKBOX ── */
.cb {
    appearance: none;
    width: 17px; height: 17px;
    border: 2px solid var(--border);
    border-radius: 5px;
    cursor: pointer;
    background: var(--white);
    position: relative;
    transition: all 0.15s;
    vertical-align: middle;
}
.cb:checked { background: var(--blue); border-color: var(--blue); }
.cb:checked::after {
    content: '';
    position: absolute;
    top: 1px; left: 4px;
    width: 5px; height: 9px;
    border: 2px solid #fff;
    border-top: none; border-left: none;
    transform: rotate(45deg);
}

/* ── QTY INPUT ── */
.qty-input {
    width: 72px;
    padding: 0.38rem 0.5rem;
    border: 1.5px solid var(--border);
    border-radius: 8px;
    font-family: var(--font);
    font-size: 0.84rem;
    font-weight: 700;
    text-align: center;
    color: var(--text);
    background: var(--white);
    outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.qty-input:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(75,175,212,0.13);
}
.qty-input:disabled {
    opacity: 0.35;
    cursor: not-allowed;
    background: var(--blue-faint);
}

/* ── CART BAR ── */
.cart-bar {
    display: none;
    position: fixed;
    bottom: 0; left: 0; right: 0;
    background: var(--white);
    border-top: 2px solid var(--blue-pale);
    padding: 1rem 2.5rem;
    align-items: center;
    gap: 2.5rem;
    z-index: 200;
    box-shadow: 0 -4px 24px rgba(42,141,181,0.12);
}
.cart-bar.visible { display: flex; animation: slideUp 0.22s ease; }
@keyframes slideUp {
    from { transform: translateY(100%); opacity: 0; }
    to   { transform: none; opacity: 1; }
}

.cart-bar-stat { display: flex; flex-direction: column; gap: 2px; }
.cart-bar-label {
    font-size: 0.62rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--muted);
    font-weight: 700;
}
.cart-bar-value {
    font-size: 1rem;
    font-weight: 800;
    color: var(--text);
}

.cart-bar-actions { margin-left: auto; display: flex; gap: 0.75rem; align-items: center; }

.btn-clear {
    background: var(--blue-faint);
    border: 1.5px solid var(--border);
    color: var(--text-sec);
    padding: 0.55rem 1.2rem;
    border-radius: 10px;
    font-family: var(--font);
    font-size: 0.84rem;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.15s;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.btn-clear:hover { background: var(--blue-pale); }

.btn-checkout {
    background: var(--blue);
    color: #fff;
    border: none;
    padding: 0.62rem 1.5rem;
    border-radius: 10px;
    font-family: var(--font);
    font-size: 0.88rem;
    font-weight: 800;
    cursor: pointer;
    transition: all 0.18s;
    box-shadow: 0 3px 12px rgba(75,175,212,0.35);
    display: flex;
    align-items: center;
    gap: 0.45rem;
}
.btn-checkout:hover {
    background: var(--blue-dark);
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(42,141,181,0.4);
}

/* ── MODALS ── */
.modal-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(13,42,56,0.45);
    backdrop-filter: blur(4px);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}
.modal-overlay.open { display: flex; }

.modal-box {
    background: var(--white);
    border-radius: 20px;
    width: 92%;
    max-width: 580px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(42,141,181,0.2);
    animation: modalIn 0.22s ease;
    position: relative;
    border: 1.5px solid var(--border);
}
@keyframes modalIn {
    from { transform: translateY(16px) scale(0.97); opacity: 0; }
    to   { transform: none; opacity: 1; }
}

.modal-header {
    background: var(--blue-faint);
    padding: 1.4rem 1.75rem;
    border-radius: 18px 18px 0 0;
    border-bottom: 1.5px solid var(--blue-pale);
}
.modal-header h3 { font-size: 1.1rem; font-weight: 800; color: var(--text); }
.modal-header p  { font-size: 0.76rem; color: var(--muted); margin-top: 3px; font-weight: 500; }

.close-btn {
    position: absolute;
    top: 1rem; right: 1.4rem;
    font-size: 1.3rem;
    color: var(--muted);
    cursor: pointer;
    line-height: 1;
    transition: color 0.15s;
    z-index: 1;
}
.close-btn:hover { color: var(--text); }

.modal-body   { padding: 1.5rem 1.75rem; }
.modal-footer {
    padding: 1rem 1.75rem;
    border-top: 1.5px solid var(--blue-faint);
    display: flex;
    justify-content: flex-end;
    gap: 0.65rem;
}

.confirm-table { width: 100%; border-collapse: collapse; font-size: 0.84rem; }
.confirm-table th {
    text-align: left;
    padding: 0.55rem 0.75rem;
    background: var(--blue-faint);
    color: var(--text-sec);
    font-size: 0.68rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    font-weight: 700;
    border-bottom: 2px solid var(--blue-pale);
}
.confirm-table td {
    padding: 0.65rem 0.75rem;
    border-bottom: 1px solid var(--blue-faint);
    color: var(--text);
}
.confirm-table tfoot td {
    font-weight: 800;
    color: var(--blue-deep);
    font-size: 0.92rem;
    border-top: 2px solid var(--blue-pale);
    border-bottom: none;
    padding-top: 0.85rem;
    background: var(--blue-faint);
}

.btn-primary {
    background: var(--blue);
    color: #fff;
    border: none;
    padding: 0.62rem 1.3rem;
    border-radius: 10px;
    font-family: var(--font);
    font-size: 0.86rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.18s;
    box-shadow: 0 3px 10px rgba(75,175,212,0.3);
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.btn-primary:hover { background: var(--blue-dark); transform: translateY(-1px); }

.btn-secondary {
    background: var(--blue-faint);
    color: var(--text-sec);
    border: 1.5px solid var(--border);
    padding: 0.62rem 1.1rem;
    border-radius: 10px;
    font-family: var(--font);
    font-size: 0.86rem;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.15s;
}
.btn-secondary:hover { background: var(--blue-pale); }

/* ── BILL ── */
.bill-modal-box { max-width: 560px; }

.bill-head {
    background: linear-gradient(135deg, var(--blue-deep) 0%, var(--blue) 100%);
    padding: 2.2rem 2rem 1.75rem;
    text-align: center;
    position: relative;
    overflow: hidden;
    border-radius: 18px 18px 0 0;
}
.bill-head::before {
    content: '';
    position: absolute;
    top: -50px; right: -50px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.07);
    pointer-events: none;
}
.bill-head::after {
    content: '';
    position: absolute;
    bottom: -40px; left: -40px;
    width: 140px; height: 140px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
    pointer-events: none;
}

.bill-logo    { font-size: 1.5rem; font-weight: 800; color: #fff; position: relative; z-index: 1; letter-spacing: 0.06em; }
.bill-tagline { font-size: 0.68rem; color: rgba(255,255,255,0.55); letter-spacing: 0.2em; text-transform: uppercase; margin-top: 3px; position: relative; z-index: 1; }
.bill-badge   { display: inline-block; margin-top: 1rem; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); color: #fff; font-size: 0.67rem; letter-spacing: 0.14em; text-transform: uppercase; padding: 0.25rem 0.9rem; border-radius: 999px; position: relative; z-index: 1; }

.bill-meta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    padding: 1.1rem 1.75rem;
    background: var(--blue-faint);
    border-bottom: 1px dashed var(--blue-pale);
    gap: 0.5rem 0;
}
.bill-meta-item.right { text-align: right; }
.bill-meta-label { font-size: 0.62rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--muted); font-weight: 700; }
.bill-meta-value { font-size: 0.83rem; font-weight: 700; color: var(--text); margin-top: 2px; }

.bill-items { padding: 1.25rem 1.75rem; }
.bill-items-header {
    display: grid;
    grid-template-columns: 1fr 60px 95px 95px;
    gap: 0.5rem;
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--muted);
    font-weight: 700;
    padding-bottom: 0.6rem;
    border-bottom: 2px solid var(--blue-pale);
    margin-bottom: 0.2rem;
}
.bill-item-row {
    display: grid;
    grid-template-columns: 1fr 60px 95px 95px;
    gap: 0.5rem;
    padding: 0.65rem 0;
    border-bottom: 1px solid var(--blue-faint);
    font-size: 0.84rem;
    align-items: center;
}
.bill-item-row:last-child { border-bottom: none; }
.bill-item-name  { font-weight: 700; color: var(--text); }
.bill-item-qty   { color: var(--muted); text-align: center; font-weight: 600; }
.bill-item-price { color: var(--muted); text-align: right; font-size: 0.8rem; }
.bill-item-total { color: var(--blue-dark); font-weight: 800; text-align: right; }

.bill-summary {
    margin: 0 1.75rem;
    border-top: 2px dashed var(--blue-pale);
    padding: 0.9rem 0 0;
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}
.bill-summary-row { display: flex; justify-content: space-between; font-size: 0.82rem; color: var(--muted); font-weight: 600; }

.bill-grand {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, var(--blue-deep), var(--blue));
    margin: 1.1rem 1.75rem;
    border-radius: 12px;
    padding: 1rem 1.3rem;
    color: #fff;
    box-shadow: 0 4px 16px rgba(42,141,181,0.3);
}
.bill-grand-label  { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; opacity: 0.7; font-weight: 700; }
.bill-grand-amount { font-size: 1.6rem; font-weight: 800; letter-spacing: -0.02em; }

.bill-footer {
    text-align: center;
    padding: 1rem 1.75rem 1.5rem;
    border-top: 1px dashed var(--blue-pale);
}
.bill-thanks { font-size: 1rem; font-weight: 800; color: var(--blue-dark); margin-bottom: 4px; }
.bill-footer p { font-size: 0.71rem; color: var(--muted); line-height: 1.65; }

.bill-actions {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    padding: 1rem 1.75rem 1.4rem;
    border-top: 1.5px solid var(--blue-faint);
}

/* ── TOAST ── */
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
    border-radius: 10px;
    font-family: var(--font);
    font-size: 0.82rem;
    font-weight: 600;
    box-shadow: 0 4px 16px rgba(42,141,181,0.12);
    max-width: 300px;
    animation: toastIn 0.25s ease, toastOut 0.3s ease 3.7s forwards;
}
.toast-success { background: var(--green-bg); border: 1px solid #a7f3d0; color: var(--green); }
.toast-error   { background: var(--red-bg);   border: 1px solid #fca5a5; color: var(--red); }
@keyframes toastIn  { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:none; } }
@keyframes toastOut { from { opacity:1; } to { opacity:0; } }
</style>

<div class="main-content">

    <!-- ── HEADER CARD ── -->
    <div class="header-card">
        <div class="header-left">
            <div class="header-icon">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <div class="header-texts">
                <span class="header-eyebrow">Inventory</span>
                <div class="header-title">Available Products</div>
                <div class="header-sub">Browse and checkout products from your inventory</div>
            </div>
        </div>
        <div class="header-right">
            <div class="header-chip">
                <i class="fa-solid fa-box" style="color:var(--blue); font-size:0.75rem;"></i>
                <span class="chip-val" id="totalCount">—</span>
                <span class="chip-lbl">Products</span>
            </div>
            <div class="search-wrap">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" class="search-box" id="searchBox"
                    placeholder="Search products…"
                    oninput="filterTable()">
            </div>
        </div>
    </div>

    <!-- ── TABLE ── -->
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

    <!-- ── CART BAR ── -->
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
            <button class="btn-clear" onclick="clearSelection()">
                <i class="fa-solid fa-xmark"></i> Clear
            </button>
            <button class="btn-checkout" onclick="openConfirmModal()">
                Review &amp; Checkout <i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>
    </div>

</div>

<!-- ── CONFIRM MODAL ── -->
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
            <button class="btn-primary" onclick="processBulkCheckout()">
                <i class="fa-solid fa-check"></i> Confirm Checkout
            </button>
        </div>
    </div>
</div>

<!-- ── BILL MODAL ── -->
<div class="modal-overlay" id="billModal">
    <div class="modal-box bill-modal-box">
        <span class="close-btn" onclick="closeModal('billModal')">&times;</span>
        <div id="billContent"></div>
        <div class="bill-actions">
            <button class="btn-secondary" onclick="closeModal('billModal')">Close</button>
            <button class="btn-primary" onclick="printBill()">
                <i class="fa-solid fa-print"></i> Print Bill
            </button>
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
        .then(products => {
            allProducts = products;
            renderTable(products);
            const el = document.getElementById('totalCount');
            if (el) el.textContent = products.length;
        })
        .catch(() => {
            const el = document.getElementById('totalCount');
            if (el) el.textContent = '—';
        });
});

function renderTable(products) {
    const tbody = document.getElementById('productTable');
    if (!products.length) {
        tbody.innerHTML = `<tr><td colspan="8" style="text-align:center;padding:2.5rem;color:var(--muted);font-weight:600">No products found</td></tr>`;
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
        <div class="bill-logo">INVENTRIX</div>
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
    win.document.write(`<html><head><title>Bill — INVENTRIX</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Nunito',sans-serif;background:#fff}
        .wrap{max-width:500px;margin:0 auto;border:1px solid #bcd9e8;border-radius:14px;overflow:hidden}
        .bill-head{background:linear-gradient(135deg,#1a6e91,#4bafd4);padding:2rem;text-align:center;position:relative;overflow:hidden}
        .bill-head::before{content:'';position:absolute;top:-40px;right:-40px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,0.07)}
        .bill-logo{font-size:1.4rem;font-weight:800;color:#fff;position:relative;z-index:1;letter-spacing:.06em}
        .bill-tagline{font-size:.65rem;color:rgba(255,255,255,.55);letter-spacing:.2em;text-transform:uppercase;margin-top:3px;position:relative;z-index:1}
        .bill-badge{display:inline-block;margin-top:.9rem;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);color:#fff;font-size:.63rem;letter-spacing:.14em;text-transform:uppercase;padding:.22rem .8rem;border-radius:999px;position:relative;z-index:1}
        .bill-meta{display:grid;grid-template-columns:1fr 1fr;padding:1rem 1.5rem;background:#eaf5fb;border-bottom:1px dashed #d0e9f5;gap:.4rem 0}
        .bill-meta-item{padding:.15rem 0}.right{text-align:right}
        .bill-meta-label{font-size:.6rem;text-transform:uppercase;letter-spacing:.08em;color:#5589a3;font-weight:700}
        .bill-meta-value{font-size:.81rem;font-weight:700;color:#0d2a38;margin-top:1px}
        .bill-items{padding:1.1rem 1.5rem}
        .bill-items-header{display:grid;grid-template-columns:1fr 55px 90px 90px;gap:.4rem;font-size:.62rem;text-transform:uppercase;letter-spacing:.08em;color:#5589a3;font-weight:700;padding-bottom:.5rem;border-bottom:2px solid #d0e9f5;margin-bottom:.1rem}
        .bill-item-row{display:grid;grid-template-columns:1fr 55px 90px 90px;gap:.4rem;padding:.6rem 0;border-bottom:1px solid #eaf5fb;font-size:.82rem;align-items:center}
        .bill-item-row:last-child{border-bottom:none}
        .bill-item-name{font-weight:700;color:#0d2a38}
        .bill-item-qty{color:#5589a3;text-align:center;font-weight:600}
        .bill-item-price{color:#5589a3;text-align:right;font-size:.78rem}
        .bill-item-total{color:#2a8db5;font-weight:800;text-align:right}
        .bill-summary{margin:0 1.5rem;border-top:2px dashed #d0e9f5;padding:.85rem 0 0;display:flex;flex-direction:column;gap:.35rem}
        .bill-summary-row{display:flex;justify-content:space-between;font-size:.8rem;color:#5589a3;font-weight:600}
        .bill-grand{display:flex;justify-content:space-between;align-items:center;background:linear-gradient(135deg,#1a6e91,#4bafd4);margin:1rem 1.5rem;border-radius:10px;padding:.9rem 1.1rem;color:#fff}
        .bill-grand-label{font-size:.68rem;text-transform:uppercase;letter-spacing:.1em;opacity:.7;font-weight:700}
        .bill-grand-amount{font-size:1.5rem;font-weight:800;letter-spacing:-.02em}
        .bill-footer{text-align:center;padding:.9rem 1.5rem 1.4rem;border-top:1px dashed #d0e9f5}
        .bill-thanks{font-size:.95rem;font-weight:800;color:#2a8db5;margin-bottom:3px}
        .bill-footer p{font-size:.68rem;color:#5589a3;line-height:1.65}
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