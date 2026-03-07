@php($selectedChannels = old('channels', isset($campaign) ? $campaign->channels->pluck('channel')->all() : []))
@php($statusOptions = isset($campaign) ? config('marketplace.campaign_statuses') : ['draft', 'published', 'receiving_proposals'])
@php($statusLabels = [
    'draft' => 'مسودة',
    'published' => 'منشورة',
    'receiving_proposals' => 'استقبال العروض',
    'under_review' => 'قيد المراجعة',
    'awarded' => 'تم الترسية',
    'in_progress' => 'قيد التنفيذ',
    'completed' => 'مكتملة',
    'cancelled' => 'ملغاة',
])

<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">عنوان الحملة</label>
        <input name="title" class="form-control" value="{{ old('title', $campaign->title ?? '') }}" required placeholder="مثال: حملة إطلاق منتج جديد">
    </div>
    <div class="col-md-4">
        <label class="form-label">الحالة</label>
        <select name="status" class="form-select">
            @foreach($statusOptions as $status)
                <option value="{{ $status }}" @selected(old('status', $campaign->status->value ?? 'draft') === $status)>{{ $statusLabels[$status] ?? $status }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">التصنيف</label>
        <select name="category_id" class="form-select" required>
            <option value="">اختر التصنيف</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $campaign->category_id ?? null) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">القطاع</label>
        <select name="industry_id" class="form-select">
            <option value="">اختر القطاع (اختياري)</option>
            @foreach($industries as $industry)
                <option value="{{ $industry->id }}" @selected(old('industry_id', $campaign->industry_id ?? null) == $industry->id)>{{ $industry->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">الهدف من الحملة</label>
        <input name="objective" class="form-control" value="{{ old('objective', $campaign->objective ?? '') }}" required placeholder="مثال: زيادة المبيعات بنسبة 20%">
    </div>
    <div class="col-md-6">
        <label class="form-label">الميزانية (ر.س)</label>
        <div class="input-group">
            <input type="number" step="0.01" min="1" name="budget" class="form-control" value="{{ old('budget', $campaign->budget ?? '') }}" required placeholder="5000">
            <span class="input-group-text">ر.س</span>
        </div>
    </div>
    <div class="col-md-4">
        <label class="form-label">تاريخ البداية</label>
        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', isset($campaign) && $campaign->start_date ? $campaign->start_date->format('Y-m-d') : '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">تاريخ النهاية</label>
        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', isset($campaign) && $campaign->end_date ? $campaign->end_date->format('Y-m-d') : '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">آخر موعد للعروض <span class="text-danger">*</span></label>
        <input type="date" name="proposal_deadline" class="form-control" value="{{ old('proposal_deadline', isset($campaign) ? $campaign->proposal_deadline?->format('Y-m-d') : '') }}" required>
    </div>
    <div class="col-12">
        <label class="form-label">وصف الحملة</label>
        <textarea name="description" rows="4" class="form-control" required placeholder="اشرح تفاصيل حملتك الإعلانية بالكامل...">{{ old('description', $campaign->description ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">الجمهور المستهدف</label>
        <textarea name="target_audience" rows="3" class="form-control" required placeholder="صف الجمهور المستهدف (العمر، الموقع، الاهتمامات...)">{{ old('target_audience', $campaign->target_audience ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">التسليمات المطلوبة</label>
        <textarea name="required_deliverables" rows="3" class="form-control" required placeholder="ما الذي تتوقع استلامه من الوكالة (تصاميم، فيديوهات، تقارير...)">{{ old('required_deliverables', $campaign->required_deliverables ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label d-block mb-2">القنوات المطلوبة</label>
        <div class="d-flex flex-wrap gap-3">
            @foreach($channels as $channel)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="channels[]" value="{{ $channel }}" id="ch_{{ md5($channel) }}" @checked(in_array($channel, $selectedChannels, true))>
                    <label class="form-check-label" for="ch_{{ md5($channel) }}">{{ $channel }}</label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-check mt-2">
            <input class="form-check-input" type="checkbox" name="allow_proposal_updates" value="1" id="allow_updates" @checked(old('allow_proposal_updates', $campaign->allow_proposal_updates ?? true))>
            <label class="form-check-label" for="allow_updates">السماح بتعديل العروض قبل الموعد النهائي</label>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label">مرفقات (اختياري)</label>
        <input type="file" name="attachments[]" class="form-control" multiple>
        <small class="text-muted">يمكنك إرفاق ملف البريف أو أي ملفات داعمة</small>
    </div>
</div>
