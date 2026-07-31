<x-app-layout>
    <x-slot name="title">Dashboard | Somos Perú Olleros</x-slot>
    <x-slot name="header">
        <h1 class="font-headline text-2xl font-extrabold text-primary">Configuración del sitio</h1>
    </x-slot>

    @php
        $defaultImage = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIj48cmVjdCB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgcng9IjgiIGZpbGw9IiNlOGVhZWQiLz48cGF0aCBkPSJNMTcwIDEzMCBsMzAgNDAgbDIwLTE1IGw0MCA1NSBIMTQweiIgZmlsbD0iI2JkYzFjNiIvPjxjaXJjbGUgY3g9IjI1MCIgY3k9IjEyMCIgcj0iMTgiIGZpbGw9IiNiZGMxYzYiLz48L3N2Zz4=';
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

        <section class="grid gap-5 md:grid-cols-4">
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

        <section class="campaign-card p-6 md:p-8">
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">edit_note</span>
                    <h2 class="font-headline text-[24px] font-bold text-on-surface">Editar propuestas</h2>
                </div>
                <form method="POST" action="{{ route('dashboard.proposals.store') }}" data-ajax-form data-append="#proposal-list">
                    @csrf
                    <button class="campaign-button-primary justify-center" type="submit">
                        <span class="material-symbols-outlined text-[20px]">add</span>
                        Nueva propuesta
                    </button>
                </form>
            </div>

            <div id="proposal-list" class="space-y-5">
                @forelse ($proposals as $proposal)
                    <article id="proposal-{{ $proposal->id }}" class="grid gap-5 rounded-xl border border-outline-variant/20 bg-surface-container-low p-5 md:grid-cols-[12rem_1fr_auto]">
                        <div class="h-32 overflow-hidden rounded-lg bg-primary-fixed">
                            <img class="h-full w-full object-cover" src="{{ $proposal->image_path ?: $defaultImage }}" alt="{{ $proposal->image_alt ?: $proposal->title }}">
                        </div>

                        <form id="proposal-form-{{ $proposal->id }}" class="grid gap-4 md:grid-cols-2" method="POST" action="{{ route('dashboard.proposals.update', $proposal->id) }}" data-ajax-form data-replace="#proposal-{{ $proposal->id }}">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label class="campaign-label" for="title-{{ $proposal->id }}">Título de propuesta</label>
                                <input id="title-{{ $proposal->id }}" name="title" class="campaign-input bg-white" value="{{ $proposal->title }}" required>
                            </div>
                            <div>
                                <label class="campaign-label" for="category-{{ $proposal->id }}">Categoría</label>
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
                        </form>

                        <div class="flex items-end gap-2 md:flex-col md:justify-end">
                            <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-4 py-3 text-[13px] font-semibold text-on-primary shadow-sm transition hover:bg-secondary" type="submit" form="proposal-form-{{ $proposal->id }}" aria-label="Guardar propuesta">
                                <span class="material-symbols-outlined text-[19px]">save</span>
                                <span>Guardar</span>
                            </button>
                            <form method="POST" action="{{ route('dashboard.proposals.destroy', $proposal->id) }}" data-ajax-delete data-remove="#proposal-{{ $proposal->id }}">
                                @csrf
                                @method('DELETE')
                                <button class="inline-flex items-center justify-center gap-2 rounded-xl border border-error px-4 py-3 text-[13px] font-semibold text-error transition hover:bg-error/10" type="submit" aria-label="Eliminar propuesta">
                                    <span class="material-symbols-outlined text-[19px]">delete</span>
                                    <span>Retirar</span>
                                </button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="rounded-xl border border-dashed border-outline-variant p-8 text-center text-on-surface-variant">
                        No hay propuestas registradas todavía.
                    </div>
                @endforelse
            </div>
        </section>

        <section class="campaign-card p-6 md:p-8">
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">groups</span>
                    <h2 class="font-headline text-[24px] font-bold text-on-surface">Configurar regidores</h2>
                </div>
            </div>

            <form class="mb-6 grid gap-4 rounded-xl border border-dashed border-outline-variant p-5 md:grid-cols-4" method="POST" action="{{ route('dashboard.council.store') }}" enctype="multipart/form-data" data-ajax-form data-append="#council-list">
                @csrf
                <input name="name" class="campaign-input bg-white" placeholder="Nombre completo" required>
                <input name="position" class="campaign-input bg-white" placeholder="Cargo">
                <input name="sort_order" type="number" min="0" class="campaign-input bg-white" placeholder="Orden">
                <input name="photo" type="file" accept="image/*" class="campaign-input bg-white">
                <textarea name="bio" class="campaign-input bg-white md:col-span-3" rows="2" placeholder="Descripción breve"></textarea>
                <label class="flex items-center gap-3 text-sm font-semibold text-on-surface-variant">
                    <input class="h-5 w-5 rounded border-outline text-primary focus:ring-primary" name="active" type="checkbox" value="1" checked>
                    Mostrar
                </label>
                <button class="campaign-button-primary text-sm md:col-span-4" type="submit">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    Agregar regidor
                </button>
            </form>

            <div id="council-list" class="space-y-5">
                @foreach ($councilMembers as $member)
                    @include('dashboard.partials.council-member', ['member' => $member, 'defaultImage' => $defaultImage])
                @endforeach
            </div>
        </section>

        <section class="campaign-card p-6 md:p-8">
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">photo_library</span>
                    <h2 class="font-headline text-[24px] font-bold text-on-surface">Fotos del distrito</h2>
                </div>
            </div>

            <form class="mb-6 grid gap-4 rounded-xl border border-dashed border-outline-variant p-5 md:grid-cols-4" method="POST" action="{{ route('dashboard.district.store') }}" enctype="multipart/form-data" data-ajax-form data-append="#district-list">
                @csrf
                <input name="title" class="campaign-input bg-white" placeholder="Título">
                <select name="layout" class="campaign-input bg-white">
                    <option value="featured">Destacada</option>
                    <option value="small" selected>Pequeña</option>
                    <option value="wide">Ancha</option>
                </select>
                <input name="sort_order" type="number" min="0" class="campaign-input bg-white" placeholder="Orden">
                <input name="image" type="file" accept="image/*" class="campaign-input bg-white">
                <textarea name="description" class="campaign-input bg-white md:col-span-3" rows="2" placeholder="Descripción"></textarea>
                <label class="flex items-center gap-3 text-sm font-semibold text-on-surface-variant">
                    <input class="h-5 w-5 rounded border-outline text-primary focus:ring-primary" name="active" type="checkbox" value="1" checked>
                    Mostrar
                </label>
                <button class="campaign-button-primary text-sm md:col-span-4" type="submit">
                    <span class="material-symbols-outlined text-[20px]">add_photo_alternate</span>
                    Agregar foto
                </button>
            </form>

            <div id="district-list" class="space-y-5">
                @foreach ($districtImages as $image)
                    @include('dashboard.partials.district-image', ['image' => $image, 'defaultImage' => $defaultImage])
                @endforeach
            </div>
        </section>

        <section class="campaign-card p-6 md:p-8">
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">account_balance_wallet</span>
                    <h2 class="font-headline text-[24px] font-bold text-on-surface">Transparencia de aportes</h2>
                </div>
            </div>

            <form class="mb-6 grid gap-4 rounded-xl border border-dashed border-outline-variant p-5 md:grid-cols-4" method="POST" action="{{ route('dashboard.contributions.store') }}" data-ajax-form data-append="#contributions-list">
                @csrf
                <input name="contributor_name" class="campaign-input bg-white" placeholder="Aportante" required>
                <input name="contribution_type" class="campaign-input bg-white" placeholder="Tipo">
                <input name="amount" type="number" min="0" step="0.01" class="campaign-input bg-white" placeholder="Monto">
                <input name="contribution_date" type="date" class="campaign-input bg-white">
                <textarea name="detail" class="campaign-input bg-white md:col-span-3" rows="2" placeholder="Detalle"></textarea>
                <input type="hidden" name="currency" value="PEN">
                <label class="flex items-center gap-3 text-sm font-semibold text-on-surface-variant">
                    <input class="h-5 w-5 rounded border-outline text-primary focus:ring-primary" name="active" type="checkbox" value="1" checked>
                    Mostrar
                </label>
                <button class="campaign-button-primary text-sm md:col-span-4" type="submit">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    Agregar aportante
                </button>
            </form>

            <div id="contributions-list" class="space-y-5">
                @foreach ($contributions as $contribution)
                    @include('dashboard.partials.contribution', ['contribution' => $contribution])
                @endforeach
            </div>
        </section>
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

    <script>
        (() => {
            const modal = document.getElementById('campaign-swal');
            const showSwal = (message, title = 'Listo', icon = 'check_circle') => {
                modal.querySelector('[data-swal-title]').textContent = title;
                modal.querySelector('[data-swal-message]').textContent = message;
                modal.querySelector('[data-swal-icon]').textContent = icon;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            };

            modal.querySelector('[data-swal-close]').addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
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

                if ((form.matches('[data-ajax-delete]') || isProposalDelete) && !confirm('¿Seguro que deseas retirar este registro?')) {
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

                    const data = await response.json();

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
