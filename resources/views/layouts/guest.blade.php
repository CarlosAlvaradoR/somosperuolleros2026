<x-public-layout :title="$title ?? 'Acceso | Somos Peru Olleros'">
    <section class="relative overflow-hidden bg-background px-5 py-16 md:py-24">
        <div class="campaign-container flex justify-center">
            <div class="campaign-card w-full max-w-[460px] overflow-hidden rounded-2xl">
                <div class="p-8 md:p-10">
                    <div class="mb-8 flex flex-col items-center text-center">
                        <x-campaign-logo class="mb-5 justify-center [&>img]:h-16 [&>span:last-child]:hidden" />
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
