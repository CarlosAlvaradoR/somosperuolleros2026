<article id="contribution-{{ $contribution->id }}" class="grid gap-4 rounded-xl border border-outline-variant/20 bg-surface-container-low p-5 md:grid-cols-[1fr_auto]">
    <form id="contribution-form-{{ $contribution->id }}" class="grid gap-4 md:grid-cols-4" method="POST" action="{{ route('dashboard.contributions.update', $contribution->id) }}" data-ajax-form data-replace="#contribution-{{ $contribution->id }}">
        @csrf
        @method('PATCH')
        <div>
            <label class="campaign-label">Aportante</label>
            <input name="contributor_name" class="campaign-input bg-white" value="{{ $contribution->contributor_name }}" required>
        </div>
        <div>
            <label class="campaign-label">Tipo</label>
            <input name="contribution_type" class="campaign-input bg-white" value="{{ $contribution->contribution_type }}">
        </div>
        <div>
            <label class="campaign-label">Monto</label>
            <input name="amount" type="number" min="0" step="0.01" class="campaign-input bg-white" value="{{ $contribution->amount }}">
        </div>
        <div>
            <label class="campaign-label">Fecha</label>
            <input name="contribution_date" type="date" class="campaign-input bg-white" value="{{ $contribution->contribution_date }}">
        </div>
        <div class="md:col-span-4">
            <label class="campaign-label">Detalle</label>
            <textarea name="detail" class="campaign-input bg-white" rows="2">{{ $contribution->detail }}</textarea>
        </div>
        <input type="hidden" name="currency" value="{{ $contribution->currency ?: 'PEN' }}">
        <label class="flex items-center gap-3 text-sm font-semibold text-on-surface-variant">
            <input class="h-5 w-5 rounded border-outline text-primary focus:ring-primary" name="active" type="checkbox" value="1" @checked($contribution->active)>
            Mostrar en landing
        </label>
    </form>
    <div class="flex items-end gap-2 md:flex-col md:justify-end">
        <button class="rounded-lg p-2 text-primary transition hover:bg-primary/10" type="submit" form="contribution-form-{{ $contribution->id }}" aria-label="Guardar aporte">
            <span class="material-symbols-outlined">save</span>
        </button>
        <form method="POST" action="{{ route('dashboard.contributions.destroy', $contribution->id) }}" data-ajax-delete data-remove="#contribution-{{ $contribution->id }}">
            @csrf
            @method('DELETE')
            <button class="rounded-lg p-2 text-error transition hover:bg-error/10" type="submit" aria-label="Eliminar aporte">
                <span class="material-symbols-outlined">delete</span>
            </button>
        </form>
    </div>
</article>
