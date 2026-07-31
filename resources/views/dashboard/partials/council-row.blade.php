@php
    $photo = $member->photo_path ?: $defaultImage ?? '';
    $photoUrl = str_starts_with($photo, 'http') || str_starts_with($photo, 'data:') ? $photo : asset($photo);
    $fill = [
        'name' => $member->name,
        'position' => $member->position,
        'sort_order' => $member->sort_order,
        'bio' => $member->bio,
        'image_path' => $member->photo_path,
        'active' => (bool) $member->active,
    ];
    $fillB64 = base64_encode(json_encode($fill, JSON_UNESCAPED_UNICODE));
@endphp

<tr id="council-row-{{ $member->id }}" class="border-b border-outline-variant/20 last:border-0" data-sortable-item data-id="{{ $member->id }}">
    <td class="px-4 py-4">
        <div class="flex items-center gap-3">
            <button class="shrink-0 cursor-grab rounded-lg p-1.5 text-on-surface-variant transition hover:bg-primary/10 hover:text-primary active:cursor-grabbing" type="button" data-drag-handle aria-label="Reordenar regidor">
                <span class="material-symbols-outlined text-[20px]">drag_indicator</span>
            </button>
            <img class="h-12 w-12 rounded-lg object-cover" src="{{ $photoUrl }}" alt="{{ $member->photo_alt ?: $member->name }}">
            <div>
                <p class="text-[14px] font-bold text-on-surface">{{ $member->name }}</p>
                <p class="text-[13px] font-semibold uppercase tracking-wide text-secondary">{{ $member->position }}</p>
            </div>
        </div>
    </td>
    <td class="px-4 py-4">
        <p class="max-w-xl truncate text-[13px] text-on-surface-variant">{{ $member->bio }}</p>
    </td>
    <td class="px-4 py-4 text-[13px] text-on-surface-variant"><span data-order-label>{{ $member->sort_order }}</span></td>
    <td class="px-4 py-4">
        <span class="rounded-full px-3 py-1 text-[12px] font-semibold {{ $member->active ? 'bg-primary-fixed text-primary' : 'bg-surface-container text-on-surface-variant' }}">
            {{ $member->active ? 'Visible' : 'Oculto' }}
        </span>
    </td>
    <td class="px-4 py-4 text-right">
        <div class="inline-flex items-center gap-2">
            <button
                class="rounded-lg p-2 text-primary transition hover:bg-primary/10"
                type="button"
                data-open-modal="council-modal"
                data-mode="edit"
                data-action="{{ route('dashboard.council.update', $member->id) }}"
                data-replace="#council-row-{{ $member->id }}"
                data-fill-b64="{{ $fillB64 }}"
                aria-label="Editar regidor"
            >
                <span class="material-symbols-outlined text-[20px]">edit</span>
            </button>
            <form method="POST" action="{{ route('dashboard.council.destroy', $member->id) }}" data-ajax-delete data-remove="#council-row-{{ $member->id }}">
                @csrf
                @method('DELETE')
                <button class="rounded-lg p-2 text-error transition hover:bg-error/10" type="submit" aria-label="Retirar regidor">
                    <span class="material-symbols-outlined text-[20px]">delete</span>
                </button>
            </form>
        </div>
    </td>
</tr>
