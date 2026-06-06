@extends('layouts.app')

@section('title', __('app.food.create_title'))

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-5">
                    <h2 class="card-title mb-4">
                        <i class="fas fa-utensils text-warning"></i> {{ __('app.food.create_title') }}
                    </h2>
                    <p class="text-muted mb-4">{{ __('app.food.create_subtitle') }}</p>

                    <form action="{{ route('food.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('app.food.food_title') }} *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" placeholder="{{ __('app.food.food_title_placeholder') }}"
                                   value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('app.food.description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3"
                                      placeholder="{{ __('app.food.description_placeholder') }}">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="food_type" class="form-label">{{ __('app.food.food_type') }} *</label>
                            <select class="form-select @error('food_type') is-invalid @enderror"
                                    id="food_type" name="food_type" required>
                                <option value="">{{ __('app.food.select_type') }}</option>
                                @foreach (['cooked','raw','bakery','drinks','desserts','leftovers','other'] as $ft)
                                    <option value="{{ $ft }}" {{ old('food_type') == $ft ? 'selected' : '' }}>{{ __('app.food_types.'.$ft) }}</option>
                                @endforeach
                            </select>
                            @error('food_type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label">{{ __('app.food.quantity') }} *</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                       id="quantity" name="quantity" min="1" value="{{ old('quantity', 1) }}" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="expires_at" class="form-label">{{ __('app.food.available_until') }} *</label>
                                <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror"
                                       id="expires_at" name="expires_at" value="{{ old('expires_at') }}" required>
                                @error('expires_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">{{ __('app.food.photo') }}</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/*">
                            <small class="text-muted">{{ __('app.food.photo_hint') }}</small>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-share"></i> {{ __('app.food.submit_share') }}
                            </button>
                            <a href="{{ route('food.index') }}" class="btn btn-secondary">{{ __('app.common.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
