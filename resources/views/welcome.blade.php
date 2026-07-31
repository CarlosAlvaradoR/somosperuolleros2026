<x-public-layout title="Somos Peru | Mirko Cacha">
    @php
        $sectionVisible = fn (string $key) => ! isset($sections) || ! $sections->has($key) || (bool) $sections->get($key)->is_visible;
        $imageUrl = fn (?string $path) => $path && (str_starts_with($path, 'http') || str_starts_with($path, 'data:')) ? $path : ($path ? asset($path) : '');
        $hero = $heroContent ?? (object) [
            'eyebrow' => '{{ $hero->eyebrow }}',
            'title' => 'Agua, chacra y futuro para',
            'highlighted_title' => 'Olleros',
            'description' => '{{ $hero->description }}',
            'primary_button_label' => 'Súmate al cambio',
            'primary_button_url' => '#sumate',
            'secondary_button_label' => 'Ver Plan de Gobierno',
            'secondary_button_url' => '#plan',
            'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDgCorCyDnL3U6fpvzz9_KkG9Mvy8nfzviGLDZreVRtJWjQB01fOhnyLnTo7QYwJvJCViY72gEptCJ61Xz6usCU8Ltd-mV6o_thXu9zuPquFMqKevhN6qjhQKuOBQI4wf0ybmKfl9B-oFbrEmh_gh09H2OcpUVnDN6PHYRTyqLB-JJTbX_UAJJS_zuAhLOdcMVSCFjuuc7jla0CvxKTc55Ypdue6ntwA8pjZoUOJ-eKcIoTSNQti5TYuIaa0rQp3OQ7Dh00KpMHLA',
            'image_alt' => 'Mirko Cacha en paisaje andino de Olleros',
        ];
        $bio = $candidateBio ?? (object) [
            'title' => '{{ $bio->title }}',
            'summary' => 'Contador público colegiado con trayectoria en gestión pública, administración municipal y docencia. Conoce de cerca la realidad del campo, el turno de agua, la educación rural y las necesidades de cada caserío.',
            'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBjyBWYiwBoWfIj_gqGQyhWLs81N1I1WNEw4-B-eLi70wefeP_R0437rB1zduntzUAypyshKURPJyCdncY66L-1bwLVI_0kBYwx5hU1eaOiP8q7zwAUpO4wDVE2mGEqJpyUkOT9VqUr3hG1rfB7f4uHXJgO5QoEIClECThkK2CbQHYP2RjVzFKf7fFuCo4-yAJCQp5duQRJewhR4aLF9KnVwW_cm5evB4mwGSoImHluZLMh5xD0T1Rnl0fHL3rlFO3an3LWGI16OQ',
            'image_alt' => 'Mirko Cacha dialogando con agricultores de Olleros',
            'facts' => json_encode(['Gestión pública', 'Trayectoria académica', 'Trabajo comunal'], JSON_UNESCAPED_UNICODE),
        ];
        $bioFacts = collect(json_decode($bio->facts ?? '[]', true) ?: [])->filter()->values();
        $proposalItems = isset($proposals) && $proposals->isNotEmpty()
            ? $proposals
            : collect([
                (object) ['icon' => 'water_drop', 'title' => 'Agua y saneamiento', 'summary' => 'Agua potable de calidad y saneamiento digno para los centros poblados.'],
                (object) ['icon' => 'agriculture', 'title' => 'Agricultura y riego', 'summary' => 'Canales tecnificados, apoyo al productor y asistencia tecnica permanente.'],
                (object) ['icon' => 'school', 'title' => 'Educacion', 'summary' => 'Infraestructura moderna y programas de oportunidades para jovenes.'],
                (object) ['icon' => 'local_hospital', 'title' => 'Salud', 'summary' => 'Atencion preventiva, postas fortalecidas y campanas medicas descentralizadas.'],
                (object) ['icon' => 'route', 'title' => 'Caminos', 'summary' => 'Mantenimiento vial para conectar comunidades, chacras y mercados.'],
                (object) ['icon' => 'account_balance_wallet', 'title' => 'Transparencia', 'summary' => 'Aportes, gastos y avances publicados para todos los vecinos.'],
            ]);
        $councilItems = isset($councilMembers) && $councilMembers->isNotEmpty()
            ? $councilMembers
            : collect([
                (object) ['name' => 'Carmen Rojas', 'position' => 'Primera Regidora', 'bio' => 'Ingeniera de Sistemas con especialidad en modernización del estado.', 'photo_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBQFhthJVk2oysLMe9NvFApkFB-Kr3TdvP6SwCdQcLShHOHyflhy2kSAyEwBzoqMUB4fU3T2eoMTwtFyEgompIJzg7K0lHqk4qSlaFVFyjr4M8eeH3FP24VKB5tS_PkBngyvRGpIIDDU8ksX7ime1Tgi8U1XICi6Qu66Wd8VZF18T_i_TuS0htk42Axja61XmEKuQYXAPhdzLLCPGFGl0dZqrvaSZWQcC-mbv-2eOiQEla_RmyyUE62KYuTEcocZaW-XW3qBbBcPA'],
                (object) ['name' => 'Juan Huamán', 'position' => 'Segundo Regidor', 'bio' => 'Especialista agrario con experiencia en riego tecnificado.', 'photo_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBZPAWWn2JpegQV_OkUjFlpQRpimxixhmkngOnFzhmYjeCupLbn08-s00yAVRt25jZqTOzotYvtA6R73-w04dn6ParP3oOwiZcmUANS24V7Ky1EsC3ZRti7e8GzWxEZpkNNGPahFwy_w4vjsYFYJ2R01r1gEP_jtQiSPAugnwOO7JvijYE2LoiGoedU2IdIozNXfFL3n2x4EK603_mN_ihmBiIf3kL12NV8kLh5QBCcI3Hwtn1kMTGlrX_Fldlz-vHhyjnCS84ihw'],
                (object) ['name' => 'Sofía Paredes', 'position' => 'Tercera Regidora', 'bio' => 'Abogada especialista en derecho administrativo y gestión municipal.', 'photo_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCJjWxvycLpoub4d8BjXZ_Wt_BHnHa8kR2F3bJxshBbxWqHnt0A_ERdtL3n_E4AgxbeX7UFvQBJpYJBJPj09C69v329-UYvMYwA0pKx8g38x7qssafMd0Jel_fUPnkTEACWgBYpIAArvgvWd1RKdMRi-oANZl286rjM94yAdAHGl6dSWv1-383av8OuNT3nl8F7nCPYdFbSsXpEHZe_PtcQT2Zxx_wpegqRR5g1tS-UqzfULOnYCNejVrVZV1qnE5bO42Mgbvh8Ew'],
                (object) ['name' => 'Luis Castro', 'position' => 'Cuarto Regidor', 'bio' => 'Ingeniero Civil experto en infraestructura vial y saneamiento rural.', 'photo_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDEHZJZ4ZCfJ5d_x7UQUHFa44sVERu2gXHfDEuTcW3j4pk_TNxg7qGLzjjZfkC2BuIriAcvQWIr4G8KrxsyzIjkc3W9Yg6xuUx2IohP5o49ZNQSR8P_G7z9Yg_Izvp9QPmcN5VN1k1X9c3k5bjZD3uflDVbKkQR2WGnqK1IXCrMlMIggmGQYwtTU32oe620Q1G7qF1q7PRY1uaG55TaY9H8sSmQXLZkRVGYsBAvmrnBMUo3UDcNgvIGHcTe3H_aR8bDkedEcJch8w'],
            ]);
        $technicalItems = isset($technicalTeam) && $technicalTeam->isNotEmpty()
            ? $technicalTeam
            : collect([
                (object) ['name' => 'Juan Mendoza', 'role' => 'Coordinador de Base', 'bio' => 'Ingeniero Civil con amplia experiencia en organización comunitaria y desarrollo local.', 'photo_path' => 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIj48cmVjdCB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgcng9IjgiIGZpbGw9IiNlOGVhZWQiLz48cGF0aCBkPSJNMTcwIDEzMCBsMzAgNDAgbDIwLTE1IGw0MCA1NSBIMTQweiIgZmlsbD0iI2JkYzFjNiIvPjxjaXJjbGUgY3g9IjI1MCIgY3k9IjEyMCIgcj0iMTgiIGZpbGw9IiNiZGMxYzYiLz48L3N2Zz4='],
                (object) ['name' => 'Luis Tinoco', 'role' => 'Coordinador de Sedes', 'bio' => 'Ingeniero Agrónomo especializado en gestión de infraestructura y logística rural.', 'photo_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAHgCrUmOWo1qfHSy-4zCo8rrxJJ2gqaBgvhjL7gu7mXQC1KWeB1jzNL2y71GBLv7EZiBrRuiZPGvd3blZdbETxYYX5bPLge0jSmeV3D5FlpQWi2-WzzXY7KoF9quubDDuslH6jvLudjCLCtN0IwUyacYqfrv3a5lazTPgXBo5RiNuqtcqD4bml0O0jcNCfASQd5vomUxOhopC5h109eY_wh3aWwEdORh7kfxaVov0Uw-r-A87pcNfk59koiaUAU7G3vpeuwbAlTg'],
                (object) ['name' => 'Ana Valdivia', 'role' => 'Coordinadora de Plan de Gobierno', 'bio' => 'Gestora Pública experta en diseño de políticas municipales y transparencia.', 'photo_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDalZJjYC4JTdjtcRqYppi5BJgRSI1Q7DXMDrKyyXCsT7pG9P9nBSKLHYXyZfotQ4P_tPVQCisd16HRyv3IKYdj2EPsmahspsZMa-XWuYUTAAwSQNZeDKtwMfTpNk4K6zte9N1fYxysIPuxeamQuJyWI80WIetSGroSDnzyyk7D88kNN-rNwKpdMam8dwFwK8NJwmIH9v8MufFbDxC0FDn2f3Y5oa7cz1K_H_UPJoNOpqPEuNSBQcExvvzBhEdBeAZ9UrR_dwh_FA'],
            ]);
        $contributionItems = isset($contributions) && $contributions->isNotEmpty()
            ? $contributions
            : collect([
                (object) ['contributor_name' => 'Asociacion de Productores', 'contribution_type' => 'Materiales', 'detail' => '1000 volantes', 'contribution_date' => '2026-10-15'],
                (object) ['contributor_name' => 'Comite Vecinal Barrio Centro', 'contribution_type' => 'Organizacion', 'detail' => 'Sede para reunion', 'contribution_date' => '2026-10-12'],
                (object) ['contributor_name' => 'Aporte voluntario individual', 'contribution_type' => 'Economico', 'detail' => 'S/ 500.00', 'contribution_date' => '2026-10-10'],
            ]);
        $districtItems = isset($districtImages) && $districtImages->isNotEmpty()
            ? $districtImages
            : collect([
                (object) ['title' => 'Jornada de diálogo en Olleros', 'layout' => 'featured', 'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBhvx8BI88fuvxfyTbMgUUSUR4wJamKwLJIdAiGNlbvFgQNVNgFx4IWct-_JHKMzBRd0gvRz-SP7DvIRDrWzfJ6ffIRN_QOhSNtPqR6VTcRaAK2Ct8tLZIC7wrZI3sTKMye9aXUnUOK1cjqBbZKX6y7VzniWdHB4YV9Wj6Y5abhJcEvsiOcTpQ76fv53DA_LnB-ZDgyZfzKGenHBpTcEl5OVkiC-StI0MUpipWDE26Ka7jYVZXJDOfvfcu-fKvi9khSzKJxU1o1rQ'],
                (object) ['title' => 'Saludo con vecinos de Olleros', 'layout' => 'small', 'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDalZJjYC4JTdjtcRqYppi5BJgRSI1Q7DXMDrKyyXCsT7pG9P9nBSKLHYXyZfotQ4P_tPVQCisd16HRyv3IKYdj2EPsmahspsZMa-XWuYUTAAwSQNZeDKtwMfTpNk4K6zte9N1fYxysIPuxeamQuJyWI80WIetSGroSDnzyyk7D88kNN-rNwKpdMam8dwFwK8NJwmIH9v8MufFbDxC0FDn2f3Y5oa7cz1K_H_UPJoNOpqPEuNSBQcExvvzBhEdBeAZ9UrR_dwh_FA'],
                (object) ['title' => 'Taller con jóvenes de Olleros', 'layout' => 'small', 'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDhQg7J9iBM4WwQftWaJD1P3QMCkgRfmPdRVvtxIj662OPzrbRLkKz58w6v6c9ILIs8SPKBEbq8K4xWH8VwLNhBygcsG649lCWOjgJ1gi5GxfBoaIyulSE5D1Eb1b71zszNHA1rhbc1TAK3LvydQYyHVuJPVPPtWEi9wfxRnqGnQeYohkTMM8py4J7i6SoBEZJNcz8igg5s7QQhKpmjnKwUY7p-1-xOnqijd_kh9FnLDftxkorbmklX07hDUAylJ0c9sD5i6dl33A'],
                (object) ['title' => 'Campo agrícola de Olleros', 'layout' => 'wide', 'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAHgCrUmOWo1qfHSy-4zCo8rrxJJ2gqaBgvhjL7gu7mXQC1KWeB1jzNL2y71GBLv7EZiBrRuiZPGvd3blZdbETxYYX5bPLge0jSmeV3D5FlpQWi2-WzzXY7KoF9quubDDuslH6jvLudjCLCtN0IwUyacYqfrv3a5lazTPgXBo5RiNuqtcqD4bml0O0jcNCfASQd5vomUxOhopC5h109eY_wh3aWwEdORh7kfxaVov0Uw-r-A87pcNfk59koiaUAU7G3vpeuwbAlTg'],
            ]);
    @endphp

    @if ($sectionVisible('hero'))
    <section class="relative flex min-h-screen items-center overflow-hidden bg-background pt-20">
        <div class="mx-auto grid w-full max-w-[1200px] items-center gap-12 px-5 py-14 md:grid-cols-12 md:px-6">
            <div class="space-y-8 md:col-span-7">
                <span class="inline-flex items-center gap-2 rounded-full bg-secondary-fixed px-4 py-1.5 text-[14px] font-semibold uppercase leading-[1.2] tracking-[0.05em] text-secondary">
                    <span class="h-2 w-2 rounded-full bg-secondary"></span>
                    {{ $hero->eyebrow }}
                </span>

                <div class="space-y-6">
                    <h1 class="font-headline text-[56px] font-extrabold leading-[1.08] text-primary md:text-[80px]">
                        {{ $hero->title }} <span class="text-secondary">{{ $hero->highlighted_title }}</span>
                    </h1>
                    <p class="max-w-xl text-[18px] leading-[1.6] text-on-surface-variant">
                        {{ $hero->description }}
                    </p>
                </div>

                <div class="flex flex-col gap-4 pt-4 sm:flex-row">
                    <a class="rounded-xl bg-primary px-8 py-4 text-center text-[14px] font-semibold leading-[1.2] tracking-[0.05em] text-on-primary shadow-none transition hover:bg-secondary" href="{{ $hero->primary_button_url ?: '#sumate' }}">{{ $hero->primary_button_label ?: 'Súmate al cambio' }}</a>
                    <a class="campaign-button-outline" href="{{ $hero->secondary_button_url ?: '#plan' }}">{{ $hero->secondary_button_label ?: 'Ver Plan de Gobierno' }}</a>
                </div>
            </div>

            <div class="group relative md:col-span-5">
                <div class="absolute -inset-4 rounded-[40px] bg-primary/5 blur-2xl transition group-hover:bg-secondary/5"></div>
                <div class="relative aspect-[4/5] overflow-hidden rounded-[40px] shadow-[0px_10px_40px_rgba(33,68,139,0.06)]">
                    <img class="h-full w-full object-cover" src="{{ $imageUrl($hero->image_path) }}" alt="{{ $hero->image_alt ?: $hero->title }}">
                </div>
            </div>
        </div>
    </section>
    @endif
    @unless ($sectionVisible('hero'))
        <div class="h-20 bg-background"></div>
    @endunless

    @if ($sectionVisible('biografia'))
    <section id="biografia" class="bg-surface py-16 md:py-28">
        <div class="campaign-container grid items-center gap-12 md:grid-cols-2">
            <div class="relative order-2 md:order-1">
                <div class="absolute -left-4 -top-4 h-24 w-24 rounded-tl-3xl border-l-4 border-t-4 border-secondary/30"></div>
                <img class="relative w-full rounded-3xl shadow-[0px_10px_40px_rgba(33,68,139,0.06)]" src="{{ $imageUrl($bio->image_path) }}" alt="{{ $bio->image_alt ?: $bio->title }}">
            </div>
            <div class="order-1 space-y-6 md:order-2">
                <h2 class="font-headline text-4xl font-extrabold text-primary">{{ $bio->title }}</h2>
                <div class="h-1.5 w-20 rounded-full bg-secondary"></div>
                <p class="text-lg leading-8 text-on-surface-variant">
                    {{ $bio->summary }}
                </p>
                <div class="grid gap-4 sm:grid-cols-3">
                    @foreach ($bioFacts as $value)
                        <div class="flex items-center gap-3 font-bold text-primary">
                            <span class="material-symbols-outlined text-secondary">verified</span>
                            <span>{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    @if ($sectionVisible('plan'))
    <section id="plan" class="bg-surface-container-low py-16 md:py-28">
        <div class="campaign-container">
            <div class="mx-auto mb-14 max-w-3xl text-center">
                <h2 class="font-headline text-4xl font-extrabold text-primary">Nuestras propuestas</h2>
                <p class="mt-4 text-lg leading-8 text-on-surface-variant">
                    Tres ejes de trabajo para transformar la calidad de vida del distrito con obras, acompanamiento y transparencia.
                </p>
                <button
                    class="mt-8 inline-flex items-center gap-2 rounded-xl bg-primary px-8 py-4 text-[14px] font-semibold leading-[1.2] tracking-[0.05em] text-on-primary transition hover:bg-secondary active:scale-[0.98]"
                    type="button"
                    x-on:click="showAlert('Recurso no disponible', 'El PDF completo del plan de gobierno aún no está disponible para descarga pública. Mientras tanto, puedes consultar las propuestas desde esta sección o preguntarle al asistente virtual.', 'info', 'download')"
                >
                    <span class="material-symbols-outlined">download</span>
                    Descargar Propuestas en PDF
                </button>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($proposalItems as $proposal)
                    <article class="campaign-card group p-8 transition duration-200 hover:-translate-y-1">
                        <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-primary-fixed text-primary transition group-hover:bg-primary group-hover:text-on-primary">
                            <span class="material-symbols-outlined text-[30px]">{{ $proposal->icon ?: 'flag' }}</span>
                        </div>
                        <h3 class="font-headline text-xl font-bold text-primary">{{ $proposal->title }}</h3>
                        <p class="mt-3 leading-7 text-on-surface-variant">{{ $proposal->summary }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if ($sectionVisible('regidores'))
    <section id="regidores" class="bg-surface py-16 md:py-28">
        <div class="campaign-container">
            <div class="mb-12 flex flex-col justify-between gap-4 md:flex-row md:items-end">
                <div>
                    <h2 class="font-headline text-4xl font-extrabold text-primary">Equipo de regidores</h2>
                    <p class="mt-3 max-w-2xl text-on-surface-variant">Un equipo vecinal con experiencia local y vocacion de servicio.</p>
                </div>
                <a class="campaign-button-outline" href="#contacto">Contactar equipo</a>
            </div>
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($councilItems as $member)
                    <article class="group text-center">
                        <div class="mb-6 aspect-square overflow-hidden rounded-[32px] shadow-[0px_10px_40px_rgba(33,68,139,0.06)] grayscale transition duration-200 group-hover:grayscale-0">
                            <img class="h-full w-full object-cover" src="{{ $imageUrl($member->photo_path) }}" alt="{{ $member->name }}">
                        </div>
                        <p class="mb-1 text-[14px] font-semibold uppercase leading-[1.2] tracking-[0.05em] text-secondary">{{ $member->position }}</p>
                        <h3 class="font-headline text-[24px] font-semibold leading-[1.3] text-primary">{{ $member->name }}</h3>
                        <p class="mt-2 px-4 leading-[1.6] text-on-surface-variant">{{ $member->bio }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if ($sectionVisible('equipo_tecnico'))
    <section class="bg-surface py-16 md:py-28">
        <div class="campaign-container space-y-12">
            <div class="space-y-4 text-center">
                <h2 class="font-headline text-4xl font-extrabold text-primary">Equipo Técnico</h2>
                <p class="mx-auto max-w-2xl text-lg leading-8 text-on-surface-variant">Especialistas comprometidos con el desarrollo técnico y profesional de Olleros.</p>
            </div>

            <div class="grid gap-8 sm:grid-cols-3">
                @foreach ($technicalItems as $member)
                    <article class="group text-center">
                        <div class="mb-6 aspect-square overflow-hidden rounded-[32px] shadow-[0px_10px_40px_rgba(33,68,139,0.06)] grayscale transition duration-200 group-hover:grayscale-0">
                            <img class="h-full w-full object-cover" src="{{ $imageUrl($member->photo_path) }}" alt="{{ $member->name }}">
                        </div>
                        <p class="mb-1 text-[14px] font-semibold uppercase leading-[1.2] tracking-[0.05em] text-secondary">{{ $member->role }}</p>
                        <h3 class="font-headline text-[24px] font-semibold leading-[1.3] text-primary">{{ $member->name }}</h3>
                        <p class="mt-2 px-4 leading-[1.6] text-on-surface-variant">{{ $member->bio }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if ($sectionVisible('distrito'))
    <section class="bg-surface-container-lowest py-16 md:py-28">
        <div class="campaign-container">
            <div class="mb-16 space-y-4 text-center">
                <h2 class="font-headline text-4xl font-extrabold text-primary">En el distrito</h2>
                <p class="mx-auto max-w-2xl text-lg leading-8 text-on-surface-variant">Imágenes de nuestras jornadas de diálogo y trabajo en las diversas comunidades de Olleros.</p>
            </div>

            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                @foreach ($districtItems as $image)
                    @php
                        $layoutClass = match ($image->layout) {
                            'featured' => 'col-span-2 row-span-2 min-h-[22rem]',
                            'wide' => 'col-span-2 h-64',
                            default => 'h-48 md:h-full',
                        };
                    @endphp
                    <div class="{{ $layoutClass }} overflow-hidden rounded-3xl shadow-[0px_10px_40px_rgba(33,68,139,0.06)]">
                        <img class="h-full w-full cursor-pointer object-cover transition duration-300 hover:scale-105" src="{{ $imageUrl($image->image_path) }}" alt="{{ $image->image_alt ?? $image->title }}">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if ($sectionVisible('sumate'))
    <section id="sumate" class="bg-surface py-16 md:py-28">
        <div class="campaign-container">
            <div class="campaign-card grid gap-10 rounded-[2rem] bg-surface-container-low p-8 md:grid-cols-2 md:p-12">
                <div class="space-y-6">
                    <h2 class="font-headline text-4xl font-extrabold text-primary">Unete al cambio</h2>
                    <p class="text-lg leading-8 text-on-surface-variant">
                        Queremos escucharte y que seas parte de esta familia. Tu aporte como voluntario o compartiendo ideas suma al Olleros del futuro.
                    </p>
                    <div class="space-y-4">
                        <div class="flex gap-4">
                            <span class="material-symbols-outlined text-secondary">volunteer_activism</span>
                            <div><strong class="text-primary">Voluntariado</strong><p class="text-on-surface-variant">Apoyo en brigadas y eventos.</p></div>
                        </div>
                        <div class="flex gap-4">
                            <span class="material-symbols-outlined text-secondary">lightbulb</span>
                            <div><strong class="text-primary">Aportes e ideas</strong><p class="text-on-surface-variant">Tu experiencia vale para el plan.</p></div>
                        </div>
                    </div>
                </div>
                <form class="rounded-2xl bg-white p-6 shadow-civic">
                    <label class="campaign-label" for="name">Nombre completo</label>
                    <input id="name" class="campaign-input" placeholder="Juan Perez">
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="campaign-label" for="email">Email</label>
                            <input id="email" type="email" class="campaign-input" placeholder="correo@ejemplo.com">
                        </div>
                        <div>
                            <label class="campaign-label" for="phone">Telefono</label>
                            <input id="phone" class="campaign-input" placeholder="999 999 999">
                        </div>
                    </div>
                    <label class="campaign-label mt-4" for="help">Como deseas ayudar?</label>
                    <select id="help" class="campaign-input">
                        <option>Ser voluntario</option>
                        <option>Proponer un proyecto</option>
                        <option>Mantenerme informado</option>
                    </select>
                    <button class="campaign-button-primary mt-6 w-full bg-secondary hover:bg-primary" type="button">Enviar informacion</button>
                </form>
            </div>
        </div>
    </section>
    @endif

    @if ($sectionVisible('transparencia'))
    <section id="transparencia" class="bg-surface-container-low py-16 md:py-28">
        <div class="campaign-container">
            <div class="mx-auto mb-12 max-w-3xl text-center">
                <h2 class="font-headline text-4xl font-extrabold text-primary">Transparencia de aportes</h2>
                <p class="mt-4 text-on-surface-variant">Registro publico de aportes recibidos para la campana.</p>
            </div>
            <div class="campaign-card overflow-x-auto rounded-2xl">
                <table class="w-full min-w-[720px] text-left">
                    <thead class="bg-primary text-on-primary">
                        <tr>
                            <th class="px-6 py-4">Aportante</th>
                            <th class="px-6 py-4">Tipo</th>
                            <th class="px-6 py-4">Detalle</th>
                            <th class="px-6 py-4">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/30">
                        @foreach ($contributionItems as $row)
                            <tr class="hover:bg-primary/5">
                                <td class="px-6 py-4">{{ $row->contributor_name }}</td>
                                <td class="px-6 py-4">{{ $row->contribution_type }}</td>
                                <td class="px-6 py-4">{{ $row->detail }}</td>
                                <td class="px-6 py-4">{{ \Illuminate\Support\Carbon::parse($row->contribution_date)->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @endif

    @if ($sectionVisible('contacto'))
    <section id="contacto" class="bg-surface py-16 md:py-24">
        <div class="campaign-container grid gap-10 md:grid-cols-3">
            <div class="md:col-span-2">
                <h2 class="font-headline text-4xl font-extrabold text-primary">Contacto</h2>
                <p class="mt-4 max-w-2xl text-lg leading-8 text-on-surface-variant">
                    Visitanos en la sede central o escribenos para coordinar reuniones vecinales, voluntariado y propuestas.
                </p>
            </div>
            <div class="campaign-card p-6">
                <p class="font-bold text-primary">Sede Central Olleros</p>
                <p class="mt-3 text-on-surface-variant">Jr. Libertad 123, Plaza de Armas de Olleros, Ancash</p>
                <p class="mt-3 text-on-surface-variant">contacto@mirkocacha.pe</p>
                <p class="mt-3 text-on-surface-variant">+51 987 654 321</p>
            </div>
        </div>
    </section>
    @endif
</x-public-layout>
