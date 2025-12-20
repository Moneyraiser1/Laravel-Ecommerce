@extends('layouts.adminlayout')

@section('style')
<link href="{{ asset('js/select2/select2.min.css') }}" rel="stylesheet"/>
@endsection

@section('main-content')
  <!-- Product Form -->
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
      <h5 class="fw-semibold mb-4">Add New Product</h5>
      <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
          <div class="col-md-4">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" id="name" class="form-control">
          </div>

          <div class="col-md-4">
            <label for="images" class="form-label">Product Images (up to 4)</label>
            <input type="file"  name="images[]" id="images" class="form-control" accept="image/*" multiple>
          </div>

          <div class="col-md-2">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01">
          </div>

          <div class="col-md-2">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control">
          </div>

          <div class="col-md-4">
            <label for="category" class="form-label">Category</label>
            <select id="category" name="category_id" class="form-select">
              <option value="">Select Category</option>
              @foreach ($categories as $category)
              <option value="{{ $category->id }}">{{ $category->category }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-4">
            <label for="status" class="form-label">Product Label</label>
            <select id="status" name="status" class="form-select">
              <option value="new">New</option>
              <option value="trending">Trending</option>
              <option value="popular">Popular</option>
              <option value="sale">On Sale</option>
            </select>
          </div>

          <div class="col-md-12">
            <label for="description" class="form-label">Product Description</label>
            <textarea id="description" name="description" class="form-control"></textarea>
          </div>

          <div class="col-md-12 mt-3">
            <button type="submit" class="btn btn-primary">Add Product</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Product Table -->
  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <h5 class="fw-semibold mb-4">Products</h5>
      <table id="productTable" class="table align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Label</th>
            <th class="text-end">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($products as $index => $product) 
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $product->name }}</td>
            <td>#{{ $product->price }}</td>
            <td>{{ $product->stock }}</td>
            <td>
              <span class="badge 
                @if($product->status == 'new') bg-success 
                @elseif($product->status == 'trending') bg-info 
                @elseif($product->status == 'popular') bg-warning text-dark 
                @elseif($product->status == 'sale') bg-danger 
                @endif">{{ ucfirst($product->status) }}</span>
            </td>
            <td class="text-end">
              <button class="btn btn-sm btn-outline-primary me-1 btn-view" data-id="{{ $product->id }}">View</button>
                <button class="btn btn-sm btn-outline-dark me-1 btn-edit" data-id="{{ $product->id }}">Edit</button>


              <form action="{{ route('admin.product.delete',$product->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-outline-danger">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- Product Details Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productModalLabel">Product Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row">
          <!-- Left: Images Carousel -->
          <div class="col-md-5 mb-3 mb-md-0">
            <div class="owl-carousel owl-theme" id="productImagesCarousel" style="max-height:400px; overflow:hidden;"></div>
          </div>

          <!-- Right: Product Details Table -->
          <div class="col-md-6" style="max-height:350px; overflow-y:auto;">
            <table class="table table-bordered text-wrap">
              <tbody id="productDetailsTable"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="editProductForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">

          <input type="hidden" id="edit-id" name="id"/>

          <div class="row g-3">
            <!-- Name -->
            <div class="col-md-6">
              <label class="form-label" for="edit-name">Product Name</label>
              <input type="text" name="name" id="edit-name" class="form-control">
            </div>

            <!-- Price -->
            <div class="col-md-6">
              <label class="form-label" for="edit-price">Price</label>
              <input type="number" name="price" id="edit-price" step="0.01" class="form-control">
            </div>

            <!-- Stock -->
            <div class="col-md-6">
              <label class="form-label" for="edit-stock">Stock</label>
              <input type="number" name="stock" id="edit-stock" class="form-control">
            </div>

            <!-- Category -->
            <div class="col-md-6">
              <label class="form-label" for="edit-category">Category</label>
              <select name="category_id" id="edit-category" class="form-select">
                @foreach($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->category }}</option>
                @endforeach
              </select>
            </div>

            <!-- Status -->
            <div class="col-md-6">
              <label class="form-label" for="edit-status">Status</label>
              <select name="status" id="edit-status" class="form-select">
                <option value="new">New</option>
                <option value="trending">Trending</option>
                <option value="popular">Popular</option>
                <option value="sale">On Sale</option>
              </select>
            </div>

            <!-- Replace Images -->
            <div class="col-md-12">
              <label class="form-label" for="edit-images">Replace Images (optional)</label>
              <input type="file" name="images[]" id="edit-images" class="form-control" accept="image/*" multiple>
            </div>
          </div> <!-- /row -->
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('script')
<script>
// Open and load edit modal
$(document).on('click', '.btn-edit', function(e){
    e.preventDefault();
    const id = $(this).data('id');

    $.get('{{ route("admin.product.show", ":id") }}'.replace(':id', id), function(product){

        $('#edit-id').val(product.id);
        $('#edit-name').val(product.name);
        $('#edit-price').val(product.price);
        $('#edit-stock').val(product.stock);
       $('#edit-category').val(product.category_id);

        $('#edit-status').val(product.status);

        // simply open the modal (no TinyMCE required anymore)
        $('#editProductModal').modal('show');
    });
});



