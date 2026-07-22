<x-public-layout :title="$title ?? 'Acceso | Somos Peru Olleros'">
    <section class="relative overflow-hidden bg-gradient-to-br from-background via-white to-primary-fixed/25 px-5 py-16 md:py-24">
        <div class="campaign-container grid items-center gap-10 lg:grid-cols-[1fr_440px]">
            <div class="hidden max-w-xl space-y-7 lg:block">
                <span class="inline-flex items-center gap-2 rounded-full bg-secondary-fixed px-4 py-2 text-sm font-bold uppercase tracking-wide text-secondary">
                    <span class="h-2 w-2 rounded-full bg-secondary"></span>
                    Gestion de campana
                </span>
                <h1 class="font-headline text-5xl font-extrabold leading-tight text-primary">
                    La misma identidad, ahora lista para administrar Olleros.
                </h1>
                <p class="text-lg leading-8 text-on-surface-variant">
                    Accede para publicar propuestas, revisar aportes y mantener actualizada la informacion publica de la campana.
                </p>
            </div>

            <div class="campaign-card w-full overflow-hidden rounded-2xl">
                <div class="p-8 md:p-10">
                    <div class="mb-8 flex flex-col items-center text-center">
                        <span class="brand-heart mb-5 h-16 w-16 text-[10px]"><span>Somos<br>Peru</span></span>
                        @isset($heading)
                            <h1 class="font-headline text-3xl font-extrabold text-primary">{{ $heading }}</h1>
                        @endisset
                        @isset($subheading)
                            <p class="mt-2 text-on-surface-variant">{{ $subheading }}</p>
                        @endisset
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
