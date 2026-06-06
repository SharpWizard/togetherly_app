@extends('layouts.app')

@section('title', __('app.skills.create_title'))

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-5">
                    <h2 class="card-title mb-4">
                        <i class="fas fa-lightbulb text-success"></i> {{ __('app.skills.create_heading') }}
                    </h2>
                    <p class="text-muted mb-4">{{ __('app.skills.create_subtitle') }}</p>

                    <form action="{{ route('skills.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="image" class="form-label">{{ __('app.skills.photo') }}</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/*">
                            <small class="text-muted">{{ __('app.skills.photo_hint_create') }}</small>
                            @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('app.skills.skill_name') }} *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" placeholder="{{ __('app.skills.skill_name_placeholder') }}"
                                   value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('app.skills.description') }} *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4"
                                      placeholder="{{ __('app.skills.description_placeholder') }}"
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">{{ __('app.skills.category') }} *</label>
                            <select class="form-select @error('category') is-invalid @enderror"
                                    id="category" name="category" required>
                                <option value="">{{ __('app.skills.select_category') }}</option>
                                @foreach (['languages','cooking','music','coding','fitness','art','business','other'] as $cat)
                                    <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ __('app.skill_categories.'.$cat) }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="skill_level" class="form-label">{{ __('app.skills.skill_level') }} *</label>
                            <select class="form-select @error('skill_level') is-invalid @enderror"
                                    id="skill_level" name="skill_level" required>
                                <option value="">{{ __('app.skills.select_level') }}</option>
                                @foreach (['beginner','intermediate','advanced'] as $lvl)
                                    <option value="{{ $lvl }}" {{ old('skill_level') == $lvl ? 'selected' : '' }}>{{ __('app.skill_levels.'.$lvl) }}</option>
                                @endforeach
                            </select>
                            @error('skill_level')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="available_times" class="form-label">{{ __('app.skills.available_times') }}</label>
                            <textarea class="form-control @error('available_times') is-invalid @enderror"
                                      id="available_times" name="available_times" rows="2"
                                      placeholder="{{ __('app.skills.available_times_placeholder') }}">{{ old('available_times') }}</textarea>
                            @error('available_times')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-share"></i> {{ __('app.skills.submit_share') }}
                            </button>
                            <a href="{{ route('skills.index') }}" class="btn btn-secondary">{{ __('app.common.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
