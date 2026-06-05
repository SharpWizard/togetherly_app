@extends('layouts.app')

@section('title', 'Edit Food Post')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-5">
                    <h2 class="card-title mb-4">
                        <i class="fas fa-utensils text-warning"></i> Edit Food Post
                    </h2>

                    <form action="{{ route('food.update', $foodPost) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Food Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ $foodPost->title }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ $foodPost->description }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="food_type" class="form-label">Food Type *</label>
                            <select class="form-select @error('food_type') is-invalid @enderror"
                                    id="food_type" name="food_type" required>
                                <option value="cooked" {{ $foodPost->food_type == 'cooked' ? 'selected' : '' }}>Cooked Meal</option>
                                <option value="raw" {{ $foodPost->food_type == 'raw' ? 'selected' : '' }}>Raw Ingredients</option>
                                <option value="bakery" {{ $foodPost->food_type == 'bakery' ? 'selected' : '' }}>Bakery</option>
                                <option value="drinks" {{ $foodPost->food_type == 'drinks' ? 'selected' : '' }}>Drinks</option>
                                <option value="desserts" {{ $foodPost->food_type == 'desserts' ? 'selected' : '' }}>Desserts</option>
                                <option value="leftovers" {{ $foodPost->food_type == 'leftovers' ? 'selected' : '' }}>Leftovers</option>
                                <option value="other" {{ $foodPost->food_type == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('food_type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label">Quantity *</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                       id="quantity" name="quantity" min="1" value="{{ $foodPost->quantity }}" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="available" {{ $foodPost->status == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="claimed" {{ $foodPost->status == 'claimed' ? 'selected' : '' }}>Claimed</option>
                                    <option value="expired" {{ $foodPost->status == 'expired' ? 'selected' : '' }}>Expired</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Food Photo (optional)</label>
                            @if ($foodPost->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $foodPost->image) }}" style="max-width: 200px; border-radius: 8px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/*">
                            <small class="text-muted">Max 2MB. Formats: JPG, PNG, GIF</small>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Update Post
                            </button>
                            <a href="{{ route('food.show', $foodPost) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
