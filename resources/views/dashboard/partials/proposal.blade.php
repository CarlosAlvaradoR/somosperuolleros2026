@php
    $photo = $proposal->image_path ?: $defaultImage ?? '';
    $photoUrl = str_starts_with($photo, 'http') || str_starts_with($photo, 'data:') ? $photo : asset($photo);
@endphp

<article id="proposal-{{ $proposal->id }}" class="grid gap-5 rounded-xl border border-outline-variant/20 bg-surface-container-low p-5 md:grid-cols-[12rem_1fr]">
    <div class="space-y-3">
        <div class="h-32 overflow-hidden rounded-lg bg-primary-fixed">
            <img class="h-full w-full object-cover" src="{{ $photoUrl }}" alt="{{ $proposal->image_alt ?: $proposal->title }}">
        </div>
        <span class="inline-flex rounded-full bg-primary-fixed px-3 py-1 text-[12px] font-semibold text-primary">
            {{ $proposal->active ? 'Visible en landing' : 'Oculta' }}
        </span>
    </div>

    <form id="proposal-form-{{ $proposal->id }}" class="grid gap-4 md:grid-cols-2" method="POST" action="{{ route('dashboard.proposals.update', $proposal->id) }}" data-ajax-form data-replace="#proposal-{{ $proposal->id }}">
        @csrf
        @method('PATCH')

        <div>
            <label class="campaign-label" for="title-{{ $proposal->id }}">Título de propuesta</label>
            <input id="title-{{ $proposal->id }}" name="title" class="campaign-input bg-white" value="{{ $proposal->title }}" required>
        </div>
        <div>
            <label class="campaign-label" for="category-{{ $proposal->id }}">Categoria</label>
            <input id="category-{{ $proposal->id }}" name="category" class="campaign-input bg-white" value="{{ $proposal->category }}">
        </div>
        <div>
            <label class="campaign-label" for="icon-{{ $proposal->id }}">Icono</label>
            <input id="icon-{{ $proposal->id }}" name="icon" class="campaign-input bg-white" value="{{ $proposal->icon }}" placeholder="water_drop">
        </div>
        <div>
            <label class="campaign-label" for="order-{{ $proposal->id }}">Orden</label>
            <input id="order-{{ $proposal->id }}" name="sort_order" type="number" min="0" class="campaign-input bg-white" value="{{ $proposal->sort_order }}">
        </div>
        <div class="md:col-span-2">
            <label class="campaign-label" for="summary-{{ $proposal->id }}">Descripción</label>
            <textarea id="summary-{{ $proposal->id }}" name="summary" class="campaign-input bg-white" rows="2">{{ $proposal->summary }}</textarea>
        </div>
        <div class="md:col-span-2">
            <label class="campaign-label" for="image-{{ $proposal->id }}">URL de foto</label>
            <input id="image-{{ $proposal->id }}" name="image_path" class="campaign-input bg-white" value="{{ $proposal->image_path }}">
        </div>
        <label class="flex items-center gap-3 text-sm font-semibold text-on-surface-variant">
            <input class="h-5 w-5 rounded border-outline text-primary focus:ring-primary" name="active" type="checkbox" value="1" @checked($proposal->active)>
            Mostrar en landing
        </label>
        <label class="flex items-center gap-3 text-sm font-semibold text-on-surface-variant">
            <input class="h-5 w-5 rounded border-outline text-primary focus:ring-primary" name="is_featured" type="checkbox" value="1" @checked($proposal->is_featured)>
            Destacada
        </label>

        <div class="flex flex-col gap-3 sm:flex-row md:col-span-2 md:justify-end">
            <button class="campaign-button-primary justify-center text-sm" type="submit">
                <span class="material-symbols-outlined text-[20px]">save</span>
                Guardar propuesta
            </button>
            <button class="inline-flex items-center justify-center gap-2 rounded-xl border border-error px-5 py-3 text-[14px] font-semibold text-error transition hover:bg-error/10" type="submit" form="proposal-delete-{{ $proposal->id }}">
                <span class="material-symbols-outlined text-[20px]">delete</span>
                Retirar
            </button>
        </div>
    </form>

    <form id="proposal-delete-{{ $proposal->id }}" method="POST" action="{{ route('dashboard.proposals.destroy', $proposal->id) }}" data-ajax-delete data-remove="#proposal-{{ $proposal->id }}" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</article>
