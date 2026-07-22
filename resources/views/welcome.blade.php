<x-public-layout title="Somos Peru | Mirko Cacha">
    <section class="relative flex min-h-screen items-center overflow-hidden bg-background pt-20">
        <div class="mx-auto grid w-full max-w-[1200px] items-center gap-12 px-5 py-14 md:grid-cols-12 md:px-6">
            <div class="space-y-8 md:col-span-7">
                <span class="inline-flex items-center gap-2 rounded-full bg-secondary-fixed px-4 py-1.5 text-[14px] font-semibold uppercase leading-[1.2] tracking-[0.05em] text-secondary">
                    <span class="h-2 w-2 rounded-full bg-secondary"></span>
                    Candidato a Alcalde 2024
                </span>

                <div class="space-y-6">
                    <h1 class="font-headline text-[56px] font-extrabold leading-[1.08] text-primary md:text-[80px]">
                        Agua, chacra y futuro para <span class="text-secondary">Olleros</span>
                    </h1>
                    <p class="max-w-xl text-[18px] leading-[1.6] text-on-surface-variant">
                        Mirko Cacha, candidato a la alcaldía distrital de Olleros. Un plan de gobierno construido desde el canal, la chacra y la plaza — no desde un escritorio.
                    </p>
                </div>

                <div class="flex flex-col gap-4 pt-4 sm:flex-row">
                    <a class="rounded-xl bg-primary px-8 py-4 text-center text-[14px] font-semibold leading-[1.2] tracking-[0.05em] text-on-primary shadow-none transition hover:bg-secondary" href="#sumate">Súmate al cambio</a>
                    <a class="campaign-button-outline" href="#plan">Ver Plan de Gobierno</a>
                </div>
            </div>

            <div class="group relative md:col-span-5">
                <div class="absolute -inset-4 rounded-[40px] bg-primary/5 blur-2xl transition group-hover:bg-secondary/5"></div>
                <div class="relative aspect-[4/5] overflow-hidden rounded-[40px] shadow-[0px_10px_40px_rgba(33,68,139,0.06)]">
                    <img class="h-full w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDgCorCyDnL3U6fpvzz9_KkG9Mvy8nfzviGLDZreVRtJWjQB01fOhnyLnTo7QYwJvJCViY72gEptCJ61Xz6usCU8Ltd-mV6o_thXu9zuPquFMqKevhN6qjhQKuOBQI4wf0ybmKfl9B-oFbrEmh_gh09H2OcpUVnDN6PHYRTyqLB-JJTbX_UAJJS_zuAhLOdcMVSCFjuuc7jla0CvxKTc55Ypdue6ntwA8pjZoUOJ-eKcIoTSNQti5TYuIaa0rQp3OQ7Dh00KpMHLA" alt="Mirko Cacha en paisaje andino de Olleros">
                </div>
            </div>
        </div>
    </section>

    <section id="biografia" class="bg-surface py-16 md:py-28">
        <div class="campaign-container grid items-center gap-12 md:grid-cols-2">
            <div class="relative order-2 md:order-1">
                <div class="absolute -left-4 -top-4 h-24 w-24 rounded-tl-3xl border-l-4 border-t-4 border-secondary/30"></div>
                <img class="relative w-full rounded-3xl shadow-[0px_10px_40px_rgba(33,68,139,0.06)]" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBjyBWYiwBoWfIj_gqGQyhWLs81N1I1WNEw4-B-eLi70wefeP_R0437rB1zduntzUAypyshKURPJyCdncY66L-1bwLVI_0kBYwx5hU1eaOiP8q7zwAUpO4wDVE2mGEqJpyUkOT9VqUr3hG1rfB7f4uHXJgO5QoEIClECThkK2CbQHYP2RjVzFKf7fFuCo4-yAJCQp5duQRJewhR4aLF9KnVwW_cm5evB4mwGSoImHluZLMh5xD0T1Rnl0fHL3rlFO3an3LWGI16OQ" alt="Mirko Cacha dialogando con agricultores de Olleros">
            </div>
            <div class="order-1 space-y-6 md:order-2">
                <h2 class="font-headline text-4xl font-extrabold text-primary">Mirko Cacha: experiencia y compromiso</h2>
                <div class="h-1.5 w-20 rounded-full bg-secondary"></div>
                <p class="text-lg leading-8 text-on-surface-variant">
                    Contador publico colegiado con trayectoria en gestion publica, administracion municipal y docencia. Conoce de cerca la realidad del campo, el turno de agua, la educacion rural y las necesidades de cada caserio.
                </p>
                <div class="grid gap-4 sm:grid-cols-3">
                    @foreach (['Gestion publica', 'Trayectoria academica', 'Trabajo comunal'] as $value)
                        <div class="flex items-center gap-3 font-bold text-primary">
                            <span class="material-symbols-outlined text-secondary">verified</span>
                            <span>{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="plan" class="bg-surface-container-low py-16 md:py-28">
        <div class="campaign-container">
            <div class="mx-auto mb-14 max-w-3xl text-center">
                <h2 class="font-headline text-4xl font-extrabold text-primary">Nuestras propuestas</h2>
                <p class="mt-4 text-lg leading-8 text-on-surface-variant">
                    Tres ejes de trabajo para transformar la calidad de vida del distrito con obras, acompanamiento y transparencia.
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                @foreach ([
                    ['water_drop', 'Agua y saneamiento', 'Agua potable de calidad y saneamiento digno para los centros poblados.'],
                    ['agriculture', 'Agricultura y riego', 'Canales tecnificados, apoyo al productor y asistencia tecnica permanente.'],
                    ['school', 'Educacion', 'Infraestructura moderna y programas de oportunidades para jovenes.'],
                    ['local_hospital', 'Salud', 'Atencion preventiva, postas fortalecidas y campanas medicas descentralizadas.'],
                    ['route', 'Caminos', 'Mantenimiento vial para conectar comunidades, chacras y mercados.'],
                    ['account_balance_wallet', 'Transparencia', 'Aportes, gastos y avances publicados para todos los vecinos.'],
                ] as [$icon, $title, $copy])
                    <article class="campaign-card group p-8 transition duration-200 hover:-translate-y-1">
                        <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-primary-fixed text-primary transition group-hover:bg-primary group-hover:text-on-primary">
                            <span class="material-symbols-outlined text-[30px]">{{ $icon }}</span>
                        </div>
                        <h3 class="font-headline text-xl font-bold text-primary">{{ $title }}</h3>
                        <p class="mt-3 leading-7 text-on-surface-variant">{{ $copy }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

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
                @foreach ([
                    ['Carmen Rojas', 'Primera Regidora', 'Ingeniera de Sistemas con especialidad en modernización del estado.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBQFhthJVk2oysLMe9NvFApkFB-Kr3TdvP6SwCdQcLShHOHyflhy2kSAyEwBzoqMUB4fU3T2eoMTwtFyEgompIJzg7K0lHqk4qSlaFVFyjr4M8eeH3FP24VKB5tS_PkBngyvRGpIIDDU8ksX7ime1Tgi8U1XICi6Qu66Wd8VZF18T_i_TuS0htk42Axja61XmEKuQYXAPhdzLLCPGFGl0dZqrvaSZWQcC-mbv-2eOiQEla_RmyyUE62KYuTEcocZaW-XW3qBbBcPA'],
                    ['Juan Huamán', 'Segundo Regidor', 'Especialista agrario con experiencia en riego tecnificado.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBZPAWWn2JpegQV_OkUjFlpQRpimxixhmkngOnFzhmYjeCupLbn08-s00yAVRt25jZqTOzotYvtA6R73-w04dn6ParP3oOwiZcmUANS24V7Ky1EsC3ZRti7e8GzWxEZpkNNGPahFwy_w4vjsYFYJ2R01r1gEP_jtQiSPAugnwOO7JvijYE2LoiGoedU2IdIozNXfFL3n2x4EK603_mN_ihmBiIf3kL12NV8kLh5QBCcI3Hwtn1kMTGlrX_Fldlz-vHhyjnCS84ihw'],
                    ['Sofía Paredes', 'Tercera Regidora', 'Abogada especialista en derecho administrativo y gestión municipal.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuCJjWxvycLpoub4d8BjXZ_Wt_BHnHa8kR2F3bJxshBbxWqHnt0A_ERdtL3n_E4AgxbeX7UFvQBJpYJBJPj09C69v329-UYvMYwA0pKx8g38x7qssafMd0Jel_fUPnkTEACWgBYpIAArvgvWd1RKdMRi-oANZl286rjM94yAdAHGl6dSWv1-383av8OuNT3nl8F7nCPYdFbSsXpEHZe_PtcQT2Zxx_wpegqRR5g1tS-UqzfULOnYCNejVrVZV1qnE5bO42Mgbvh8Ew'],
                    ['Luis Castro', 'Cuarto Regidor', 'Ingeniero Civil experto en infraestructura vial y saneamiento rural.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDEHZJZ4ZCfJ5d_x7UQUHFa44sVERu2gXHfDEuTcW3j4pk_TNxg7qGLzjjZfkC2BuIriAcvQWIr4G8KrxsyzIjkc3W9Yg6xuUx2IohP5o49ZNQSR8P_G7z9Yg_Izvp9QPmcN5VN1k1X9c3k5bjZD3uflDVbKkQR2WGnqK1IXCrMlMIggmGQYwtTU32oe620Q1G7qF1q7PRY1uaG55TaY9H8sSmQXLZkRVGYsBAvmrnBMUo3UDcNgvIGHcTe3H_aR8bDkedEcJch8w'],
                ] as [$member, $role, $copy, $photo])
                    <article class="group text-center">
                        <div class="mb-6 aspect-square overflow-hidden rounded-[32px] shadow-[0px_10px_40px_rgba(33,68,139,0.06)] grayscale transition duration-200 group-hover:grayscale-0">
                            <img class="h-full w-full object-cover" src="{{ $photo }}" alt="{{ $member }}">
                        </div>
                        <p class="mb-1 text-[14px] font-semibold uppercase leading-[1.2] tracking-[0.05em] text-secondary">{{ $role }}</p>
                        <h3 class="font-headline text-[24px] font-semibold leading-[1.3] text-primary">{{ $member }}</h3>
                        <p class="mt-2 px-4 leading-[1.6] text-on-surface-variant">{{ $copy }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

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
                        @foreach ([
                            ['Asociacion de Productores', 'Materiales', '1000 volantes', '15 Oct 2024'],
                            ['Comite Vecinal Barrio Centro', 'Organizacion', 'Sede para reunion', '12 Oct 2024'],
                            ['Aporte voluntario individual', 'Economico', 'S/ 500.00', '10 Oct 2024'],
                        ] as $row)
                            <tr class="hover:bg-primary/5">
                                @foreach ($row as $cell)
                                    <td class="px-6 py-4">{{ $cell }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

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
</x-public-layout>
