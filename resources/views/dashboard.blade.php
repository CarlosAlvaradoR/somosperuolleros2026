<x-app-layout>
    <x-slot name="title">Dashboard | Somos Peru Olleros</x-slot>
    <x-slot name="header">
        <h1 class="font-headline text-2xl font-extrabold text-primary">Configuracion del sitio</h1>
    </x-slot>

    <div class="space-y-8">
        <section class="grid gap-5 md:grid-cols-4">
            @foreach ([
                ['visibility', 'Secciones activas', '5', 'Landing publica'],
                ['groups', 'Voluntarios', '128', 'Registrados'],
                ['payments', 'Aportes', 'S/ 4,860', 'Declarados'],
                ['sports_soccer', 'Copa Olleros', '12', 'Equipos interesados'],
            ] as [$icon, $label, $value, $hint])
                <article class="campaign-card p-6">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-primary-fixed text-primary">
                        <span class="material-symbols-outlined">{{ $icon }}</span>
                    </div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-on-surface-variant">{{ $label }}</p>
                    <p class="mt-2 font-headline text-3xl font-extrabold text-primary">{{ $value }}</p>
                    <p class="mt-1 text-sm text-on-surface-variant">{{ $hint }}</p>
                </article>
            @endforeach
        </section>

        <section class="campaign-card p-6 md:p-8">
            <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">visibility</span>
                    <h2 class="font-headline text-2xl font-bold text-on-surface">Gestion de visibilidad</h2>
                </div>
                <button class="campaign-button-primary" type="button">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    Guardar cambios
                </button>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                @foreach ([
                    ['Mostrar propuestas en landing', 'Habilita los pilares del plan de gobierno.', true],
                    ['Mostrar tabla de transparencia', 'Publica aportes y gastos declarados.', true],
                    ['Activar Copa Olleros', 'Muestra el modulo de inscripcion deportiva.', true],
                    ['Mostrar regidores', 'Publica la lista del equipo municipal.', false],
                ] as [$label, $hint, $checked])
                    <label class="flex cursor-pointer items-center justify-between gap-4 rounded-xl border border-outline-variant/30 p-4 transition hover:border-primary/50 hover:bg-primary/5">
                        <span>
                            <span class="block font-semibold text-on-surface">{{ $label }}</span>
                            <span class="text-sm text-on-surface-variant">{{ $hint }}</span>
                        </span>
                        <input class="h-5 w-5 rounded border-outline text-primary focus:ring-primary" type="checkbox" @checked($checked)>
                    </label>
                @endforeach
            </div>
        </section>

        <section class="campaign-card p-6 md:p-8">
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">edit_note</span>
                    <h2 class="font-headline text-2xl font-bold text-on-surface">Editar propuestas</h2>
                </div>
                <button class="campaign-button-primary" type="button">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    Nueva propuesta
                </button>
            </div>

            <div class="space-y-5">
                @foreach ([
                    ['Agua para todos', 'Saneamiento', 'Implementacion de sistemas de riego tecnificado y acceso a agua potable en zonas rurales.'],
                    ['Futuro con chacra', 'Agricultura', 'Fortalecimiento de pequenos productores con asistencia tecnica y rutas de venta.'],
                ] as [$title, $category, $description])
                    <article class="grid gap-5 rounded-xl border border-outline-variant/20 bg-surface-container-low p-5 md:grid-cols-[12rem_1fr_auto]">
                        <div class="h-32 overflow-hidden rounded-lg bg-primary-fixed">
                            <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=500&q=80" alt="{{ $title }}">
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="campaign-label">Titulo de propuesta</label>
                                <input class="campaign-input bg-white" value="{{ $title }}">
                            </div>
                            <div>
                                <label class="campaign-label">Categoria</label>
                                <select class="campaign-input bg-white">
                                    <option>{{ $category }}</option>
                                    <option>Educacion</option>
                                    <option>Transparencia</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="campaign-label">Descripcion</label>
                                <textarea class="campaign-input bg-white" rows="2">{{ $description }}</textarea>
                            </div>
                        </div>
                        <div class="flex items-end gap-2 md:flex-col md:justify-end">
                            <button class="rounded-lg p-2 text-primary transition hover:bg-primary/10" type="button" aria-label="Guardar">
                                <span class="material-symbols-outlined">save</span>
                            </button>
                            <button class="rounded-lg p-2 text-error transition hover:bg-error/10" type="button" aria-label="Eliminar">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    </div>
</x-app-layout>
