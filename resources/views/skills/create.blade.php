@extends('layouts.app')

@section('title', 'Share a Skill')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-5">
                    <h2 class="card-title mb-4">
                        <i class="fas fa-lightbulb text-success"></i> Share Your Skill
                    </h2>
                    <p class="text-muted mb-4">Teach what you know. Help others learn. Build community connections!</p>

                    <form action="{{ route('skills.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="image" class="form-label">Skill Photo (optional)</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/*">
                            <small class="text-muted">A photo of your work helps attract learners. Max 2MB.</small>
                            @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Skill Name *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" placeholder="e.g., Spanish Language, Photography, Cooking"
                                   value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4"
                                      placeholder="Describe what you teach, what students will learn, experience level required..."
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category *</label>
                            <select class="form-select @error('category') is-invalid @enderror"
                                    id="category" name="category" required>
                                <option value="">Select category...</option>
                                <option value="languages" {{ old('category') == 'languages' ? 'selected' : '' }}>Languages</option>
                                <option value="cooking" {{ old('category') == 'cooking' ? 'selected' : '' }}>Cooking</option>
                                <option value="music" {{ old('category') == 'music' ? 'selected' : '' }}>Music</option>
                                <option value="coding" {{ old('category') == 'coding' ? 'selected' : '' }}>Coding</option>
                                <option value="fitness" {{ old('category') == 'fitness' ? 'selected' : '' }}>Fitness</option>
                                <option value="art" {{ old('category') == 'art' ? 'selected' : '' }}>Art</option>
                                <option value="business" {{ old('category') == 'business' ? 'selected' : '' }}>Business</option>
                                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="skill_level" class="form-label">Your Skill Level *</label>
                            <select class="form-select @error('skill_level') is-invalid @enderror"
                                    id="skill_level" name="skill_level" required>
                                <option value="">Select level...</option>
                                <option value="beginner" {{ old('skill_level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ old('skill_level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ old('skill_level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                            @error('skill_level')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="available_times" class="form-label">Available Times (optional)</label>
                            <textarea class="form-control @error('available_times') is-invalid @enderror"
                                      id="available_times" name="available_times" rows="2"
                                      placeholder="e.g., Monday & Wednesday 6-8 PM, Weekends anytime">{{ old('available_times') }}</textarea>
                            @error('available_times')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-share"></i> Share Skill
                            </button>
                            <a href="{{ route('skills.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
