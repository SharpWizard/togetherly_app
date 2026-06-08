@extends('layouts.app')

@section('title', 'Share Food')

@section('extra_css')
<style>
    .wizard-container { max-width: 900px; margin: 40px auto; }
    .wizard-progress { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; position: relative; }
    .wizard-progress::before { content: ''; position: absolute; top: 20px; left: 0; right: 0; height: 2px; background: #e2e8e4; z-index: 0; }
    .wizard-step { flex: 1; position: relative; z-index: 1; display: flex; flex-direction: column; align-items: center; }
    .wizard-step-num { width: 40px; height: 40px; border-radius: 50%; background: #fff; border: 2px solid #e2e8e4; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #9aa6a0; margin-bottom: 8px; }
    .wizard-step.active .wizard-step-num { background: var(--tg-green); color: #fff; border-color: var(--tg-green); }
    .wizard-step.completed .wizard-step-num { background: var(--tg-green); color: #fff; border-color: var(--tg-green); }
    .wizard-step-label { font-size: .9rem; font-weight: 600; text-align: center; color: #6b7770; }
    .wizard-step.active .wizard-step-label { color: var(--tg-green); font-weight: 700; }
    .wizard-content { background: #fff; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,.06); padding: 40px; margin-bottom: 30px; }
    .form-group { margin-bottom: 20px; }
    .form-label { font-weight: 600; color: #3c4a45; margin-bottom: 8px; display: block; }
    .form-control { padding: 12px 14px; border: 1px solid #e2e8e4; border-radius: 10px; font-size: .95rem; width: 100%; }
    .form-control:focus { border-color: var(--tg-green); outline: none; box-shadow: 0 0 0 3px rgba(45,143,127,.1); }
    .image-upload { border: 2px dashed var(--tg-green); border-radius: 12px; padding: 40px; text-align: center; cursor: pointer; transition: all .2s; }
    .image-upload:hover { background: rgba(45,143,127,.05); }
    .image-upload.dragover { background: rgba(45,143,127,.1); border-color: var(--tg-light); }
    .image-previews { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 12px; margin-top: 20px; }
    .image-preview { position: relative; border-radius: 10px; overflow: hidden; height: 120px; background: #f0f3f0; }
    .image-preview img { width: 100%; height: 100%; object-fit: cover; }
    .image-preview-delete { position: absolute; top: 4px; right: 4px; background: rgba(0,0,0,.6); color: #fff; border: none; width: 28px; height: 28px; border-radius: 50%; cursor: pointer; font-size: .9rem; }
    .preview-panel { position: sticky; top: 20px; background: linear-gradient(135deg,#ff8c42,#ff6f5e); color: #fff; border-radius: 16px; padding: 24px; }
    .preview-img { width: 100%; height: 200px; border-radius: 12px; overflow: hidden; background: rgba(0,0,0,.2); display: flex; align-items: center; justify-content: center; margin-bottom: 16px; }
    .preview-img img { width: 100%; height: 100%; object-fit: cover; }
    .preview-item { margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid rgba(255,255,255,.2); }
    .preview-item:last-child { border-bottom: none; }
    .preview-label { font-size: .85rem; opacity: .9; }
    .preview-value { font-weight: 700; font-size: .95rem; }
    .wizard-actions { display: flex; gap: 12px; justify-content: space-between; }
    .btn-wizard { padding: 12px 24px; border-radius: 10px; font-weight: 600; border: none; cursor: pointer; transition: all .2s; }
    .btn-primary-wizard { background: linear-gradient(135deg,var(--tg-green),var(--tg-light)); color: #fff; }
    .btn-primary-wizard:hover { opacity: .9; }
    .btn-secondary-wizard { background: #f0f3f0; color: #16302d; }
    .btn-secondary-wizard:hover { background: #e2e8e4; }
</style>
@endsection

@section('content')
<div class="wizard-container">
    <h1 class="fw-bold mb-1" style="text-align:center;">Share Food with Your Community</h1>
    <p class="text-muted text-center mb-5">Help reduce food waste - just 3 steps!</p>

    @if ($errors->any())
        <div class="alert alert-danger" style="background:#fdecea;border:1px solid #f5c2c0;color:#a4271f;border-radius:12px;padding:16px 20px;margin-bottom:24px;">
            <strong>Please fix the following before sharing:</strong>
            <ul style="margin:8px 0 0;padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Progress Bar -->
    <div class="wizard-progress mb-5">
        <div class="wizard-step active" id="step1-label">
            <div class="wizard-step-num">1</div>
            <div class="wizard-step-label">Details</div>
        </div>
        <div class="wizard-step" id="step2-label">
            <div class="wizard-step-num">2</div>
            <div class="wizard-step-label">Photos</div>
        </div>
        <div class="wizard-step" id="step3-label">
            <div class="wizard-step-num">3</div>
            <div class="wizard-step-label">Review</div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Form -->
        <div class="col-lg-8">
            <form id="foodForm" action="{{ route('food.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Step 1: Basic Details -->
                <div class="wizard-content step-content" id="step1">
                    <h4 class="fw-bold mb-4">Tell us about your food</h4>

                    <div class="form-group">
                        <label class="form-label">Food Title *</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g., Homemade Tomato Soup" value="{{ old('title') }}" required onchange="updatePreview()">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description *</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Tell people what it is and any ingredients/allergens..." required onchange="updatePreview()">{{ old('description') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Food Type *</label>
                                <select name="food_type" class="form-control" required onchange="updatePreview()">
                                    <option value="">Select type</option>
                                    <option value="cooked" @selected(old('food_type')=='cooked')>Cooked Meals</option>
                                    <option value="raw" @selected(old('food_type')=='raw')>Vegetables & Fruits</option>
                                    <option value="bakery" @selected(old('food_type')=='bakery')>Bakery</option>
                                    <option value="drinks" @selected(old('food_type')=='drinks')>Drinks</option>
                                    <option value="desserts" @selected(old('food_type')=='desserts')>Desserts</option>
                                    <option value="other" @selected(old('food_type')=='other')>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Quantity (number of portions) *</label>
                                <input type="number" name="quantity" class="form-control" min="1" step="1" placeholder="e.g., 5" value="{{ old('quantity', 1) }}" required onchange="updatePreview()">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Expires At *</label>
                        <input type="datetime-local" name="expires_at" class="form-control" value="{{ old('expires_at') }}" required onchange="updatePreview()">
                    </div>

                    <div class="wizard-actions">
                        <button type="button" class="btn-wizard btn-secondary-wizard" onclick="alert('No previous step')">← Back</button>
                        <button type="button" class="btn-wizard btn-primary-wizard" onclick="goToStep(2)">Next: Photos →</button>
                    </div>
                </div>

                <!-- Step 2: Photos -->
                <div class="wizard-content step-content" id="step2" style="display:none;">
                    <h4 class="fw-bold mb-4">Add Photos</h4>

                    <div class="form-group">
                        <label class="form-label">Upload Photos</label>
                        <div class="image-upload" id="uploadZone">
                            <i class="fas fa-cloud-upload-alt" style="font-size:2.5rem;color:var(--tg-green);margin-bottom:12px;"></i>
                            <p><strong>Drag photos here or click to upload</strong></p>
                            <small>Up to 5 images, max 5MB each</small>
                            <input type="file" name="images[]" multiple accept="image/*" id="fileInput" style="display:none;" onchange="handleFiles()">
                        </div>
                        <div class="image-previews" id="imagePreviews"></div>
                    </div>

                    <div class="wizard-actions">
                        <button type="button" class="btn-wizard btn-secondary-wizard" onclick="goToStep(1)">← Back</button>
                        <button type="button" class="btn-wizard btn-primary-wizard" onclick="goToStep(3)">Next: Review →</button>
                    </div>
                </div>

                <!-- Step 3: Review -->
                <div class="wizard-content step-content" id="step3" style="display:none;">
                    <h4 class="fw-bold mb-4">Review & Share</h4>
                    <div id="reviewContent"></div>

                    <div class="wizard-actions">
                        <button type="button" class="btn-wizard btn-secondary-wizard" onclick="goToStep(2)">← Back</button>
                        <button type="submit" class="btn-wizard btn-primary-wizard"><i class="fas fa-share-alt me-2"></i>Share Food</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Live Preview -->
        <div class="col-lg-4">
            <div class="preview-panel">
                <h6 class="fw-bold mb-3">Preview</h6>
                <div class="preview-img" id="previewImg">
                    <i class="fas fa-utensils" style="font-size:3rem;opacity:.5;"></i>
                </div>
                <div class="preview-item">
                    <div class="preview-label">Title</div>
                    <div class="preview-value" id="previewTitle">Enter a title...</div>
                </div>
                <div class="preview-item">
                    <div class="preview-label">Type</div>
                    <div class="preview-value" id="previewType">Select type...</div>
                </div>
                <div class="preview-item">
                    <div class="preview-label">Quantity</div>
                    <div class="preview-value" id="previewQty">Enter quantity...</div>
                </div>
                <div class="preview-item">
                    <div class="preview-label">Expires</div>
                    <div class="preview-value" id="previewExpiry">Select date...</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentStep = 1;
    let uploadedFiles = [];

    function goToStep(step) {
        document.querySelectorAll('.step-content').forEach(el => el.style.display = 'none');
        document.getElementById('step' + step).style.display = 'block';
        updateProgressBar(step);
        currentStep = step;
    }

    function updateProgressBar(step) {
        for (let i = 1; i <= 3; i++) {
            const label = document.getElementById('step' + i + '-label');
            if (i < step) label.classList.add('completed');
            if (i === step) label.classList.add('active');
            if (i > step) label.classList.remove('active', 'completed');
        }
    }

    function updatePreview() {
        const title = document.querySelector('[name="title"]').value || 'Enter a title...';
        const type = document.querySelector('[name="food_type"]').value || 'Select type...';
        const qty = document.querySelector('[name="quantity"]').value || 'Enter quantity...';
        const expiry = document.querySelector('[name="expires_at"]').value || 'Select date...';

        document.getElementById('previewTitle').textContent = title;
        document.getElementById('previewType').textContent = type;
        document.getElementById('previewQty').textContent = qty;
        document.getElementById('previewExpiry').textContent = expiry ? new Date(expiry).toLocaleDateString() : 'Select date...';
    }

    const uploadZone = document.getElementById('uploadZone');
    const fileInput = document.getElementById('fileInput');

    uploadZone.addEventListener('click', () => fileInput.click());
    uploadZone.addEventListener('dragover', e => {
        e.preventDefault();
        uploadZone.classList.add('dragover');
    });
    uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('dragover'));
    uploadZone.addEventListener('drop', e => {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
        fileInput.files = e.dataTransfer.files;
        handleFiles();
    });

    function handleFiles() {
        const files = Array.from(fileInput.files);
        const previews = document.getElementById('imagePreviews');
        previews.innerHTML = '';

        files.slice(0, 5).forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.className = 'image-preview';
                div.innerHTML = `<img src="${e.target.result}" alt="Preview">
                    <button type="button" class="image-preview-delete" onclick="removeImage(${idx})">×</button>`;
                previews.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeImage(idx) {
        const files = Array.from(fileInput.files);
        files.splice(idx, 1);
        const dt = new DataTransfer();
        files.forEach(f => dt.items.add(f));
        fileInput.files = dt.files;
        handleFiles();
    }
</script>
@endsection
