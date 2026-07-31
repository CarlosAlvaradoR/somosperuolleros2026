@php
    $fill = [
        'contributor_name' => $contribution->contributor_name,
        'contribution_type' => $contribution->contribution_type,
        'amount' => $contribution->amount,
        'contribution_date' => $contribution->contribution_date,
        'sort_order' => $contribution->sort_order,
        'detail' => $contribution->detail,
        'active' => (bool) $contribution->active,
    ];
    $fillB64 = base64_encode(json_encode($fill, JSON_UNESCAPED_UNICODE));
@endphp

<tr id="contribution-row-{{ $contribution->id }}" class="border-b border-outline-variant/20 last:border-0" data-sortable-item data-id="{{ $contribution->id }}">
    <td class="px-4 py-4">
        <div class="flex items-start gap-3">
            <button class="mt-0.5 shrink-0 cursor-grab rounded-lg p-1.5 text-on-surface-variant transition hover:bg-primary/10 hover:text-primary active:cursor-grabbing" type="button" data-drag-handle aria-label="Reordenar aportante">
                <span class="material-symbols-outlined text-[20px]">drag_indicator</span>
            </button>
            <div>
                <p class="text-[14px] font-bold text-on-surface">{{ $contribution->contributor_name }}</p>
                <p class="text-[13px] text-on-surface-variant">{{ $contribution->detail }}</p>
            </div>
        </div>
    </td>
    <td class="px-4 py-4 text-[13px] font-semibold text-primary">{{ $contribution->contribution_type ?: 'Aporte' }}</td>
    <td class="px-4 py-4 text-[14px] font-bold text-on-surface">
        {{ $contribution->currency ?: 'PEN' }} {{ number_format((float) $contribution->amount, 2) }}
    </td>
    <td class="px-4 py-4 text-[13px] text-on-surface-variant">
        {{ $contribution->contribution_date ? \Illuminate\Support\Carbon::parse($contribution->contribution_date)->format('d/m/Y') : '-' }}
    </td>
    <td class="px-4 py-4 text-[13px] text-on-surface-variant"><span data-order-label>{{ $contribution->sort_order }}</span></td>
    <td class="px-4 py-4">
        <span class="rounded-full px-3 py-1 text-[12px] font-semibold {{ $contribution->active ? 'bg-primary-fixed text-primary' : 'bg-surface-container text-on-surface-variant' }}">
            {{ $contribution->active ? 'Publicado' : 'Oculto' }}
        </span>
    </td>
    <td class="px-4 py-4 text-right">
        <div class="inline-flex items-center gap-2">
            <button
                class="rounded-lg p-2 text-primary transition hover:bg-primary/10"
                type="button"
                data-open-modal="contribution-modal"
                data-mode="edit"
                data-action="{{ route('dashboard.contributions.update', $contribution->id) }}"
                data-replace="#contribution-row-{{ $contribution->id }}"
                data-fill-b64="{{ $fillB64 }}"
                aria-label="Editar aportante"
            >
                <span class="material-symbols-outlined text-[20px]">edit</span>
            </button>
            <form method="POST" action="{{ route('dashboard.contributions.destroy', $contribution->id) }}" data-ajax-delete data-remove="#contribution-row-{{ $contribution->id }}">
                @csrf
                @method('DELETE')
                <button class="rounded-lg p-2 text-error transition hover:bg-error/10" type="submit" aria-label="Retirar aportante">
                    <span class="material-symbols-outlined text-[20px]">delete</span>
                </button>
            </form>
        </div>
    </td>
</tr>
