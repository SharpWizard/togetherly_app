@extends('layouts.app')

@section('title', __('app.food.edit_title'))

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-5">
                    <h2 class="card-title mb-4">
                        <i class="fas fa-utensils text-warning"></i> {{ __('app.food.edit_title') }}
                    </h2>

                    <form action="{{ route('food.update', $foodPost) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('app.food.food_title') }} *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ $foodPost->title }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('app.food.description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ $foodPost->description }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="food_type" class="form-label">{{ __('app.food.food_type') }} *</label>
                            <select class="form-select @error('food_type') is-invalid @enderror"
                                    id="food_type" name="food_type" required>
                                @foreach (['cooked','raw','bakery','drinks','desserts','leftovers','other'] as $ft)
                                    <option value="{{ $ft }}" {{ $foodPost->food_type == $ft ? 'selected' : '' }}>{{ __('app.food_types.'.$ft) }}</option>
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
                                       id="quantity" name="quantity" min="1" value="{{ $foodPost->quantity }}" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">{{ __('app.food.status') }} *</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    @foreach (['available','claimed','expired'] as $st)
                                        <option value="{{ $st }}" {{ $foodPost->status == $st ? 'selected' : '' }}>{{ __('app.statuses.'.$st) }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">{{ __('app.food.photo') }}</label>
                            @if ($foodPost->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $foodPost->image) }}" style="max-width: 200px; border-radius: 8px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/*">
                            <small class="text-muted">{{ __('app.food.photo_hint') }}</small>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> {{ __('app.food.update_post') }}
                            </button>
                            <a href="{{ route('food.show', $foodPost) }}" class="btn btn-secondary">{{ __('app.common.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
