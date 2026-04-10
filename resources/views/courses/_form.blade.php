{{-- Partial form dùng chung cho create & edit --}}
<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label fw-medium">Tên khóa học <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $course->name ?? '') }}"
               placeholder="Nhập tên khóa học...">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-medium">Giá (đ) <span class="text-danger">*</span></label>
        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
               value="{{ old('price', $course->price ?? '') }}"
               placeholder="0" min="0.01" step="any">
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-medium">Mô tả</label>
        <textarea name="description" rows="4"
                  class="form-control @error('description') is-invalid @enderror"
                  placeholder="Mô tả ngắn về khóa học...">{{ old('description', $course->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-medium">Ảnh khóa học</label>
        @if(isset($course) && $course->image)
            <div class="mb-2">
                <img src="{{ $course->image_url }}" width="120" class="rounded shadow-sm" alt="Ảnh hiện tại">
                <small class="d-block text-muted mt-1">Ảnh hiện tại</small>
            </div>
        @endif
        <input type="file" name="image"
               class="form-control @error('image') is-invalid @enderror"
               accept="image/jpeg,image/png,image/jpg,image/gif">
        <div class="form-text">JPEG, PNG, JPG, GIF. Tối đa 2MB.</div>
        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-medium">Trạng thái <span class="text-danger">*</span></label>
        <select name="status" class="form-select @error('status') is-invalid @enderror">
            <option value="draft"     {{ old('status', $course->status ?? '') === 'draft'     ? 'selected' : '' }}>
                ✏️ Draft
            </option>
            <option value="published" {{ old('status', $course->status ?? '') === 'published' ? 'selected' : '' }}>
                ✅ Published
            </option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
