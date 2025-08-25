@extends('layouts.adminlayout')

@section('style')
@endsection
@section('script')
<script>
$(document).ready(function () {
    // Initialize the DataTable
    var table = $('#categoryTable').DataTable();

    // Edit button click
    $('#categoryTable').on('click', '.btn-edit', function () {
        const row = $(this).closest('tr');
        const categoryId = row.data('id');
        const categoryName = row.find('td:nth-child(2)').text().trim();

        $('#editCategoryName').val(categoryName);
        $('#editModal').data('id', categoryId).modal('show');
    });

    // Save edited category
    $('#saveCategoryBtn').click(function () {
        const id = $('#editModal').data('id');
        const category = $('#editCategoryName').val();

        $.ajax({
            url: "{{ route('editCat') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                category: category
            },
            success: function (res) {
                // Update the row in DataTable without reloading
                var row = $('#categoryTable tr[data-id="' + id + '"]');
                table.cell(row.find('td:nth-child(2)')).data(category).draw(false);

                // Close modal
                $('#editModal').modal('hide');
            },
            error: function (err) {
                alert(err.responseJSON.errors.category[0]);
            }
        });
    });

    // Delete button click
    $('#categoryTable').on('click', '.btn-delete', function () {
        if (!confirm('Are you sure you want to delete this category?')) return;

        const row = $(this).closest('tr');
        const id = row.data('id');

       $.ajax({
    url: '/admin/category/delete/' + id,
    type: 'DELETE',
    data: { _token: "{{ csrf_token() }}" },
    success: function(res){
        if(res.success){
            table.row(row).remove().draw();
        } else {
            alert('Failed to delete category');
        }
    },
    error: function(err){
        alert('Failed to delete category');
    }
});

    });
});
</script>
@endsection


@section('main-content')
<div class="container py-4">

    <!-- Create Category Form -->
    <div class="card mb-4 border-0" style="background:#f8f9fa;">
        <div class="card-body">
            <h5 class="fw-semibold mb-3">Create Category</h5>
            <form action="{{ route('addCat') }}" method="POST"> 
                @csrf
                <div class="row g-2">
                    <div class="col-md-9">
                        <input type="text" name="category" class="form-control form-control-lg rounded-3" placeholder="Enter category name">
                    </div>
                    <div class="col-md-3 d-grid">
                        <button class="btn btn-dark btn-lg rounded-3">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Category Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="fw-semibold mb-4">Category List</h5>
            <table id="categoryTable" class="table align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $index => $category)
                    <tr data-id="{{ $category->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $category->category }}</td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-dark me-1 btn-edit">Edit</button>
                            <button class="btn btn-sm btn-outline-danger btn-delete">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h6 class="modal-title">Edit Category</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" id="editCategoryName" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-dark" id="saveCategoryBtn">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection
