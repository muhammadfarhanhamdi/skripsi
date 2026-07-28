@if(! empty($message))
    <div class="rounded-2xl border px-4 py-4 text-sm {{ $type === 'error' ? 'border-rose-200 bg-rose-50 text-rose-700' : 'border-emerald-200 bg-emerald-50 text-emerald-700' }} mb-6">
        {{ $message }}
    </div>
@endif
