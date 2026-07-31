@php
    $image = $proposal->image_path ?: $defaultImage ?? '';
    $imageUrl = str_starts_with($image, 'http') || str_starts_with($image, 'data:') ? $image : asset($image);
    $fill = [
        'title' => $proposal->title,
        'category' => $proposal->category,
        'icon' => $proposal->icon,
        'sort_order' => $proposal->sort_order,
        'summary' => $proposal->summary,
        'image_path' => $proposal->image_path,
        'active' => (bool) $proposal->active,
        'is_featured' => (bool) $proposal->is_featured,
    ];
    $fillB64 = base64_encode(json_encode($fill, JSON_UNESCAPED_UNICODE));
@endphp

<tr id="proposal-row-{{ $proposal->id }}" class="border-b border-outline-variant/20 last:border-0" data-sortable-item data-id="{{ $proposal->id }}">
    <td class="px-4 py-4">
        <div class="flex items-center gap-3">
            <button class="shrink-0 cursor-grab rounded-lg p-1.5 text-on-surface-variant transition hover:bg-primary/10 hover:text-primary active:cursor-grabbing" type="button" data-drag-handle aria-label="Reordenar propuesta">
                <span class="material-symbols-outlined text-[20px]">drag_indicator</span>
            </button>
            <img class="h-12 w-12 shrink-0 rounded-lg object-cover" src="{{ $imageUrl }}" alt="{{ $proposal->image_alt ?: $proposal->title }}">
            <div>
                <p class="text-[14px] font-bold text-on-surface">{{ $proposal->title }}</p>
                <p class="max-w-xl truncate text-[13px] text-on-surface-variant">{{ $proposal->summary }}</p>
            </div>
        </div>
    </td>
    <td class="px-4 py-4 text-[13px] font-semibold text-primary">{{ $proposal->category ?: 'General' }}</td>
    <td class="px-4 py-4 text-[13px] text-on-surface-variant"><span data-order-label>{{ $proposal->sort_order }}</span></td>
    <td class="px-4 py-4">
        <span class="rounded-full px-3 py-1 text-[12px] font-semibold {{ $proposal->active ? 'bg-primary-fixed text-primary' : 'bg-surface-container text-on-surface-variant' }}">
            {{ $proposal->active ? 'Visible' : 'Oculta' }}
        </span>
    </td>
    <td class="px-4 py-4 text-right">
        <div class="inline-flex items-center gap-2">
            <button
                class="rounded-lg p-2 text-primary transition hover:bg-primary/10"
                type="button"
                data-open-modal="proposal-modal"
                data-mode="edit"
                data-action="{{ route('dashboard.proposals.update', $proposal->id) }}"
                data-replace="#proposal-row-{{ $proposal->id }}"
                data-fill-b64="{{ $fillB64 }}"
                aria-label="Editar propuesta"
            >
                <span class="material-symbols-outlined text-[20px]">edit</span>
            </button>
            <form method="POST" action="{{ route('dashboard.proposals.destroy', $proposal->id) }}" data-ajax-delete data-remove="#proposal-row-{{ $proposal->id }}">
                @csrf
                @method('DELETE')
                <button class="rounded-lg p-2 text-error transition hover:bg-error/10" type="submit" aria-label="Retirar propuesta">
                    <span class="material-symbols-outlined text-[20px]">delete</span>
                </button>
            </form>
        </div>
    </td>
</tr>
