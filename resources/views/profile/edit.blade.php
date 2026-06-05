@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container my-4 my-lg-5" style="max-width:720px;">
    <h2 class="section-title mb-4"><i class="fas fa-pen me-2"></i>Edit Profile</h2>

    <div class="card">
        <div class="card-body p-4 p-lg-5">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Avatar --}}
                <div class="d-flex align-items-center gap-3 mb-4">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/'.$user->avatar) }}" alt="" style="width:80px;height:80px;border-radius:50%;object-fit:cover;">
                    @else
                        <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,var(--tg-orange),var(--tg-coral));color:#fff;display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:700;">
                            {{ strtoupper(substr($user->name,0,1)) }}
                        </div>
                    @endif
                    <div class="flex-grow-1">
                        <label for="avatar" class="form-label">Profile Photo</label>
                        <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar" accept="image/*">
                        <small class="text-muted">JPG/PNG, max 2MB</small>
                        @error('avatar')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="Tell neighbors a little about yourself…">{{ old('bio', $user->bio) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="neighborhood" class="form-label">Neighborhood / District</label>
                        <input type="text" class="form-control @error('neighborhood') is-invalid @enderror" id="neighborhood" name="neighborhood" value="{{ old('neighborhood', $user->profile?->neighborhood) }}" required>
                        @error('neighborhood')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="account_type" class="form-label">Account Type</label>
                        <select class="form-select" id="account_type" name="account_type">
                            @php $at = old('account_type', $user->profile?->account_type ?? 'individual'); @endphp
                            <option value="individual" {{ $at==='individual'?'selected':'' }}>Individual</option>
                            <option value="business" {{ $at==='business'?'selected':'' }}>Business</option>
                            <option value="restaurant" {{ $at==='restaurant'?'selected':'' }}>Restaurant</option>
                        </select>
                        <small class="text-muted">Businesses & restaurants can earn a verified green badge.</small>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Save Changes</button>
                    <a href="{{ route('profile.show', $user) }}" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
