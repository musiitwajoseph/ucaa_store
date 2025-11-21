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
      <h4>PETTY CASH VOUCHER</h4>
    </div>

    <div class="card-body">
      <form>
        <!-- Header Fields -->
        <div class="row">
          
          <div class="col-md-6 mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" placeholder="" required>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label"><strong>Voucher</strong> No:</label>
            <input type="number" name="contract_no" class="form-control" placeholder="" required>
          
        </div>
        </div>


        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Payee:</label>
            <input type="text" name="supplier" class="form-control" placeholder="" required>
          
        </div>
          <div class="col-md-6 mb-3">
            <!-- <label class="form-label"><strong>Compliance</strong> form No:</label>
            <input type="text" name="delivery_note" class="form-control" placeholder="" required>
           -->
        </div>
        </div>
          

     
        <hr>

       
        <h5 class="mb-3">CASH VOUCHER</h5>

        <table class="table table-bordered" id="items_table">
          <thead class="table-secondary">
            <tr>
               
              <th>PARTICULARS</th>
               
              <th style="width: 130px;">CODE</th>
              <th style="width: 100px;">AMOUNT </th>
              <th style="width: 80px;">Remove</th>
              <!-- <th> return/ comment</th> -->
            </tr>
          </thead>
          <tbody>
            <tr>
                <td><input type="text" name="particulars[]" class="form-control" placeholder=""></td>
              <td><input type="text" name="code[]" class="form-control" placeholder=""></td>
              <td><input type="text" name="amount[]" class="form-control" placeholder=""></td>
           
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
              <span class="input-group-text">TOTAL</span>
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
          <td><input type="text" name="particulars[]" class="form-control" placeholder=""></td>
              <td><input type="text" name="code[]" class="form-control" placeholder=""></td>
              <td><input type="text" name="amount[]" class="form-control" placeholder=""></td>
                   
              
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