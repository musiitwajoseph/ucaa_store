@extends('layouts.app')

@section('content')

<div class="container mt-4">
  <div class="card shadow">
    <div class="card-header bg-primary text-white text-center">
      <h4>ISSUING NOTE</h4>
    </div>

    <div class="card-body">
      <form>
        <!-- Header Fields -->
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><strong>FORM</strong> No:</label>
            <input type="text" name="contract_no" class="form-control" placeholder="Auto" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" placeholder="DD/MM/YYYY" required>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <!-- <label class="form-label">Supplier</label>
            <input type="text" name="supplier" class="form-control" placeholder="Supplier Name" required>
           -->
        </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><strong>COST CENTRE:</strong> RESPONSE_CODE</label>
            <input type="text" name="delivery_note" class="form-control" placeholder="" required>
          </div>
        </div>

     
        <hr>

        <!-- Items Section -->
        <h5 class="mb-3">Item Issued</h5>

        <table class="table table-bordered" id="items_table">
          <thead class="table-secondary">
            <tr>
              <th style="width: 90px;">QTY REQ</th>
              <th style="width: 120px;">UNIT</th>
               <th style="width: 120px;">QTY REQ IN WORDS</th>
              <th>ITEM DESCRIPTION</th>
              <th style="width: 100px;">QTY ISSUED</th>
              <th style="width: 140px;">QTY ISSUED IN WORDS</th>
              <th style="width: 80px;">Remove</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="number" name="qty_req[]" class="form-control" min="0" step="1"></td>
              <td><input type="text" name="unit[]" class="form-control" min="0" step="1"></td>
              <td><input type="text" name="qty_req_words[]" class="form-control" placeholder=""></td>
              <td><input type="text" name="description[]" class="form-control" placeholder="Description"></td>
              <td><input type="number" name="qty_issued[]" class="form-control" placeholder=""></td>
               <td><input type="text" name="qty_issued_words[]" class="form-control" placeholder=""></td>
              
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
       <td><input type="number" name="qty_req[]" class="form-control" min="0" step="1"></td>
              <td><input type="text" name="unit[]" class="form-control" min="0" step="1"></td>
              <td><input type="text" name="qty_req_words[]" class="form-control" placeholder=""></td>
              <td><input type="text" name="description[]" class="form-control" placeholder="Description"></td>
              <td><input type="number" name="qty_issued[]" class="form-control" placeholder=""></td>
               <td><input type="text" name="qty_issued_words[]" class="form-control" placeholder=""></td>
              
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