<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? config('app.name', 'Somos Peru Olleros') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    @php
        $layoutSections = isset($sections)
            ? $sections
            : \Illuminate\Support\Facades\DB::table('site_sections')
                ->whereNull('deleted_at')
                ->where('active', true)
                ->get()
                ->keyBy('key');
        $layoutSectionVisible = fn (string $key) => ! $layoutSections->has($key) || (bool) $layoutSections->get($key)->is_visible;
    @endphp
    <body x-data="campaignChat()" class="min-h-screen bg-background text-on-surface">
        <div class="fixed inset-0 z-[70] flex items-center justify-center bg-primary/20 p-4 backdrop-blur-sm" x-show="alertOpen" x-cloak x-transition>
            <div class="w-full max-w-sm rounded-[28px] border border-outline-variant/30 bg-white p-7 text-center shadow-2xl" x-on:click.outside="alertOpen = false">
                <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full" :class="alertTone === 'success' ? 'bg-primary-fixed text-primary' : 'bg-secondary-fixed text-secondary'">
                    <span class="material-symbols-outlined text-[34px]" x-text="alertIcon"></span>
                </div>
                <h3 class="font-headline text-2xl font-extrabold text-primary" x-text="alertTitle"></h3>
                <p class="mt-3 leading-7 text-on-surface-variant" x-text="alertMessage"></p>
                <button class="mt-6 w-full rounded-xl bg-primary px-6 py-3 text-[14px] font-semibold tracking-[0.05em] text-on-primary transition hover:bg-secondary" type="button" x-on:click="alertOpen = false">
                    Entendido
                </button>
            </div>
        </div>

        @if ($layoutSectionVisible('copa_olleros'))
        <div class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm" x-show="footballModal" x-cloak x-transition>
            <div class="relative max-h-[90vh] w-full max-w-xl overflow-y-auto rounded-[32px] bg-surface shadow-2xl" x-on:click.outside="footballModal = false">
                <button class="absolute right-6 top-6 flex h-10 w-10 items-center justify-center rounded-full text-on-surface-variant transition hover:bg-surface-variant" type="button" x-on:click="footballModal = false" aria-label="Cerrar">
                    <span class="material-symbols-outlined">close</span>
                </button>
                <div class="space-y-8 p-8 md:p-12">
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 rounded-full bg-secondary-fixed px-3 py-1 text-[12px] font-semibold uppercase tracking-wider text-secondary">
                            <span class="material-symbols-outlined text-[16px]">stars</span>
                            Copa Olleros 2026
                        </div>
                        <h2 class="font-headline text-[32px] font-bold leading-[1.2] text-primary md:text-[40px]">Inscripción al Campeonato Relámpago</h2>
                        <p class="text-on-surface-variant">Completa los datos de tu equipo para participar en el gran evento deportivo del distrito.</p>
                    </div>

                    <form class="space-y-6" x-on:submit.prevent="submitFootballTeam()">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="campaign-label">Nombre del Equipo</label>
                                <input class="campaign-input bg-white" placeholder="Ej. Los Guerreros de Olleros" type="text">
                            </div>
                            <div>
                                <label class="campaign-label">Nombre del Delegado</label>
                                <input class="campaign-input bg-white" placeholder="Nombre completo" type="text">
                            </div>
                        </div>
                        <div>
                            <label class="campaign-label">Teléfono de Contacto</label>
                            <input class="campaign-input bg-white" placeholder="999 999 999" type="tel">
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between border-b border-outline-variant pb-2">
                                <h4 class="flex items-center gap-2 font-headline text-[18px] font-semibold text-primary">
                                    <span class="material-symbols-outlined text-secondary">groups</span>
                                    Lista de Jugadores
                                </h4>
                                <button class="flex items-center gap-1 text-[12px] font-semibold uppercase tracking-wide text-secondary hover:underline" type="button" x-on:click="addFootballPlayer()">
                                    <span class="material-symbols-outlined text-[18px]">add_circle</span>
                                    Agregar Jugador
                                </button>
                            </div>
                            <template x-for="(player, index) in footballPlayers" :key="player.id">
                                <div class="grid grid-cols-12 gap-3">
                                    <input class="col-span-7 rounded-lg border-outline-variant px-4 py-2 text-sm" placeholder="Nombre del Jugador" type="text" x-model="player.name">
                                    <input class="col-span-4 rounded-lg border-outline-variant px-4 py-2 text-sm" placeholder="DNI" type="text" x-model="player.dni">
                                    <button class="col-span-1 flex items-center justify-center rounded-lg text-error transition hover:bg-error/10" type="button" x-show="footballPlayers.length > 1" x-on:click="removeFootballPlayer(index)" aria-label="Quitar jugador">
                                        <span class="material-symbols-outlined text-[20px]">remove_circle</span>
                                    </button>
                                </div>
                            </template>
                        </div>
                        <button class="w-full rounded-xl bg-primary py-4 text-[14px] font-semibold tracking-[0.05em] text-on-primary transition hover:bg-secondary" type="submit">Registrar Equipo</button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <header class="fixed left-0 right-0 top-0 z-50 h-20 bg-surface/80 shadow-[0px_10px_40px_rgba(33,68,139,0.06)] backdrop-blur-md">
            <div class="mx-auto flex h-full w-full max-w-[1200px] items-center justify-between px-5 md:px-6">
                <x-campaign-logo />

                <nav class="hidden items-center gap-6 md:flex lg:gap-8">
                    @if ($layoutSectionVisible('biografia'))
                        <a class="text-[13px] font-semibold leading-[1.2] tracking-[0.04em] text-on-surface-variant transition hover:text-secondary" href="{{ route('landing') }}#biografia">Quién es</a>
                    @endif
                    @if ($layoutSectionVisible('plan'))
                        <a class="text-[13px] font-semibold leading-[1.2] tracking-[0.04em] text-on-surface-variant transition hover:text-secondary" href="{{ route('landing') }}#plan">Plan de Gobierno</a>
                    @endif
                    @if ($layoutSectionVisible('regidores'))
                        <a class="text-[13px] font-semibold leading-[1.2] tracking-[0.04em] text-on-surface-variant transition hover:text-secondary" href="{{ route('landing') }}#regidores">Regidores</a>
                    @endif
                    @if ($layoutSectionVisible('contacto'))
                        <a class="text-[13px] font-semibold leading-[1.2] tracking-[0.04em] text-on-surface-variant transition hover:text-secondary" href="{{ route('landing') }}#contacto">Contacto</a>
                    @endif
                    @if ($layoutSectionVisible('copa_olleros'))
                        <button class="group relative flex items-center gap-1 text-[14px] font-bold leading-[1.2] tracking-[0.05em] text-secondary transition hover:text-primary" type="button" x-on:click="footballModal = true">
                            <span class="material-symbols-outlined text-[18px]">sports_soccer</span>
                            Copa Olleros
                            <span class="absolute -right-3 -top-3 animate-pulse rounded-full bg-primary px-1.5 py-0.5 text-[9px] font-bold uppercase text-on-primary">Nuevo</span>
                        </button>
                    @endif
                </nav>

                <div class="hidden items-center gap-4 md:ml-8 md:flex lg:ml-10">
                    @auth
                        <a class="px-4 text-[13px] font-semibold leading-[1.2] tracking-[0.04em] text-primary transition hover:text-secondary" href="{{ route('dashboard') }}">Dashboard</a>
                    @else
                        <a class="px-4 text-[13px] font-semibold leading-[1.2] tracking-[0.04em] text-primary transition hover:text-secondary" href="{{ route('login') }}">Iniciar Sesión</a>
                    @endauth
                    @if ($layoutSectionVisible('sumate'))
                        <a class="rounded-lg bg-primary px-6 py-2.5 text-[13px] font-semibold leading-[1.2] tracking-[0.04em] text-on-primary transition hover:bg-secondary" href="{{ route('landing') }}#sumate">Súmate</a>
                    @endif
                </div>

                <button type="button" class="rounded-lg p-2 text-primary md:hidden" x-on:click="menuOpen = ! menuOpen" aria-label="Abrir menú">
                    <span class="material-symbols-outlined" x-text="menuOpen ? 'close' : 'menu'"></span>
                </button>
            </div>

            <div class="border-t border-outline-variant/20 bg-surface px-5 py-5 lg:hidden" x-show="menuOpen" x-transition>
                <nav class="campaign-container flex flex-col gap-4 font-semibold text-on-surface-variant">
                    @if ($layoutSectionVisible('biografia'))
                        <a href="{{ route('landing') }}#biografia">Quién es</a>
                    @endif
                    @if ($layoutSectionVisible('plan'))
                        <a href="{{ route('landing') }}#plan">Plan de Gobierno</a>
                    @endif
                    @if ($layoutSectionVisible('regidores'))
                        <a href="{{ route('landing') }}#regidores">Regidores</a>
                    @endif
                    @if ($layoutSectionVisible('contacto'))
                        <a href="{{ route('landing') }}#contacto">Contacto</a>
                    @endif
                    @if ($layoutSectionVisible('copa_olleros'))
                        <button class="text-left text-secondary" type="button" x-on:click="footballModal = true; menuOpen = false">Copa Olleros</button>
                    @endif
                    @auth
                        <a class="text-primary" href="{{ route('dashboard') }}">Dashboard</a>
                    @else
                        <a class="text-primary" href="{{ route('login') }}">Iniciar Sesión</a>
                    @endauth
                    @if ($layoutSectionVisible('sumate'))
                        <a class="campaign-button-primary" href="{{ route('landing') }}#sumate">Súmate</a>
                    @endif
                </nav>
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>

        @if ($layoutSectionVisible('chatbot'))
        <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
            <div class="mb-4 w-80 overflow-hidden rounded-3xl border border-outline-variant/30 bg-surface shadow-2xl md:w-96" x-show="chatOpen" x-cloak x-transition>
                <div class="flex items-center justify-between bg-primary p-4 text-on-primary">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white/20">
                            <span class="material-symbols-outlined text-[20px]">smart_toy</span>
                        </div>
                        <span class="font-headline text-[16px] font-semibold">Asistente Virtual</span>
                    </div>
                    <button class="rounded-full p-1 hover:bg-white/10" type="button" x-on:click="chatOpen = false" aria-label="Cerrar chat">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <div class="max-h-[400px] space-y-4 overflow-y-auto p-6" x-ref="chatBody">
                    <template x-for="(message, index) in chatMessages" :key="index">
                        <div class="max-w-[86%] rounded-2xl p-4 leading-6"
                             :class="message.type === 'user' ? 'ml-auto rounded-tr-none bg-primary text-on-primary' : 'rounded-tl-none bg-surface-container-low text-on-surface-variant'"
                             x-text="message.text"></div>
                    </template>

                    <div class="space-y-2" x-show="showChatChips">
                        <p class="ml-1 text-[14px] font-semibold uppercase tracking-[0.05em] text-on-surface-variant">Preguntas Frecuentes</p>
                        <template x-for="item in chatFaq.slice(0, 6)" :key="item.q">
                            <button class="flex w-full items-center justify-between rounded-xl border border-outline-variant p-3 text-left transition hover:border-primary hover:bg-primary/5" type="button" x-on:click="askChat(item.q, item)">
                                <span x-text="item.q"></span>
                                <span class="material-symbols-outlined text-primary">chevron_right</span>
                            </button>
                        </template>
                    </div>
                </div>
                <div class="border-t border-outline-variant/20 bg-surface-container-lowest p-4">
                    <div class="relative">
                        <input class="w-full rounded-full border-outline-variant px-4 py-2 pr-11 focus:border-primary focus:ring-primary/20" placeholder="Escribe tu mensaje..." type="text" x-model="chatInput" x-on:keydown.enter="sendChat()">
                        <button class="absolute right-2 top-1/2 -translate-y-1/2 text-primary" type="button" aria-label="Enviar" x-on:click="sendChat()">
                            <span class="material-symbols-outlined">send</span>
                        </button>
                    </div>
                </div>
            </div>

            <button class="mb-3 rounded-2xl border border-outline-variant/20 bg-white px-4 py-2 text-left shadow-lg transition hover:-translate-y-0.5 hover:shadow-xl" type="button" x-show="! chatOpen" x-cloak x-transition x-on:click="openChat()">
                <p class="text-[14px] font-semibold leading-[1.2] tracking-[0.05em] text-primary">¿Tienes dudas? ¡Pregúntame!</p>
            </button>
            <button class="flex h-16 w-16 items-center justify-center rounded-full bg-primary text-on-primary shadow-2xl transition hover:scale-110 hover:bg-secondary active:scale-95" type="button" x-on:click="chatOpen ? chatOpen = false : openChat()" aria-label="Abrir chat">
                <span class="material-symbols-outlined text-[32px]">chat</span>
            </button>
        </div>
        @endif

        <footer class="border-t border-outline-variant/30 bg-surface-container-low">
            <div class="campaign-container grid gap-10 py-16 md:grid-cols-[1.4fr_1fr_1fr]">
                <div class="space-y-5">
                    <x-campaign-logo class="[&>span:last-child]:text-xl" />
                    <p class="max-w-md text-on-surface-variant">
                        Agua, chacra y futuro para Olleros. Una campaña construida con transparencia, trabajo comunal y servicio.
                    </p>
                </div>
                <div>
                    <h3 class="mb-4 font-headline text-lg font-bold text-primary">Enlaces</h3>
                    <div class="flex flex-col gap-3 text-on-surface-variant">
                        @if ($layoutSectionVisible('plan'))
                            <a class="hover:text-secondary" href="{{ route('landing') }}#plan">Propuestas</a>
                        @endif
                        @if ($layoutSectionVisible('transparencia'))
                            <a class="hover:text-secondary" href="{{ route('landing') }}#transparencia">Transparencia</a>
                        @endif
                        @if ($layoutSectionVisible('sumate'))
                            <a class="hover:text-secondary" href="{{ route('landing') }}#sumate">Súmate</a>
                        @endif
                    </div>
                </div>
                <div>
                    <h3 class="mb-4 font-headline text-lg font-bold text-primary">Contacto</h3>
                    <div class="space-y-3 text-on-surface-variant">
                        <p>Jr. Libertad 123, Plaza de Armas de Olleros</p>
                        <p>contacto@mirkocacha.pe</p>
                        <p>+51 987 654 321</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-outline-variant/20 py-5 text-center text-sm text-on-surface-variant">
                <p>© 2026 Somos Perú Olleros. Todos los derechos reservados.</p>
                <p class="mt-2 text-[12px]">
                    Desarrollado por
                    <a class="font-bold text-primary transition hover:text-secondary hover:underline" href="http://ceartech.calvarador.com/" target="_blank" rel="noopener noreferrer">CEAR TECH INNOVATIONS</a>
                </p>
            </div>
        </footer>

        <script>
            function campaignChat() {
                return {
                    menuOpen: false,
                    footballModal: false,
                    chatOpen: false,
                    chatInput: '',
                    alertOpen: false,
                    alertTone: 'info',
                    alertTitle: '',
                    alertMessage: '',
                    alertIcon: 'info',
                    footballPlayers: [{ id: 1, name: '', dni: '' }],
                    showChatChips: true,
                    chatMessages: [],
                    chatFaq: [
                        { q: '¿Cuáles son las propuestas principales?', keys: ['propuesta', 'propuestas', 'plan', 'gobierno', 'principal'], a: 'El plan se ordena en cuatro frentes: desarrollo social, economía local, ambiente y gestión municipal. En simple: mejor educación y salud, agua y saneamiento, apoyo real al productor, turismo, seguridad, limpieza pública y una municipalidad más transparente.' },
                        { q: '¿Qué harán por la educación?', keys: ['educacion', 'educación', 'colegio', 'escuela', 'biblioteca', 'ceba', 'cetpro', 'unasam'], a: 'Se propone reforzar aprendizajes, capacitar docentes, impulsar una academia de preparación en convenio con la UNASAM, crear una biblioteca municipal con internet, promover educación técnica con CETPRO y abrir oportunidades para jóvenes y adultos mediante CEBA.' },
                        { q: '¿Qué plantea el plan en salud?', keys: ['salud', 'posta', 'medico', 'médico', 'anemia', 'desnutricion', 'desnutrición', 'adulto mayor', 'jampiwayi'], a: 'La prioridad es atender mejor y prevenir. El plan incluye ampliar y equipar el Centro de Salud de Huaripampa, hacer campañas integrales en todo el distrito, reducir anemia y desnutrición infantil, atender a adultos mayores y gestionar especialistas con atención virtual y presencial mediante Jampiwayi.' },
                        { q: '¿Qué se propone para agua y saneamiento?', keys: ['agua', 'saneamiento', 'desague', 'desagüe', 'jass', 'cloracion', 'cloración', 'huaripampa'], a: 'El plan plantea mejorar el monitoreo del agua potable con las JASS, asegurar cloración y mantenimiento, y construir el sistema de agua potable y desagüe del Centro Poblado de Huaripampa, incluyendo planta de tratamiento e instalación para caseríos que aún faltan.' },
                        { q: '¿Cómo apoyarán a la chacra y a los productores?', keys: ['agricultura', 'chacra', 'productor', 'productores', 'riego', 'canal', 'reservorio', 'semilla', 'hortalizas', 'frutales'], a: 'La propuesta es pasar del discurso al agua y asistencia en campo: riego tecnificado, canales y reservorios, capacitación, producción de semillas y almácigos, abono orgánico y proyectos de hortalizas y frutales en caseríos como Ututupampa, Lloclla, Pacchapampa, Mashuan, Aco y otros.' },
                        { q: '¿Qué es el IDIA Olleros?', keys: ['idia', 'investigacion', 'investigación', 'agropecuaria', 'almacigos', 'almácigos'], a: 'El IDIA Olleros es la propuesta de crear un Instituto Distrital de Investigación Agropecuaria en Cascapampa. Serviría para producir semillas, almácigos, abono orgánico y formar técnicos de cada caserío.' },
                        { q: '¿Qué hay sobre carreteras y pavimentación?', keys: ['carretera', 'pavimentacion', 'pavimentación', 'vias', 'vías', 'camino', 'huaripampa', 'aco'], a: 'El plan incluye mantenimiento vial del tramo Puente Bedoya - Olleros - Huaripampa, mejora de vías urbanas, pavimentación en Villa Olleros, Aco, Mashuan y anexos, además de carreteras como Arzobispo - Huaripampa y Huaripampa - Ambey - Tayapampa - Lloclla - Ututupampa - Mashuan.' },
                        { q: '¿Qué propone para turismo?', keys: ['turismo', 'turistico', 'turístico', 'arzobispo', 'quechquepunta', 'canrray', 'jauna', 'ututupampa'], a: 'Se proponen circuitos turísticos que conecten Arzobispo, Quechquepunta, Canrray Grande, Villa Olleros, Mashuan, Jauna, Ututupampa, Lloclla y Aco. La idea es mover economía local con miradores, comidas típicas, restos arqueológicos, recreación y aguas termales.' },
                        { q: '¿Qué se hará por el ambiente y la limpieza?', keys: ['ambiente', 'ambiental', 'residuos', 'basura', 'limpieza', 'reciclaje', 'areas verdes', 'áreas verdes'], a: 'El plan plantea una gestión integral de residuos sólidos, con reciclaje, clasificación, relleno sanitario y una planta de tratamiento en Canrray Grande. También considera mejorar parques, jardines y áreas verdes.' },
                        { q: '¿Qué propone en seguridad ciudadana?', keys: ['seguridad', 'camara', 'cámara', 'vigilancia', 'patrullaje', 'codisec', 'policia', 'policía'], a: 'Se propone implementar un sistema de seguridad ciudadana con equipamiento y cámaras de vigilancia, fortalecer el patrullaje integrado con CODISEC y la Policía Nacional, y trabajar con organizaciones sociales de base.' },
                        { q: '¿Cómo mejorará la municipalidad?', keys: ['municipalidad', 'gestion', 'gestión', 'tramite', 'trámite', 'transparencia', 'rendicion', 'rendición', 'catastro'], a: 'El plan habla de reingeniería administrativa, simplificación de trámites, capacitación de servidores, sistema virtual de gestión documentaria, catastro distrital y rendición de cuentas permanente para que la gestión sea más ordenada y transparente.' },
                        { q: '¿Cómo puedo sumarme?', keys: ['sumar', 'sumarme', 'voluntario', 'contacto', 'ayudar', 'apoyar'], a: 'Puedes dejar tus datos en la sección Súmate. La idea es que vecinos, jóvenes, productores y profesionales puedan aportar como voluntarios, proponer proyectos o mantenerse informados.' }
                    ],
                    openChat() {
                        this.chatOpen = true;
                        this.startChat();
                    },
                    startChat() {
                        if (this.chatMessages.length) return;
                        this.chatMessages.push({ type: 'bot', text: '¡Hola! Soy el asistente virtual de la campaña. Puedo contarte el plan de gobierno 2027-2030 en palabras simples. Elige una pregunta o escríbeme sobre agua, salud, educación, chacra, turismo, ambiente o seguridad.' });
                        this.scrollChat();
                    },
                    normalize(text) {
                        return text.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
                    },
                    findAnswer(text) {
                        const clean = this.normalize(text);
                        return this.chatFaq.find(item => item.keys.some(key => clean.includes(this.normalize(key))));
                    },
                    askChat(text, forcedItem = null) {
                        if (!text.trim()) return;
                        this.showChatChips = false;
                        this.chatMessages.push({ type: 'user', text });
                        const item = forcedItem || this.findAnswer(text);
                        window.setTimeout(() => {
                            this.chatMessages.push({ type: 'bot', text: item ? item.a : 'Todavía no tengo una respuesta exacta para eso. Prueba preguntando por agua, educación, salud, chacra, turismo, seguridad, ambiente o transparencia.' });
                            if (!item) this.showChatChips = true;
                            this.scrollChat();
                        }, 250);
                        this.scrollChat();
                    },
                    sendChat() {
                        const text = this.chatInput;
                        this.chatInput = '';
                        this.askChat(text);
                    },
                    scrollChat() {
                        this.$nextTick(() => {
                            if (this.$refs.chatBody) this.$refs.chatBody.scrollTop = this.$refs.chatBody.scrollHeight;
                        });
                    },
                    showAlert(title, message, tone = 'info', icon = 'info') {
                        this.alertTitle = title;
                        this.alertMessage = message;
                        this.alertTone = tone;
                        this.alertIcon = icon;
                        this.alertOpen = true;
                    },
                    addFootballPlayer() {
                        this.footballPlayers.push({ id: Date.now() + Math.random(), name: '', dni: '' });
                    },
                    removeFootballPlayer(index) {
                        this.footballPlayers.splice(index, 1);
                    },
                    submitFootballTeam() {
                        this.footballModal = false;
                        this.showAlert(
                            'Inscripción recibida',
                            'Gracias. Hemos registrado la consulta de tu equipo para Copa Olleros. El equipo de campaña se comunicará para confirmar los datos.',
                            'success',
                            'sports_soccer'
                        );
                    }
                };
            }
        </script>
    </body>
</html>
