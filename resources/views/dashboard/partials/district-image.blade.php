@php
    $photo = $image->image_path ?: $defaultImage ?? '';
    $photoUrl = str_starts_with($photo, 'http') || str_starts_with($photo, 'data:') ? $photo : asset($photo);
@endphp

<article id="district-image-{{ $image->id }}" class="grid gap-5 rounded-xl border border-outline-variant/20 bg-surface-container-low p-5 md:grid-cols-[11rem_1fr_auto]">
    <div class="h-36 overflow-hidden rounded-lg bg-primary-fixed">
        <img class="h-full w-full object-cover" src="{{ $photoUrl }}" alt="{{ $image->image_alt ?: $image->title }}">
    </div>
    <form id="district-form-{{ $image->id }}" class="grid gap-4 md:grid-cols-2" method="POST" action="{{ route('dashboard.district.update', $image->id) }}" enctype="multipart/form-data" data-ajax-form data-replace="#district-image-{{ $image->id }}">
        @csrf
        @method('PATCH')
        <div>
            <label class="campaign-label">Título</label>
            <input name="title" class="campaign-input bg-white" value="{{ $image->title }}">
        </div>
        <div>
            <label class="campaign-label">Layout</label>
            <select name="layout" class="campaign-input bg-white">
                @foreach (['featured' => 'Destacada', 'small' => 'Pequeña', 'wide' => 'Ancha'] as $value => $label)
                    <option value="{{ $value }}" @selected($image->layout === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="campaign-label">Orden</label>
            <input name="sort_order" type="number" min="0" class="campaign-input bg-white" value="{{ $image->sort_order }}">
        </div>
        <div>
            <label class="campaign-label">Foto</label>
            <input name="image" type="file" accept="image/*" class="campaign-input bg-white">
        </div>
        <div class="md:col-span-2">
            <label class="campaign-label">Descripción</label>
            <textarea name="description" class="campaign-input bg-white" rows="2">{{ $image->description }}</textarea>
        </div>
        <input type="hidden" name="image_path" value="{{ $image->image_path }}">
        <label class="flex items-center gap-3 text-sm font-semibold text-on-surface-variant">
            <input class="h-5 w-5 rounded border-outline text-primary focus:ring-primary" name="active" type="checkbox" value="1" @checked($image->active)>
            Mostrar en landing
        </label>
    </form>
    <div class="flex items-end gap-2 md:flex-col md:justify-end">
        <button class="rounded-lg p-2 text-primary transition hover:bg-primary/10" type="submit" form="district-form-{{ $image->id }}" aria-label="Guardar foto">
            <span class="material-symbols-outlined">save</span>
        </button>
        <form method="POST" action="{{ route('dashboard.district.destroy', $image->id) }}" data-ajax-delete data-remove="#district-image-{{ $image->id }}">
            @csrf
            @method('DELETE')
            <button class="rounded-lg p-2 text-error transition hover:bg-error/10" type="submit" aria-label="Eliminar foto">
                <span class="material-symbols-outlined">delete</span>
            </button>
        </form>
    </div>
</article>
