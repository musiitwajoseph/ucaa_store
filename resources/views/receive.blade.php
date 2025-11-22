@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

@component('components.breadcrumb')
    @slot('title') Dashboard @endslot
    @slot('subtitle') Home @endslot
    @slot('breadcrumb_items')
        <span class="breadcrumb-item active">Dashboard</span>
    @endslot
@endcomponent

<div class="container mt-4">
  <div class="card shadow">
    <div class="card-header bg-primary text-white text-center">
      <h4>MATERIAL RECEIVED NOTE</h4>
    </div>

    <div class="card-body">
      <form>
        <!-- Header Fields -->
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">LPO/Contract No:</label>
            <input type="text" name="contract_no" class="form-control" placeholder="Enter No:" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" placeholder="DD/MM/YYYY" required>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Supplier</label>
            <input type="text" name="supplier" class="form-control" placeholder="Supplier Name" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Delivery Note No:</label>
            <input type="text" name="delivery_note" class="form-control" placeholder="" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Invoice No</label>
          <input type="text" name="invoice_no" class="form-control" placeholder="" required>
        </div>

        <hr>

        <!-- Items Section -->
        <h5 class="mb-3">Materials Received</h5>

        <table class="table table-bordered" id="items_table">
          <thead class="table-secondary">
            <tr>
              <th style="width: 120px;">QTY ORDERED</th>
              <th style="width: 120px;">QTY RECEIVED</th>
              <th>Description</th>
              <th style="width: 120px;">UNIT PRICE</th>
              <th>TOTAL VALUE</th>
              <th style="width: 80px;">Remove</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="number" name="qty_ordered[]" class="form-control" min="0" step="1"></td>
              <td><input type="number" name="qty_received[]" class="form-control" min="0" step="1"></td>
              <td><input type="text" name="description[]" class="form-control" placeholder="Description"></td>
              <td><input type="text" name="unit_price[]" class="form-control" min="0" placeholder=""></td>
              <td><input type="text" name="line_total[]" class="form-control" placeholder=""></td>
              <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm removeRow">✕</button>
              </td>
            </tr>
          </tbody>
        </table>

        <div class="mb-3">
          <button type="button" id="addRow" class="btn btn-secondary btn-sm">+ Add Item</button>
        </div>

       
        <div class="row mb-3">
          <div class="col-md-6 offset-md-6">
            <div class="input-group">
              <span class="input-group-text">Full TOTAL</span>
              <input type="text" id="grandTotal" class="form-control" placeholder="" style="font-weight: bold;">
            </div>
          </div>
        </div>

     
        <button type="submit" class="btn btn-primary w-100">Submit</button>
      </form>
    </div>
  </div>
</div>

<script>
  
  document.getElementById('addRow').addEventListener('click', function () {
    const tableBody = document.querySelector('#items_table tbody');
    const newRow = `
      <tr>
        <td><input type="number" name="qty_ordered[]" class="form-control" min="0" step="1"></td>
        <td><input type="number" name="qty_received[]" class="form-control" min="0" step="1"></td>
        <td><input type="text" name="description[]" class="form-control" placeholder="Description"></td>
        <td><input type="number" name="unit_price[]" class="form-control" min="0" placeholder=""></td>
        <td><input type="text" name="line_total[]" class="form-control line-total" placeholder=""></td>
        <td class="text-center">
          <button type="button" class="btn btn-danger btn-sm removeRow">✕</button>
        </td>
      </tr>
    `;
    tableBody.insertAdjacentHTML('beforeend', newRow);
  });


  document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('removeRow')) {
      e.target.closest('tr').remove();
      calculateGrandTotal();
    }
  });


  document.addEventListener('input', function (e) {
    const row = e.target.closest('tr');
    if (!row) return;

    const qtyInput = row.querySelector('input[name="qty_received[]"]');
    const priceInput = row.querySelector('input[name="unit_price[]"]');
    const totalInput = row.querySelector('.line-total');

    if (qtyInput && priceInput && totalInput) {
      const qty = parseFloat(qtyInput.value) || 0;
      const price = parseFloat(priceInput.value) || 0;
      const lineTotal = (qty * price).toFixed(2);
      totalInput.value = lineTotal;
      calculateGrandTotal();
    }
  });

 
  function calculateGrandTotal() {
    let grandTotal = 0;
    document.querySelectorAll('.line-total').forEach(input => {
      grandTotal += parseFloat(input.value) || 0;
    });
    document.getElementById('grandTotal').value = grandTotal.toFixed(2);
  }

  calculateGrandTotal();
</script>

@endsection