{{-- Partial form dùng chung cho lesson create & edit --}}
<div class="row g-3">
    <div class="col-md-9">
        <label class="form-label fw-medium">Tiêu đề <span class="text-danger">*</span></label>
        <input type="text" name="title"
               class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title', $lesson->title ?? '') }}"
               placeholder="Tiêu đề bài học...">
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label fw-medium">Thứ tự <span class="text-danger">*</span></label>
        <input type="number" name="order"
               class="form-control @error('order') is-invalid @enderror"
               value="{{ old('order', $lesson->order ?? 1) }}"
               min="1">
        @error('order')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-medium">Video URL</label>
        <input type="url" name="video_url"
               class="form-control @error('video_url') is-invalid @enderror"
               value="{{ old('video_url', $lesson->video_url ?? '') }}"
               placeholder="https://youtube.com/watch?v=...">
        @error('video_url')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-medium">Nội dung</label>
        <textarea name="content" rows="6"
                  class="form-control @error('content') is-invalid @enderror"
                  placeholder="Nội dung bài học...">{{ old('content', $lesson->content ?? '') }}</textarea>
        @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
