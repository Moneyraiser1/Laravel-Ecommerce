@extends('layouts.adminlayout')

@section('style')
@endsection

@section('script')
<script>
$(document).ready(function () {
    $('#userTable').DataTable();
});

// View User
$(document).on('click', '.btn-view', function (e) {
    e.preventDefault();
    const id = $(this).data('id');

    $.ajax({
        url: '{{ route("admin.user.show", ":id") }}'.replace(':id', id),
        type: 'GET',
        success: function (user) {
            // Populate modal fields
            $('#view-id').text(user.id);
            $('#view-name').text(user.name);
            $('#view-email').text(user.email);
            $('#view-phone').text(user.phone);
            $('#view-role').text(user.role);
            $('#view-created').text(user.created_at);

            // Show the modal
            $('#viewUserModal').modal('show');
        }
    });
});

// Delete User
$(document).on('click', '.btn-delete', function (e) {
    e.preventDefault();
    const id = $(this).data('id');

    if (confirm('Are you sure you want to delete this user?')) {
        $.ajax({
            url: '{{ route("admin.user.delete", ":id") }}'.replace(':id', id),
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function () {
                // Remove the row from the table
                $('button[data-id="' + id + '"]').closest('tr').remove();
            }
        });
    }
});
</script>
@endsection

@section('main-content')
<div class="container py-4">
  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <h5 class="fw-semibold mb-4">Users</h5>

      <table id="userTable" class="table align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Role</th>
            <th class="text-end">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $index => $user)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->role }}</td>
            <td class="text-end">
              <button class="btn btn-sm btn-outline-dark btn-view" data-id="{{ $user->id }}">View</button>
              <button class="btn btn-sm btn-outline-danger btn-delete" data-id="{{ $user->id }}">Delete</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- View User Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewUserModalLabel">User Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table">
          <tr><th>ID</th><td id="view-id"></td></tr>
          <tr><th>Name</th><td id="view-name"></td></tr>
          <tr><th>Email</th><td id="view-email"></td></tr>
          <tr><th>Phone</th><td id="view-phone"></td></tr>
          <tr><th>Role</th><td id="view-role"></td></tr>
          <tr><th>Created At</th><td id="view-created"></td></tr>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
