<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">السعر المقترح (USD)</label>
        <input type="number" step="0.01" min="1" name="proposed_price" class="form-control" value="{{ old('proposed_price', $proposal->proposed_price ?? '') }}" required>
    </div>
    <div class="col-md-8">
        <label class="form-label">المدة الزمنية</label>
        <input name="execution_timeline" class="form-control" value="{{ old('execution_timeline', $proposal->execution_timeline ?? '') }}" required>
    </div>
    <div class="col-12">
        <label class="form-label">ملخص الفكرة / الاستراتيجية</label>
        <textarea name="strategy_summary" rows="4" class="form-control" required>{{ old('strategy_summary', $proposal->strategy_summary ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">الخبرة ذات الصلة</label>
        <textarea name="relevant_experience" rows="3" class="form-control">{{ old('relevant_experience', $proposal->relevant_experience ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">ملاحظات إضافية</label>
        <textarea name="notes" rows="3" class="form-control">{{ old('notes', $proposal->notes ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">مرفقات</label>
        <input type="file" name="attachments[]" class="form-control" multiple>
    </div>
</div>
