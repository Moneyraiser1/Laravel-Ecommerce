@extends('layouts.userlayout')

@section('content')
<div class="container mt-4 p-5">
    <h2>My Profile</h2>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error) {{ $error }} <br> @endforeach
        </div>
    @endif

    <div class="row">
        <!-- Update Profile Info -->
        <div class="col-md-4">
            <div class="card p-3 shadow-sm mb-3">
                <h4>Update Details</h4>
                <form method="POST" action="{{ route('user.profile.update') }}">
                    @csrf
                    <div class="form-group mb-2">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    </div>
                    <button type="submit" class="btn btn-success mt-2">Update Details</button>
                </form>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-md-4">
            <div class="card p-3 shadow-sm mb-3">
                <h4>Change Password</h4>
                <form method="POST" action="{{ route('user.profile.password') }}">
                    @csrf
                    <div class="form-group mb-2">
                        <label>Current Password</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Update Password</button>
                </form>
            </div>
        </div>

        <!-- Recent Purchases -->
        <div class="col-md-4">
            <div class="card p-3 shadow-sm mb-3">
                <h4>Recent Purchases</h4>
                @if($recentOrders->isEmpty())
                    <p>No recent purchases.</p>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach($recentOrders as $order)
                            <li class="list-group-item d-flex align-items-center">
                              
                                <div>
                                    <strong>{{ $order->name }}</strong>  
                                    <br>
                                    Qty: {{ $order->quantity }} | ₦{{ number_format($order->price, 2) }}
                                    <br>
                                    <small>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
