@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">

            <!-- Profile Edit Form -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between">
                        <h4 class="mb-0">{{ __('Edit Profile') }}</h4>
                        <div class="d-flex">
                            <a class="btn btn-warning me-2 text-white" href="{{ route('profile.comments') }}">
                                {{ __('My Comments') }}
                            </a>
                            <a class="btn btn-warning text-white" href="{{ route('profile.ratings') }}">
                                {{ __('My Ratings') }}
                            </a>
                        </div>
                    </div>
                </div>

                @if (session('status'))
                    <div class="alert alert-success mb-0" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card-body">
                    <!-- Profile Edit Form -->
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                        </div>

                        <!-- Avatar -->
                        <div class="mb-4">
                            <label for="avatar" class="form-label">{{ __('Avatar') }}</label>
                            <input type="file" class="form-control" id="avatar" name="avatar">
                            @if(auth()->user()->avatar)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/avatars/' . auth()->user()->avatar) }}" alt="Avatar" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                    </form>

                    <!-- Reset Password Form -->
                    <form method="POST" action="{{ route('password.update') }}" class="mt-4">
                        @csrf
                        @method('PUT')

                        <!-- Current Password -->
                        <div class="mb-4">
                            <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>

                        <!-- New Password -->
                        <div class="mb-4">
                            <label for="new_password" class="form-label">{{ __('New Password') }}</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>

                        <!-- Confirm New Password -->
                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label">{{ __('Confirm New Password') }}</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">{{ __('Update Password') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