// Submit Edit Modal via AJAX
$('#editProductForm').on('submit', function(e){
    e.preventDefault();
    const id = $('#edit-id').val();

    // Build the formData object (for image upload)
    let formData = new FormData(this);

    $.ajax({
        url: '{{ route("admin.product.update", ":id") }}'.replace(':id', id),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(){
            $('#editProductModal').modal('hide');
            location.reload();
        },
        error: function(){
            alert('Failed to update product');
        }
    });
});


// --- Submit Edit Modal via AJAX ---
$('#editProductForm').on('submit', function (e) {
  e.preventDefault();

  const id = $('#edit-id').val();

  // Create the form data object (required for files)
  let formData = new FormData(this);

  $.ajax({
    url: '{{ route("admin.product.update", ":id") }}'.replace(':id', id),
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function (res) {
      // Close the modal
      $('#editProductModal').modal('hide');

      // Optionally reload the page or update the row
      location.reload();  // reload page to reflect the updated product
    },
    error: function(){
      alert('Failed to update product');
    }
  });
});
$(document).ready(function () {
    // Initialize DataTable and Select2
    $('#productTable').DataTable();
    $('#category').select2({ placeholder: "Select Category", allowClear: true });

    // Initialize TinyMCE
    tinymce.init({ 
        selector:'#description', 
        height:200, 
        menubar:false, 
        plugins:'lists link image table code', 
        toolbar:'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code' 
    });

    // Product View Modal with Owl Carousel
    var owl = $("#productImagesCarousel");

    $('.btn-view').click(function(){
    var productId = $(this).data('id');

    $.ajax({
        url: '{{ route("admin.product.show", ":id") }}'.replace(':id', productId),
        type: 'GET',
        success: function(product){
            $('#productModalLabel').text(product.name);

            var owl = $("#productImagesCarousel");

            // Reset carousel
            if (owl.hasClass("owl-loaded")) {
                owl.trigger('destroy.owl.carousel');
                owl.html('').removeClass("owl-loaded").find(".owl-stage-outer").children().unwrap();
            } else {
                owl.html('');
            }

            // Add images
            if(product.images && product.images.length){
                product.images.forEach(function(img){
                    owl.append('<div class="item"><img src="{{ asset("uploads") }}/'+img+'" class="img-fluid" style="width:100%;height:100%;object-fit:cover;"></div>');
                });
            } else {
                owl.append('<div class="item"><img src="https://via.placeholder.com/400x400?text=No+Image" class="img-fluid"></div>');
            }

            // Initialize carousel AFTER modal is fully shown
            $('#productModal').on('shown.bs.modal', function(){
                owl.owlCarousel({
                    items:1,
                    loop:true,
                    nav:true,
                    dots:true,
                    autoHeight:true
                });
            });

            // Populate details table
            var detailsHtml = `
                <tr><th>ID</th><td>${product.id}</td></tr>
                <tr><th>Name</th><td>${product.name}</td></tr>
                <tr><th>Price</th><td>#${product.price}</td></tr>
                <tr><th>Stock</th><td>${product.stock}</td></tr>
                <tr><th>Category</th><td>${product.category_id}</td></tr>
                <tr><th>Status</th><td>${product.status}</td></tr>
                <tr><th>Description</th><td>${product.description}</td></tr>
                <tr><th>Created At</th><td>${product.created_at}</td></tr>
                <tr><th>Updated At</th><td>${product.updated_at}</td></tr>
            `;
            $('#productDetailsTable').html(detailsHtml);

            $('#productModal').modal('show');
        },
        error: function(){
            alert('Unable to fetch product details.');
        }
    });
});

});
</script>
@endsection
