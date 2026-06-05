@extends('layouts.app')

@section('title', 'Share Food')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-5">
                    <h2 class="card-title mb-4">
                        <i class="fas fa-utensils text-warning"></i> Share Food
                    </h2>
                    <p class="text-muted mb-4">Post surplus food in 30 seconds. Neighbors will get instant notifications!</p>

                    <form action="{{ route('food.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Food Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" placeholder="e.g., Homemade Pizza, Fresh Vegetables"
                                   value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3"
                                      placeholder="Describe the food, ingredients, preparation details...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="food_type" class="form-label">Food Type *</label>
                            <select class="form-select @error('food_type') is-invalid @enderror"
                                    id="food_type" name="food_type" required>
                                <option value="">Select type...</option>
                                <option value="cooked" {{ old('food_type') == 'cooked' ? 'selected' : '' }}>Cooked Meal</option>
                                <option value="raw" {{ old('food_type') == 'raw' ? 'selected' : '' }}>Raw Ingredients</option>
                                <option value="bakery" {{ old('food_type') == 'bakery' ? 'selected' : '' }}>Bakery</option>
                                <option value="drinks" {{ old('food_type') == 'drinks' ? 'selected' : '' }}>Drinks</option>
                                <option value="desserts" {{ old('food_type') == 'desserts' ? 'selected' : '' }}>Desserts</option>
                                <option value="leftovers" {{ old('food_type') == 'leftovers' ? 'selected' : '' }}>Leftovers</option>
                                <option value="other" {{ old('food_type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('food_type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label">Quantity *</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                       id="quantity" name="quantity" min="1" value="{{ old('quantity', 1) }}" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="expires_at" class="form-label">Available Until *</label>
                                <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror"
                                       id="expires_at" name="expires_at" value="{{ old('expires_at') }}" required>
                                @error('expires_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Food Photo (optional)</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/*">
                            <small class="text-muted">Max 2MB. Formats: JPG, PNG, GIF</small>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-share"></i> Share Food
                            </button>
                            <a href="{{ route('food.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
