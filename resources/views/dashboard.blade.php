<x-app-layout>
    <x-slot name="title">Dashboard | Somos Perú Olleros</x-slot>
    <x-slot name="header">
        <h1 class="font-headline text-2xl font-extrabold text-primary">Configuración del sitio</h1>
    </x-slot>

    @php
        $defaultImage = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIj48cmVjdCB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgcng9IjgiIGZpbGw9IiNlOGVhZWQiLz48cGF0aCBkPSJNMTcwIDEzMCBsMzAgNDAgbDIwLTE1IGw0MCA1NSBIMTQweiIgZmlsbD0iI2JkYzFjNiIvPjxjaXJjbGUgY3g9IjI1MCIgY3k9IjEyMCIgcj0iMTgiIGZpbGw9IiNiZGMxYzYiLz48L3N2Zz4=';
        $assetImage = fn (?string $path) => $path && (str_starts_with($path, 'http') || str_starts_with($path, 'data:')) ? $path : ($path ? asset($path) : $defaultImage);
        $heroForm = $heroContent ?? (object) [
            'eyebrow' => 'Candidato a Alcalde 2026',
            'title' => 'Agua, chacra y futuro para',
            'highlighted_title' => 'Olleros',
            'description' => 'Mirko Cacha, candidato a la alcaldía distrital de Olleros. Un plan de gobierno construido desde el canal, la chacra y la plaza — no desde un escritorio.',
            'primary_button_label' => 'Súmate al cambio',
            'primary_button_url' => '#sumate',
            'secondary_button_label' => 'Ver Plan de Gobierno',
            'secondary_button_url' => '#plan',
            'campaign_year' => 2026,
            'image_path' => '',
        ];
        $bioForm = $candidateBio ?? (object) [
            'title' => 'Mirko Cacha: experiencia y compromiso',
            'summary' => 'Contador público colegiado con trayectoria en gestión pública, administración municipal y docencia. Conoce de cerca la realidad del campo, el turno de agua, la educación rural y las necesidades de cada caserío.',
            'image_path' => '',
            'facts' => json_encode(['Gestión pública', 'Trayectoria académica', 'Trabajo comunal'], JSON_UNESCAPED_UNICODE),
        ];
        $bioFactsText = collect(json_decode($bioForm->facts ?? '[]', true) ?: [])->implode("\n");
    @endphp

    <div class="space-y-8">
        <div
            class="fixed right-6 top-24 z-[80] max-w-sm rounded-xl border border-primary/20 bg-white px-5 py-4 text-sm font-semibold text-primary shadow-2xl"
            x-data="{ show: {{ session('status') ? 'true' : 'false' }}, message: @js(session('status', '')) }"
            x-show="show"
            x-cloak
            x-transition
            x-init="if (show) setTimeout(() => show = false, 2600); window.addEventListener('dashboard-saved', event => { message = event.detail.message; show = true; setTimeout(() => show = false, 2600); })"
            x-text="message"
        ></div>

        @if ($errors->any())
            <div class="rounded-xl border border-secondary/20 bg-secondary-fixed px-5 py-4 text-secondary">
                <p class="font-bold">Revisa los datos ingresados.</p>
                <ul class="mt-2 list-inside list-disc text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="grid gap-5 md:grid-cols-4" x-show="dashboardPanel === 'inicio'" x-cloak>
            @foreach ([
                ['visibility', 'Secciones activas', $stats['visible_sections'], 'Landing pública'],
                ['groups', 'Voluntarios', $stats['supporters'], 'Registrados'],
                ['payments', 'Aportes', 'S/ ' . number_format((float) $stats['contributions'], 2), 'Declarados'],
                ['sports_soccer', 'Copa Olleros', $stats['football_teams'], 'Equipos interesados'],
            ] as [$icon, $label, $value, $hint])
                <article class="campaign-card p-6">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-primary-fixed text-primary">
                        <span class="material-symbols-outlined">{{ $icon }}</span>
                    </div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-on-surface-variant">{{ $label }}</p>
                    <p class="mt-2 font-headline text-[28px] font-extrabold leading-tight text-primary">
                        @if ($label === 'Secciones activas')
                            <span data-visible-sections>{{ $value }}</span>
                        @else
                            {{ $value }}
                        @endif
                    </p>
                    <p class="mt-1 text-[13px] text-on-surface-variant">{{ $hint }}</p>
                </article>
            @endforeach
        </section>

        <section class="campaign-card p-6 md:p-8" x-show="dashboardPanel === 'inicio'" x-cloak>
            <div class="mb-6">
                <h2 class="font-headline text-[24px] font-bold text-on-surface">Paneles de gestion</h2>
                <p class="mt-1 text-[14px] text-on-surface-variant">Elige que contenido quieres editar. Cada panel guarda sin recargar la página.</p>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                @foreach ([
                    ['portada', 'home_app_logo', 'Portada', 'Edita la portada, la foto principal y la biografía.'],
                    ['propuestas', 'description', 'Propuestas', 'Edita los pilares del plan de gobierno.'],
                    ['regidores', 'groups', 'Regidores', 'Actualiza el equipo municipal y sus fotos.'],
                    ['galeria', 'photo_library', 'Galería', 'Administra las imágenes del distrito.'],
                    ['transparencia', 'account_balance_wallet', 'Transparencia', 'Registra aportantes y detalles públicos.'],
                    ['configuracion', 'visibility', 'Configuración', 'Muestra u oculta secciones de la landing.'],
                ] as [$panel, $icon, $title, $description])
                    <button class="rounded-xl border border-outline-variant/30 bg-white p-5 text-left transition hover:border-primary/50 hover:bg-primary/5" type="button" x-on:click="openDashboardPanel('{{ $panel }}')">
                        <span class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary-fixed text-primary">
                            <span class="material-symbols-outlined text-[22px]">{{ $icon }}</span>
                        </span>
                        <span class="block text-[15px] font-bold text-primary">{{ $title }}</span>
                        <span class="mt-1 block text-[13px] leading-6 text-on-surface-variant">{{ $description }}</span>
                    </button>
                @endforeach
            </div>
        </section>

        <section class="campaign-card p-6 md:p-8" x-show="dashboardPanel === 'portada'" x-cloak>
            <div class="mb-8 flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">home_app_logo</span>
                <div>
                    <h2 class="font-headline text-[24px] font-bold text-on-surface">Portada y biografía</h2>
                    <p class="text-[13px] text-on-surface-variant">Actualiza textos y fotos principales de la landing sin recargar la página.</p>
                </div>
            </div>

            <div class="grid gap-6 xl:grid-cols-2">
                <form class="rounded-2xl border border-outline-variant/20 bg-white p-5 shadow-sm" method="POST" action="{{ route('dashboard.hero.update') }}" enctype="multipart/form-data" data-ajax-form>
                    @csrf
                    <div class="mb-5 flex items-center justify-between gap-3">
                        <div>
                            <h3 class="font-headline text-xl font-bold text-primary">Portada principal</h3>
                            <p class="text-[13px] text-on-surface-variant">Foto del candidato, titular y botones superiores.</p>
                        </div>
                        <button class="campaign-button-primary text-sm" type="submit">
                            <span class="material-symbols-outlined text-[20px]">save</span>
                            Guardar portada
                        </button>
                    </div>

                    <input type="hidden" name="image_path" value="{{ $heroForm->image_path }}">
                    <label class="group mb-5 flex min-h-56 cursor-pointer flex-col items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-primary/30 bg-primary/5 p-4 text-center transition hover:bg-primary/10" data-drop-zone>
                        <img class="mb-3 h-40 w-full rounded-xl object-cover" src="{{ $assetImage($heroForm->image_path) }}" data-image-preview alt="Foto de portada">
                        <span class="text-[15px] font-bold text-primary">Cambiar foto de portada</span>
                        <span class="mt-1 text-[13px] text-on-surface-variant">Arrastra una imagen o haz clic para subir.</span>
                        <input name="image" type="file" accept="image/*" class="sr-only" data-preview-input>
                    </label>

                    <div class="grid gap-4 md:grid-cols-2">
                        <input name="eyebrow" class="campaign-input bg-white" value="{{ $heroForm->eyebrow }}" placeholder="Etiqueta">
                        <input name="campaign_year" type="number" min="2000" max="2100" class="campaign-input bg-white" value="{{ $heroForm->campaign_year ?? 2026 }}" placeholder="Año">
                        <input name="title" class="campaign-input bg-white md:col-span-2" value="{{ $heroForm->title }}" placeholder="Título" required>
                        <input name="highlighted_title" class="campaign-input bg-white md:col-span-2" value="{{ $heroForm->highlighted_title }}" placeholder="Texto resaltado">
                        <textarea name="description" rows="4" class="campaign-input bg-white md:col-span-2" placeholder="Descripción">{{ $heroForm->description }}</textarea>
                        <input name="primary_button_label" class="campaign-input bg-white" value="{{ $heroForm->primary_button_label }}" placeholder="Botón principal">
                        <input name="primary_button_url" class="campaign-input bg-white" value="{{ $heroForm->primary_button_url }}" placeholder="#sumate">
                        <input name="secondary_button_label" class="campaign-input bg-white" value="{{ $heroForm->secondary_button_label }}" placeholder="Botón secundario">
                        <input name="secondary_button_url" class="campaign-input bg-white" value="{{ $heroForm->secondary_button_url }}" placeholder="#plan">
                    </div>
                </form>

                <form class="rounded-2xl border border-outline-variant/20 bg-white p-5 shadow-sm" method="POST" action="{{ route('dashboard.biography.update') }}" enctype="multipart/form-data" data-ajax-form>
                    @csrf
                    <div class="mb-5 flex items-center justify-between gap-3">
                        <div>
                            <h3 class="font-headline text-xl font-bold text-primary">Quién es</h3>
                            <p class="text-[13px] text-on-surface-variant">Biografía corta, foto de contexto y puntos de experiencia.</p>
                        </div>
                        <button class="campaign-button-primary text-sm" type="submit">
                            <span class="material-symbols-outlined text-[20px]">save</span>
                            Guardar biografía
                        </button>
                    </div>

                    <input type="hidden" name="image_path" value="{{ $bioForm->image_path }}">
                    <label class="group mb-5 flex min-h-56 cursor-pointer flex-col items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-primary/30 bg-primary/5 p-4 text-center transition hover:bg-primary/10" data-drop-zone>
                        <img class="mb-3 h-40 w-full rounded-xl object-cover" src="{{ $assetImage($bioForm->image_path) }}" data-image-preview alt="Foto de biografía">
                        <span class="text-[15px] font-bold text-primary">Cambiar foto de biografía</span>
                        <span class="mt-1 text-[13px] text-on-surface-variant">Arrastra una imagen o haz clic para subir.</span>
                        <input name="image" type="file" accept="image/*" class="sr-only" data-preview-input>
                    </label>

                    <div class="grid gap-4">
                        <input name="title" class="campaign-input bg-white" value="{{ $bioForm->title }}" placeholder="Título" required>
                        <textarea name="summary" rows="5" class="campaign-input bg-white" placeholder="Resumen">{{ $bioForm->summary }}</textarea>
                        <div>
                            <label class="campaign-label">Puntos de experiencia</label>
                            <textarea name="facts_text" rows="4" class="campaign-input bg-white" placeholder="Un punto por línea">{{ $bioFactsText }}</textarea>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <form
            class="campaign-card p-6 md:p-8"
            method="POST"
            action="{{ route('dashboard.visibility.update') }}"
            x-data="{ saving: false, async save(event) {
                this.saving = true;
                const response = await fetch(event.target.action, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                    body: new FormData(event.target)
                });
                const data = await response.json();
                this.saving = false;
                window.dispatchEvent(new CustomEvent('dashboard-saved', { detail: { message: data.message || 'Cambios guardados.' } }));
                const counter = document.querySelector('[data-visible-sections]');
                if (counter && data.visible_sections !== undefined) counter.textContent = data.visible_sections;
            }}"
            x-on:submit.prevent="save($event)"
            x-show="dashboardPanel === 'configuracion'"
            x-cloak
        >
            @csrf
            @method('PATCH')

            <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">visibility</span>
                    <h2 class="font-headline text-[24px] font-bold text-on-surface">Gestión de visibilidad</h2>
                </div>
                <button class="campaign-button-primary text-sm" type="submit" :disabled="saving" :class="{ 'opacity-70': saving }">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    <span x-text="saving ? 'Guardando...' : 'Guardar cambios'"></span>
                </button>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                @foreach ($sections as $section)
                    <label class="flex cursor-pointer items-center justify-between gap-4 rounded-xl border border-outline-variant/30 p-4 transition hover:border-primary/50 hover:bg-primary/5 has-[:checked]:border-primary/50 has-[:checked]:bg-primary/5">
                        <span>
                            <span class="block text-[15px] font-semibold text-on-surface">Mostrar {{ $section->name }}</span>
                            <span class="text-[13px] leading-6 text-on-surface-variant">{{ $section->description }}</span>
                        </span>
                        <input
                            class="h-6 w-6 rounded border-outline text-primary focus:ring-primary"
                            name="sections[]"
                            type="checkbox"
                            value="{{ $section->key }}"
                            @checked($section->is_visible)
                        >
                    </label>
                @endforeach
            </div>
        </form>


        <section class="campaign-card p-6 md:p-8" x-show="dashboardPanel === 'propuestas'" x-cloak>
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">edit_note</span>
                    <div>
                        <h2 class="font-headline text-[24px] font-bold text-on-surface">Propuestas</h2>
                        <p class="text-[13px] text-on-surface-variant">Administra los pilares que aparecen en la landing.</p>
                    </div>
                </div>
                <button class="campaign-button-primary justify-center" type="button" data-open-modal="proposal-modal" data-mode="create" data-action="{{ route('dashboard.proposals.store') }}" data-append="#proposal-list">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    Nueva propuesta
                </button>
            </div>

            <div class="overflow-x-auto rounded-xl border border-outline-variant/20">
                <table class="w-full min-w-[760px] text-left">
                    <thead class="bg-surface-container-low text-[12px] font-bold uppercase tracking-wide text-on-surface-variant">
                        <tr>
                            <th class="px-4 py-3">Propuesta</th>
                            <th class="px-4 py-3">Categoría</th>
                            <th class="px-4 py-3">Orden</th>
                            <th class="px-4 py-3">Estado</th>
                            <th class="px-4 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="proposal-list" class="bg-white" data-sortable-list data-reorder-url="{{ route('dashboard.reorder', 'propuestas') }}">
                        @foreach ($proposals as $proposal)
                            @include('dashboard.partials.proposal-row', ['proposal' => $proposal, 'defaultImage' => $defaultImage])
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="campaign-card p-6 md:p-8" x-show="dashboardPanel === 'regidores'" x-cloak>
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">groups</span>
                    <div>
                        <h2 class="font-headline text-[24px] font-bold text-on-surface">Regidores</h2>
                        <p class="text-[13px] text-on-surface-variant">Gestiona nombres, cargos, fotos y visibilidad.</p>
                    </div>
                </div>
                <button class="campaign-button-primary justify-center" type="button" data-open-modal="council-modal" data-mode="create" data-action="{{ route('dashboard.council.store') }}" data-append="#council-list">
                    <span class="material-symbols-outlined text-[20px]">person_add</span>
                    Nuevo regidor
                </button>
            </div>

            <div class="overflow-x-auto rounded-xl border border-outline-variant/20">
                <table class="w-full min-w-[820px] text-left">
                    <thead class="bg-surface-container-low text-[12px] font-bold uppercase tracking-wide text-on-surface-variant">
                        <tr>
                            <th class="px-4 py-3">Regidor</th>
                            <th class="px-4 py-3">Descripción</th>
                            <th class="px-4 py-3">Orden</th>
                            <th class="px-4 py-3">Estado</th>
                            <th class="px-4 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="council-list" class="bg-white" data-sortable-list data-reorder-url="{{ route('dashboard.reorder', 'regidores') }}">
                        @foreach ($councilMembers as $member)
                            @include('dashboard.partials.council-row', ['member' => $member, 'defaultImage' => $defaultImage])
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="campaign-card p-6 md:p-8" x-show="dashboardPanel === 'galeria'" x-cloak>
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">photo_library</span>
                    <div>
                        <h2 class="font-headline text-[24px] font-bold text-on-surface">Galería del distrito</h2>
                        <p class="text-[13px] text-on-surface-variant">Sube fotos con previsualización y ordena como se mostrarán.</p>
                    </div>
                </div>
                <button class="campaign-button-primary justify-center" type="button" data-open-modal="district-modal" data-mode="create" data-action="{{ route('dashboard.district.store') }}" data-append="#district-list">
                    <span class="material-symbols-outlined text-[20px]">add_photo_alternate</span>
                    Agregar foto
                </button>
            </div>

            <div id="district-list" class="grid gap-5 md:grid-cols-2 xl:grid-cols-3" data-sortable-list data-reorder-url="{{ route('dashboard.reorder', 'galeria') }}">
                @foreach ($districtImages as $image)
                    @include('dashboard.partials.district-card', ['image' => $image, 'defaultImage' => $defaultImage])
                @endforeach
            </div>
        </section>

        <section class="campaign-card p-6 md:p-8" x-show="dashboardPanel === 'transparencia'" x-cloak>
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">account_balance_wallet</span>
                    <div>
                        <h2 class="font-headline text-[24px] font-bold text-on-surface">Transparencia de aportes</h2>
                        <p class="text-[13px] text-on-surface-variant">Registro público de aportantes, montos y detalles.</p>
                    </div>
                </div>
                <button class="campaign-button-primary justify-center" type="button" data-open-modal="contribution-modal" data-mode="create" data-action="{{ route('dashboard.contributions.store') }}" data-append="#contribution-list">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    Nuevo aporte
                </button>
            </div>

            <div class="overflow-x-auto rounded-xl border border-outline-variant/20">
                <table class="w-full min-w-[820px] text-left">
                    <thead class="bg-surface-container-low text-[12px] font-bold uppercase tracking-wide text-on-surface-variant">
                        <tr>
                            <th class="px-4 py-3">Aportante</th>
                            <th class="px-4 py-3">Tipo</th>
                            <th class="px-4 py-3">Monto</th>
                            <th class="px-4 py-3">Fecha</th>
                            <th class="px-4 py-3">Orden</th>
                            <th class="px-4 py-3">Estado</th>
                            <th class="px-4 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="contribution-list" class="bg-white" data-sortable-list data-reorder-url="{{ route('dashboard.reorder', 'transparencia') }}">
                        @foreach ($contributions as $contribution)
                            @include('dashboard.partials.contribution-row', ['contribution' => $contribution])
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <div id="proposal-modal" class="fixed inset-0 z-[85] hidden items-center justify-center bg-primary/20 p-4 backdrop-blur-sm" data-admin-modal>
        <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-2xl">
            <div class="mb-5 flex items-center justify-between">
                <h3 class="font-headline text-2xl font-extrabold text-primary" data-modal-title>Propuesta</h3>
                <button class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container" type="button" data-close-modal>
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form class="grid gap-4 md:grid-cols-2" method="POST" enctype="multipart/form-data" data-modal-form data-ajax-form>
                @csrf
                <input type="hidden" name="_method" value="POST" data-method-field>
                <input type="hidden" name="image_path">
                <label class="group flex min-h-40 cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-primary/30 bg-primary/5 p-5 text-center transition hover:bg-primary/10 md:col-span-2" data-drop-zone>
                    <img class="mb-3 hidden h-28 w-44 rounded-xl object-cover" data-image-preview alt="Imagen de la propuesta">
                    <span class="material-symbols-outlined text-4xl text-primary">add_photo_alternate</span>
                    <span class="mt-2 text-[15px] font-bold text-primary">Imagen de la propuesta</span>
                    <span class="mt-1 text-[13px] text-on-surface-variant">Arrastra una imagen o haz clic para subir.</span>
                    <input name="image" type="file" accept="image/*" class="sr-only" data-preview-input>
                </label>
                <div>
                    <label class="campaign-label">Título</label>
                    <input name="title" class="campaign-input bg-white" required>
                </div>
                <div>
                    <label class="campaign-label">Categoría</label>
                    <input name="category" class="campaign-input bg-white">
                </div>
                <div>
                    <label class="campaign-label">Icono</label>
                    <input name="icon" class="campaign-input bg-white" placeholder="water_drop">
                </div>
                <div>
                    <label class="campaign-label">Orden</label>
                    <input name="sort_order" type="number" min="0" class="campaign-input bg-white">
                </div>
                <div class="md:col-span-2">
                    <label class="campaign-label">Descripción</label>
                    <textarea name="summary" rows="3" class="campaign-input bg-white"></textarea>
                </div>
                <label class="flex items-center gap-3 text-sm font-semibold text-on-surface-variant">
                    <input class="h-5 w-5 rounded border-outline text-primary focus:ring-primary" name="active" type="checkbox" value="1" checked>
                    Mostrar en landing
                </label>
                <label class="flex items-center gap-3 text-sm font-semibold text-on-surface-variant">
                    <input class="h-5 w-5 rounded border-outline text-primary focus:ring-primary" name="is_featured" type="checkbox" value="1">
                    Destacada
                </label>
                <button class="campaign-button-primary justify-center md:col-span-2" type="submit">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    Guardar propuesta
                </button>
            </form>
        </div>
    </div>

    <div id="council-modal" class="fixed inset-0 z-[85] hidden items-center justify-center bg-primary/20 p-4 backdrop-blur-sm" data-admin-modal>
        <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-2xl">
            <div class="mb-5 flex items-center justify-between">
                <h3 class="font-headline text-2xl font-extrabold text-primary" data-modal-title>Regidor</h3>
                <button class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container" type="button" data-close-modal>
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form class="grid gap-4 md:grid-cols-2" method="POST" enctype="multipart/form-data" data-modal-form data-ajax-form>
                @csrf
                <input type="hidden" name="_method" value="POST" data-method-field>
                <label class="group flex min-h-40 cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-primary/30 bg-primary/5 p-5 text-center transition hover:bg-primary/10 md:col-span-2" data-drop-zone>
                    <img class="mb-3 hidden h-24 w-24 rounded-full object-cover" data-image-preview alt="Foto del regidor">
                    <span class="material-symbols-outlined text-4xl text-primary">add_a_photo</span>
                    <span class="mt-2 text-[15px] font-bold text-primary">Foto del regidor</span>
                    <span class="mt-1 text-[13px] text-on-surface-variant">Arrastra una foto o haz clic para subir.</span>
                    <input name="photo" type="file" accept="image/*" class="sr-only" data-preview-input>
                </label>
                <input name="name" class="campaign-input bg-white" placeholder="Nombre completo" required>
                <input name="position" class="campaign-input bg-white" placeholder="Cargo">
                <input name="sort_order" type="number" min="0" class="campaign-input bg-white" placeholder="Orden">
                <textarea name="bio" class="campaign-input bg-white md:col-span-2" rows="3" placeholder="Descripción breve"></textarea>
                <label class="flex items-center gap-3 text-sm font-semibold text-on-surface-variant">
                    <input class="h-5 w-5 rounded border-outline text-primary focus:ring-primary" name="active" type="checkbox" value="1" checked>
                    Mostrar en landing
                </label>
                <button class="campaign-button-primary justify-center md:col-span-2" type="submit">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    Guardar regidor
                </button>
            </form>
        </div>
    </div>

    <div id="district-modal" class="fixed inset-0 z-[85] hidden items-center justify-center bg-primary/20 p-4 backdrop-blur-sm" data-admin-modal>
        <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-2xl">
            <div class="mb-5 flex items-center justify-between">
                <h3 class="font-headline text-2xl font-extrabold text-primary" data-modal-title>Foto del distrito</h3>
                <button class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container" type="button" data-close-modal>
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form class="grid gap-4 md:grid-cols-2" method="POST" enctype="multipart/form-data" data-modal-form data-ajax-form>
                @csrf
                <input type="hidden" name="_method" value="POST" data-method-field>
                <input type="hidden" name="image_path">
                <label class="group flex min-h-48 cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-primary/30 bg-primary/5 p-6 text-center transition hover:bg-primary/10 md:col-span-2" data-drop-zone>
                    <img class="mb-4 hidden h-28 w-44 rounded-xl object-cover" data-image-preview alt="Vista previa">
                    <span class="material-symbols-outlined text-4xl text-primary group-has-[img:not(.hidden)]:hidden">cloud_upload</span>
                    <span class="mt-2 text-[15px] font-bold text-primary">Arrastra una foto o haz clic para subir</span>
                    <span class="mt-1 text-[13px] text-on-surface-variant">JPG, PNG o WEBP hasta 4MB.</span>
                    <input name="image" type="file" accept="image/*" class="sr-only" data-preview-input>
                </label>
                <input name="title" class="campaign-input bg-white" placeholder="Título">
                <select name="layout" class="campaign-input bg-white">
                    <option value="featured">Destacada</option>
                    <option value="small">Pequeña</option>
                    <option value="wide">Ancha</option>
                </select>
                <input name="sort_order" type="number" min="0" class="campaign-input bg-white" placeholder="Orden">
                <label class="flex items-center gap-3 text-sm font-semibold text-on-surface-variant">
                    <input class="h-5 w-5 rounded border-outline text-primary focus:ring-primary" name="active" type="checkbox" value="1" checked>
                    Mostrar
                </label>
                <textarea name="description" class="campaign-input bg-white md:col-span-2" rows="3" placeholder="Descripción"></textarea>
                <button class="campaign-button-primary justify-center md:col-span-2" type="submit">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    Guardar foto
                </button>
            </form>
        </div>
    </div>

    <div id="contribution-modal" class="fixed inset-0 z-[85] hidden items-center justify-center bg-primary/20 p-4 backdrop-blur-sm" data-admin-modal>
        <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-2xl">
            <div class="mb-5 flex items-center justify-between">
                <h3 class="font-headline text-2xl font-extrabold text-primary" data-modal-title>Aporte</h3>
                <button class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container" type="button" data-close-modal>
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form class="grid gap-4 md:grid-cols-2" method="POST" data-modal-form data-ajax-form>
                @csrf
                <input type="hidden" name="_method" value="POST" data-method-field>
                <input type="hidden" name="currency" value="PEN">
                <input name="contributor_name" class="campaign-input bg-white" placeholder="Aportante" required>
                <input name="contribution_type" class="campaign-input bg-white" placeholder="Tipo">
                <input name="amount" type="number" min="0" step="0.01" class="campaign-input bg-white" placeholder="Monto">
                <input name="contribution_date" type="date" class="campaign-input bg-white">
                <input name="sort_order" type="number" min="0" class="campaign-input bg-white" placeholder="Orden">
                <textarea name="detail" class="campaign-input bg-white md:col-span-2" rows="3" placeholder="Detalle"></textarea>
                <label class="flex items-center gap-3 text-sm font-semibold text-on-surface-variant">
                    <input class="h-5 w-5 rounded border-outline text-primary focus:ring-primary" name="active" type="checkbox" value="1" checked>
                    Publicar
                </label>
                <button class="campaign-button-primary justify-center md:col-span-2" type="submit">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    Guardar aporte
                </button>
            </form>
        </div>
    </div>

    <div id="campaign-swal" class="fixed inset-0 z-[90] hidden items-center justify-center bg-primary/20 p-4 backdrop-blur-sm">
        <div class="w-full max-w-sm rounded-[28px] border border-outline-variant/30 bg-white p-7 text-center shadow-2xl">
            <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-primary-fixed text-primary">
                <span class="material-symbols-outlined text-[34px]" data-swal-icon>check_circle</span>
            </div>
            <h3 class="font-headline text-2xl font-extrabold text-primary" data-swal-title>Listo</h3>
            <p class="mt-3 leading-7 text-on-surface-variant" data-swal-message>Los cambios fueron guardados.</p>
            <button class="mt-6 w-full rounded-xl bg-primary px-6 py-3 text-[14px] font-semibold tracking-[0.05em] text-on-primary transition hover:bg-secondary" type="button" data-swal-close>
                Entendido
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        (() => {
            const modal = document.getElementById('campaign-swal');
            const showSwal = (message, title = 'Listo', icon = 'check_circle') => {
                if (window.Swal) {
                    return window.Swal.fire({
                        title,
                        text: message,
                        icon: icon === 'error' ? 'error' : 'success',
                        confirmButtonColor: '#073b82',
                    });
                }

                modal.querySelector('[data-swal-title]').textContent = title;
                modal.querySelector('[data-swal-message]').textContent = message;
                modal.querySelector('[data-swal-icon]').textContent = icon;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            };

            const confirmSwal = async (message) => {
                if (window.Swal) {
                    const result = await window.Swal.fire({
                        title: 'Confirmar acción',
                        text: message,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, retirar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#c5001a',
                        cancelButtonColor: '#073b82',
                    });

                    return result.isConfirmed;
                }

                return confirm(message);
            };

            const decodeFill = (encoded) => {
                if (!encoded) return {};

                const bytes = Uint8Array.from(atob(encoded), (char) => char.charCodeAt(0));
                return JSON.parse(new TextDecoder().decode(bytes));
            };

            modal.querySelector('[data-swal-close]').addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });

            const closeAdminModal = (adminModal) => {
                adminModal?.classList.add('hidden');
                adminModal?.classList.remove('flex');
            };

            document.addEventListener('click', (event) => {
                const closer = event.target.closest('[data-close-modal]');
                if (closer) {
                    closeAdminModal(closer.closest('[data-admin-modal]'));
                    return;
                }

                const opener = event.target.closest('[data-open-modal]');
                if (!opener) return;

                const adminModal = document.getElementById(opener.dataset.openModal);
                const form = adminModal.querySelector('[data-modal-form]');
                const method = form.querySelector('[data-method-field]');
                const fill = decodeFill(opener.dataset.fillB64);

                form.reset();
                form.action = opener.dataset.action;
                form.dataset.append = opener.dataset.append || '';
                form.dataset.replace = opener.dataset.replace || '';
                method.value = opener.dataset.mode === 'edit' ? 'PATCH' : 'POST';
                adminModal.querySelector('[data-modal-title]').textContent = opener.dataset.mode === 'edit' ? 'Editar registro' : 'Nuevo registro';

                Object.entries(fill).forEach(([name, value]) => {
                    const field = form.elements[name];
                    if (!field) return;

                    if (field.type === 'checkbox') {
                        field.checked = Boolean(value);
                    } else {
                        field.value = value ?? '';
                    }
                });

                const preview = form.querySelector('[data-image-preview]');
                if (preview) {
                    const currentImage = fill.image_path || '';
                    if (currentImage) {
                        preview.src = currentImage.startsWith('http') || currentImage.startsWith('data:') ? currentImage : `/${currentImage}`;
                        preview.classList.remove('hidden');
                    } else {
                        preview.removeAttribute('src');
                        preview.classList.add('hidden');
                    }
                }

                adminModal.classList.remove('hidden');
                adminModal.classList.add('flex');
            });

            document.addEventListener('change', (event) => {
                const input = event.target.closest('[data-preview-input]');
                if (!input || !input.files?.[0]) return;

                const preview = input.closest('form').querySelector('[data-image-preview]');
                preview.src = URL.createObjectURL(input.files[0]);
                preview.classList.remove('hidden');
            });

            document.querySelectorAll('[data-drop-zone]').forEach((zone) => {
                const input = zone.querySelector('[data-preview-input]');

                zone.addEventListener('dragover', (event) => {
                    event.preventDefault();
                    zone.classList.add('border-primary', 'bg-primary/10');
                });

                zone.addEventListener('dragleave', () => {
                    zone.classList.remove('border-primary', 'bg-primary/10');
                });

                zone.addEventListener('drop', (event) => {
                    event.preventDefault();
                    zone.classList.remove('border-primary', 'bg-primary/10');

                    if (!event.dataTransfer.files?.length) return;

                    input.files = event.dataTransfer.files;
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                });
            });

            const refreshOrderLabels = (container, serverOrders = null) => {
                const items = [...container.querySelectorAll('[data-sortable-item]')];

                items.forEach((item, index) => {
                    const label = item.querySelector('[data-order-label]');
                    if (!label) return;

                    label.textContent = serverOrders?.[item.dataset.id] ?? ((index + 1) * 10);
                });
            };

            document.querySelectorAll('[data-sortable-list]').forEach((container) => {
                if (!window.Sortable) return;

                window.Sortable.create(container, {
                    animation: 150,
                    handle: '[data-drag-handle]',
                    draggable: '[data-sortable-item]',
                    ghostClass: 'opacity-40',
                    chosenClass: 'bg-primary/5',
                    dragClass: 'shadow-xl',
                    onEnd: async () => {
                        refreshOrderLabels(container);

                        const items = [...container.querySelectorAll('[data-sortable-item]')]
                            .map((item) => item.dataset.id)
                            .filter(Boolean);

                        try {
                            const response = await fetch(container.dataset.reorderUrl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                },
                                body: JSON.stringify({ _method: 'PATCH', items }),
                            });

                            const data = await response.json();

                            if (!response.ok) {
                                const firstError = data.errors ? Object.values(data.errors).flat()[0] : data.message;
                                throw new Error(firstError || 'No se pudo actualizar el orden.');
                            }

                            refreshOrderLabels(container, data.orders || {});
                            window.dispatchEvent(new CustomEvent('dashboard-saved', {
                                detail: { message: data.message || 'Orden actualizado correctamente.' },
                            }));
                        } catch (error) {
                            showSwal(error.message || 'No se pudo actualizar el orden.', 'Revisa los datos', 'error');
                        }
                    },
                });
            });

            document.addEventListener('submit', async (event) => {
                const submittedForm = event.target.closest('form');
                const isProposalDelete = submittedForm
                    && submittedForm.action.includes('/dashboard/proposals/')
                    && new FormData(submittedForm).get('_method') === 'DELETE';
                const form = event.target.closest('[data-ajax-form], [data-ajax-delete]') || (isProposalDelete ? submittedForm : null);
                if (!form) return;

                event.preventDefault();
                event.stopImmediatePropagation();

                if ((form.matches('[data-ajax-delete]') || isProposalDelete) && !await confirmSwal('¿Seguro que deseas retirar este registro?')) {
                    return;
                }

                const submitter = event.submitter;
                if (submitter) submitter.disabled = true;

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: new FormData(form),
                    });

                    const raw = await response.text();
                    let data = {};

                    try {
                        data = raw ? JSON.parse(raw) : {};
                    } catch (parseError) {
                        throw new Error('El servidor devolvió una respuesta inesperada. Revisa la sesión o los datos enviados.');
                    }

                    if (!response.ok) {
                        const firstError = data.errors ? Object.values(data.errors).flat()[0] : data.message;
                        throw new Error(firstError || 'No se pudo guardar.');
                    }

                    if (form.dataset.replace && data.html) {
                        document.querySelector(form.dataset.replace)?.insertAdjacentHTML('afterend', data.html);
                        document.querySelector(form.dataset.replace)?.remove();
                    }

                    if (form.dataset.append && data.html) {
                        document.querySelector(form.dataset.append)?.insertAdjacentHTML('afterbegin', data.html);
                        form.reset();
                    }

                    if (form.dataset.remove) {
                        document.querySelector(form.dataset.remove)?.remove();
                    } else if (isProposalDelete) {
                        const proposalId = form.action.split('/').filter(Boolean).pop();
                        document.querySelector(`#proposal-${proposalId}`)?.remove();
                    }

                    closeAdminModal(form.closest('[data-admin-modal]'));
                    showSwal(data.message || 'Cambios guardados correctamente.');
                } catch (error) {
                    showSwal(error.message, 'Revisa los datos', 'error');
                } finally {
                    if (submitter) submitter.disabled = false;
                }
            });
        })();
    </script>
</x-app-layout>
