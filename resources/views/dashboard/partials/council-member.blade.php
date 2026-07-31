@php
    $photo = $member->photo_path ?: $defaultImage ?? '';
    $photoUrl = str_starts_with($photo, 'http') || str_starts_with($photo, 'data:') ? $photo : asset($photo);
@endphp

<article id="council-member-{{ $member->id }}" class="grid gap-5 rounded-xl border border-outline-variant/20 bg-surface-container-low p-5 md:grid-cols-[11rem_1fr_auto]">
    <div class="h-36 overflow-hidden rounded-lg bg-primary-fixed">
        <img class="h-full w-full object-cover" src="{{ $photoUrl }}" alt="{{ $member->photo_alt ?: $member->name }}">
    </div>
    <form id="council-form-{{ $member->id }}" class="grid gap-4 md:grid-cols-2" method="POST" action="{{ route('dashboard.council.update', $member->id) }}" enctype="multipart/form-data" data-ajax-form data-replace="#council-member-{{ $member->id }}">
        @csrf
        @method('PATCH')
        <div>
            <label class="campaign-label">Nombre</label>
            <input name="name" class="campaign-input bg-white" value="{{ $member->name }}" required>
        </div>
        <div>
            <label class="campaign-label">Cargo</label>
            <input name="position" class="campaign-input bg-white" value="{{ $member->position }}">
        </div>
        <div>
            <label class="campaign-label">Orden</label>
            <input name="sort_order" type="number" min="0" class="campaign-input bg-white" value="{{ $member->sort_order }}">
        </div>
        <div>
            <label class="campaign-label">Foto</label>
            <input name="photo" type="file" accept="image/*" class="campaign-input bg-white">
        </div>
        <div class="md:col-span-2">
            <label class="campaign-label">Descripción</label>
            <textarea name="bio" class="campaign-input bg-white" rows="2">{{ $member->bio }}</textarea>
        </div>
        <label class="flex items-center gap-3 text-sm font-semibold text-on-surface-variant">
            <input class="h-5 w-5 rounded border-outline text-primary focus:ring-primary" name="active" type="checkbox" value="1" @checked($member->active)>
            Mostrar en landing
        </label>
    </form>
    <div class="flex items-end gap-2 md:flex-col md:justify-end">
        <button class="rounded-lg p-2 text-primary transition hover:bg-primary/10" type="submit" form="council-form-{{ $member->id }}" aria-label="Guardar regidor">
            <span class="material-symbols-outlined">save</span>
        </button>
        <form method="POST" action="{{ route('dashboard.council.destroy', $member->id) }}" data-ajax-delete data-remove="#council-member-{{ $member->id }}">
            @csrf
            @method('DELETE')
            <button class="rounded-lg p-2 text-error transition hover:bg-error/10" type="submit" aria-label="Eliminar regidor">
                <span class="material-symbols-outlined">delete</span>
            </button>
        </form>
    </div>
</article>
