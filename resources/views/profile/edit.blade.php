@extends('layouts.app')

@section('title', __('app.profile.edit_title'))

@section('content')
<div class="container my-4 my-lg-5" style="max-width:720px;">
    <h2 class="section-title mb-4"><i class="fas fa-pen me-2"></i>{{ __('app.profile.edit_title') }}</h2>

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
                        <label for="avatar" class="form-label">{{ __('app.profile.profile_photo') }}</label>
                        <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar" accept="image/*">
                        <small class="text-muted">{{ __('app.profile.photo_hint') }}</small>
                        @error('avatar')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">{{ __('app.profile.full_name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">{{ __('app.profile.phone') }}</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="bio" class="form-label">{{ __('app.profile.bio') }}</label>
                    <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="{{ __('app.profile.bio_placeholder') }}">{{ old('bio', $user->bio) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="neighborhood" class="form-label">{{ __('app.profile.neighborhood') }}</label>
                        <input type="text" class="form-control @error('neighborhood') is-invalid @enderror" id="neighborhood" name="neighborhood" value="{{ old('neighborhood', $user->profile?->neighborhood) }}" required>
                        @error('neighborhood')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="account_type" class="form-label">{{ __('app.profile.account_type') }}</label>
                        <select class="form-select" id="account_type" name="account_type">
                            @php $at = old('account_type', $user->profile?->account_type ?? 'individual'); @endphp
                            <option value="individual" {{ $at==='individual'?'selected':'' }}>{{ __('app.profile.individual') }}</option>
                            <option value="business" {{ $at==='business'?'selected':'' }}>{{ __('app.profile.business') }}</option>
                            <option value="restaurant" {{ $at==='restaurant'?'selected':'' }}>{{ __('app.profile.restaurant') }}</option>
                        </select>
                        <small class="text-muted">{{ __('app.profile.account_type_hint') }}</small>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>{{ __('app.profile.save_changes') }}</button>
                    <a href="{{ route('profile.show', $user) }}" class="btn btn-light">{{ __('app.common.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
