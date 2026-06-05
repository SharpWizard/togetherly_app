@extends('layouts.app')

@section('title', 'Edit Skill Post')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-5">
                    <h2 class="card-title mb-4">
                        <i class="fas fa-lightbulb text-success"></i> Edit Skill Post
                    </h2>

                    <form action="{{ route('skills.update', $skillPost) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="image" class="form-label">Skill Photo (optional)</label>
                            @if ($skillPost->image)
                                <div class="mb-2"><img src="{{ asset('storage/'.$skillPost->image) }}" style="max-width:200px;border-radius:10px;"></div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/*">
                            <small class="text-muted">Leave empty to keep the current photo. Max 2MB.</small>
                            @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Skill Name *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ $skillPost->title }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4" required>{{ $skillPost->description }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category *</label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="languages" {{ $skillPost->category == 'languages' ? 'selected' : '' }}>Languages</option>
                                <option value="cooking" {{ $skillPost->category == 'cooking' ? 'selected' : '' }}>Cooking</option>
                                <option value="music" {{ $skillPost->category == 'music' ? 'selected' : '' }}>Music</option>
                                <option value="coding" {{ $skillPost->category == 'coding' ? 'selected' : '' }}>Coding</option>
                                <option value="fitness" {{ $skillPost->category == 'fitness' ? 'selected' : '' }}>Fitness</option>
                                <option value="art" {{ $skillPost->category == 'art' ? 'selected' : '' }}>Art</option>
                                <option value="business" {{ $skillPost->category == 'business' ? 'selected' : '' }}>Business</option>
                                <option value="other" {{ $skillPost->category == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="skill_level" class="form-label">Your Skill Level *</label>
                                <select class="form-select @error('skill_level') is-invalid @enderror" id="skill_level" name="skill_level" required>
                                    <option value="beginner" {{ $skillPost->skill_level == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ $skillPost->skill_level == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ $skillPost->skill_level == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>
                                @error('skill_level')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="active" {{ $skillPost->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $skillPost->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="available_times" class="form-label">Available Times (optional)</label>
                            <textarea class="form-control @error('available_times') is-invalid @enderror"
                                      id="available_times" name="available_times" rows="2">{{ $skillPost->available_times }}</textarea>
                            @error('available_times')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Update Skill
                            </button>
                            <a href="{{ route('skills.show', $skillPost) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
