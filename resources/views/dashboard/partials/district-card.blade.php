@php
    $photo = $image->image_path ?: $defaultImage ?? '';
    $photoUrl = str_starts_with($photo, 'http') || str_starts_with($photo, 'data:') ? $photo : asset($photo);
    $fill = [
        'title' => $image->title,
        'layout' => $image->layout,
        'sort_order' => $image->sort_order,
        'description' => $image->description,
        'image_path' => $image->image_path,
        'active' => (bool) $image->active,
    ];
    $fillB64 = base64_encode(json_encode($fill, JSON_UNESCAPED_UNICODE));
@endphp

<article id="district-card-{{ $image->id }}" class="overflow-hidden rounded-xl border border-outline-variant/20 bg-white shadow-sm" data-sortable-item data-id="{{ $image->id }}">
    <img class="h-44 w-full object-cover" src="{{ $photoUrl }}" alt="{{ $image->image_alt ?: $image->title }}">
    <div class="p-4">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-[14px] font-bold text-on-surface">{{ $image->title ?: 'Foto del distrito' }}</p>
                <p class="mt-1 line-clamp-2 text-[13px] leading-6 text-on-surface-variant">{{ $image->description }}</p>
            </div>
            <span class="rounded-full bg-primary-fixed px-2.5 py-1 text-[11px] font-semibold text-primary">{{ $image->layout }}</span>
        </div>
        <div class="mt-4 flex items-center justify-between">
            <span class="text-[12px] font-semibold text-on-surface-variant">Orden <span data-order-label>{{ $image->sort_order }}</span></span>
            <div class="flex items-center gap-2">
                <button class="cursor-grab rounded-lg p-2 text-on-surface-variant transition hover:bg-primary/10 hover:text-primary active:cursor-grabbing" type="button" data-drag-handle aria-label="Reordenar foto">
                    <span class="material-symbols-outlined text-[20px]">drag_indicator</span>
                </button>
                <button
                    class="rounded-lg p-2 text-primary transition hover:bg-primary/10"
                    type="button"
                    data-open-modal="district-modal"
                    data-mode="edit"
                    data-action="{{ route('dashboard.district.update', $image->id) }}"
                    data-replace="#district-card-{{ $image->id }}"
                    data-fill-b64="{{ $fillB64 }}"
                    aria-label="Editar foto"
                >
                    <span class="material-symbols-outlined text-[20px]">edit</span>
                </button>
                <form method="POST" action="{{ route('dashboard.district.destroy', $image->id) }}" data-ajax-delete data-remove="#district-card-{{ $image->id }}">
                    @csrf
                    @method('DELETE')
                    <button class="rounded-lg p-2 text-error transition hover:bg-error/10" type="submit" aria-label="Retirar foto">
                        <span class="material-symbols-outlined text-[20px]">delete</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</article>
