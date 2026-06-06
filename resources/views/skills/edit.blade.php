@extends('layouts.app')

@section('title', __('app.skills.edit_title'))

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-5">
                    <h2 class="card-title mb-4">
                        <i class="fas fa-lightbulb text-success"></i> {{ __('app.skills.edit_title') }}
                    </h2>

                    <form action="{{ route('skills.update', $skillPost) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="image" class="form-label">{{ __('app.skills.photo') }}</label>
                            @if ($skillPost->image)
                                <div class="mb-2"><img src="{{ asset('storage/'.$skillPost->image) }}" style="max-width:200px;border-radius:10px;"></div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/*">
                            <small class="text-muted">{{ __('app.skills.photo_hint_edit') }}</small>
                            @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('app.skills.skill_name') }} *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ $skillPost->title }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('app.skills.description') }} *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4" required>{{ $skillPost->description }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">{{ __('app.skills.category') }} *</label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                @foreach (['languages','cooking','music','coding','fitness','art','business','other'] as $cat)
                                    <option value="{{ $cat }}" {{ $skillPost->category == $cat ? 'selected' : '' }}>{{ __('app.skill_categories.'.$cat) }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="skill_level" class="form-label">{{ __('app.skills.skill_level') }} *</label>
                                <select class="form-select @error('skill_level') is-invalid @enderror" id="skill_level" name="skill_level" required>
                                    @foreach (['beginner','intermediate','advanced'] as $lvl)
                                        <option value="{{ $lvl }}" {{ $skillPost->skill_level == $lvl ? 'selected' : '' }}>{{ __('app.skill_levels.'.$lvl) }}</option>
                                    @endforeach
                                </select>
                                @error('skill_level')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">{{ __('app.skills.status') }} *</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="active" {{ $skillPost->status == 'active' ? 'selected' : '' }}>{{ __('app.skills.active') }}</option>
                                    <option value="inactive" {{ $skillPost->status == 'inactive' ? 'selected' : '' }}>{{ __('app.skills.inactive') }}</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="available_times" class="form-label">{{ __('app.skills.available_times') }}</label>
                            <textarea class="form-control @error('available_times') is-invalid @enderror"
                                      id="available_times" name="available_times" rows="2">{{ $skillPost->available_times }}</textarea>
                            @error('available_times')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> {{ __('app.skills.update_skill') }}
                            </button>
                            <a href="{{ route('skills.show', $skillPost) }}" class="btn btn-secondary">{{ __('app.common.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
