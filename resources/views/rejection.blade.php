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
      <h4>STORE REJECTION FORM</h4>
    </div>

    <div class="card-body">
      <form>
        <!-- Header Fields -->
        <div class="row">
          
          <div class="col-md-6 mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" placeholder="DD/MM/YYYY" required>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label"><strong>Supplier's</strong> Del No:</label>
            <input type="text" name="contract_no" class="form-control" placeholder="" required>
          </div>
        </div>

        
        <div class="mb-3">
          <label class="form-label"><strong>Supplier's</strong> Name</label>
          <input type="text" name="invoice_no" class="form-control" placeholder="" required>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><strong>CAA</strong> Purchase order/Contract No:</label>
            <input type="text" name="supplier" class="form-control" placeholder="No:" required>
          
        </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><strong>Compliance</strong> form No:</label>
            <input type="text" name="delivery_note" class="form-control" placeholder="" required>
          </div>
        </div>

        

          <div class="row">
          <div class="col-md-6 mb-3">
        <label class="form-label"><strong>Supplier's</strong> Invoice No</label>
          <input type="text" name="invoice_no" class="form-control" placeholder="" required>
        
        </div>
          <div class="col-md-6 mb-3">
            <!-- <label class="form-label"><strong>Compliance</strong> form No:</label>
            <input type="text" name="delivery_note" class="form-control" placeholder="" required> -->
          </div>
        </div>

          

     
        <hr>

       
        <h5 class="mb-3"></h5>

        <table class="table table-bordered" id="items_table">
          <thead class="table-secondary">
            <tr>
              <th style="width: 180px;">No</th>
              <th>Description</th>
               <th style="width: 120px;">Unit </th>
              <th style="width: 100px;">QTY </th>
              <th style="width: 100px;">QTY Rejected </th>
              <th style="width: 80px;">Remove</th>
            </tr>
          </thead>
          <tbody>
            <tr>
               <td><input type="text" name="item[]" class="form-control" min="0" step="1"></td>
              <td><input type="text" name="description[]" class="form-control" placeholder="Description"></td>
              <td><input type="text" name="unit[]" class="form-control" placeholder=""></td>
              <td><input type="number" name="qty[]" class="form-control" placeholder=""></td>
              <td><input type="number" name="qty_rejected[]" class="form-control" placeholder=""></td> 
              <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm removeRow">✕</button>
              </td>
            </tr>
          </tbody>
        </table>

        <div class="mb-3">
          <button type="button" id="addRow" class="btn btn-secondary btn-sm">+ Add Item</button>
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
         <td><input type="text" name="item[]" class="form-control" min="0" step="1"></td>
              <td><input type="text" name="description[]" class="form-control" placeholder="Description"></td>
              <td><input type="text" name="unit[]" class="form-control" placeholder=""></td>
              <td><input type="number" name="qty[]" class="form-control" placeholder=""></td>
              <td><input type="number" name="qty_rejected[]" class="form-control" placeholder=""></td> 
                    
              
        <td class="text-center">
          <button type="button" class="btn btn-danger btn-sm removeRow">✕</button>
        </td>
      </tr>
    `;
    tableBody.insertAdjacentHTML('beforeend', newRow);
  });

  document.addEventListener('click', function(e){
        if(e.target && e.target.classList.contains('removeRow')){
            e.target.closest('tr').remove();
        }
    });

 

</script>

@endsection