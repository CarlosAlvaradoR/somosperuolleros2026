<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Carga inicial del contenido público de la campaña.
 *
 * Este seeder copia la maqueta actual a la base de datos para que el sitio
 * arranque con contenido realista y luego pueda administrarse desde panel.
 * Usamos updateOrInsert para que el seeder sea idempotente: si se ejecuta
 * otra vez, actualiza el registro existente en lugar de duplicarlo.
 */
class CampaignSiteSeeder extends Seeder
{
    /**
     * Ejecuta la carga por dominios de contenido, en el mismo orden de la landing.
     */
    public function run(): void
    {
        $now = now();

        $this->seedSections($now);
        $this->seedHero($now);
        $this->seedBiography($now);
        $this->seedProposals($now);
        $this->seedCouncilMembers($now);
        $this->seedTechnicalTeam($now);
        $this->seedDistrictGallery($now);
        $this->seedTransparency($now);
        $this->seedContact($now);
        $this->seedChatbotFaqs($now);
    }

    /**
     * Configura el interruptor general de cada bloque público.
     *
     * site_sections es la tabla que luego permitirá decidir desde el dashboard
     * si se muestra u oculta una sección completa, además de guardar textos
     * pequeños de UI que no necesitan una tabla propia.
     */
    private function seedSections($now): void
    {
        $sections = [
            [
                'key' => 'hero',
                'name' => 'Portada',
                'description' => 'Bloque principal de presentación del candidato.',
                'sort_order' => 10,
                'settings' => [
                    'show_eyebrow' => true,
                    'show_primary_button' => true,
                    'show_secondary_button' => true,
                ],
            ],
            [
                'key' => 'biografia',
                'name' => 'Quién es',
                'description' => 'Presentación de experiencia y compromiso.',
                'sort_order' => 20,
                'settings' => [
                    'title' => 'Mirko Cacha: experiencia y compromiso',
                ],
            ],
            [
                'key' => 'plan',
                'name' => 'Plan de Gobierno',
                'description' => 'Listado de propuestas principales.',
                'sort_order' => 30,
                'settings' => [
                    'title' => 'Nuestras propuestas',
                    'subtitle' => 'Tres ejes de trabajo para transformar la calidad de vida del distrito con obras, acompañamiento y transparencia.',
                    'download_button' => 'Descargar Propuestas en PDF',
                    'download_alert_title' => 'Recurso no disponible',
                    'download_alert_message' => 'El PDF completo del plan de gobierno aún no está disponible para descarga pública. Mientras tanto, puedes consultar las propuestas desde esta sección o preguntarle al asistente virtual.',
                ],
            ],
            [
                'key' => 'regidores',
                'name' => 'Regidores',
                'description' => 'Equipo de regidores mostrado en la landing.',
                'sort_order' => 40,
                'settings' => [
                    'title' => 'Equipo de regidores',
                    'subtitle' => 'Un equipo vecinal con experiencia local y vocación de servicio.',
                    'button_label' => 'Contactar equipo',
                    'button_url' => '#contacto',
                ],
            ],
            [
                'key' => 'equipo_tecnico',
                'name' => 'Equipo Técnico',
                'description' => 'Especialistas comprometidos con el desarrollo del distrito.',
                'sort_order' => 50,
                'settings' => [
                    'title' => 'Equipo Técnico',
                    'subtitle' => 'Especialistas comprometidos con el desarrollo técnico y profesional de Olleros.',
                ],
            ],
            [
                'key' => 'distrito',
                'name' => 'En el distrito',
                'description' => 'Galería de jornadas de diálogo y trabajo.',
                'sort_order' => 60,
                'settings' => [
                    'title' => 'En el distrito',
                    'subtitle' => 'Imágenes de nuestras jornadas de diálogo y trabajo en las diversas comunidades de Olleros.',
                ],
            ],
            [
                'key' => 'sumate',
                'name' => 'Únete al cambio',
                'description' => 'Formulario para voluntarios, ideas y contacto ciudadano.',
                'sort_order' => 70,
                'settings' => [
                    'title' => 'Únete al cambio',
                    'subtitle' => 'Queremos escucharte y que seas parte de esta familia. Tu aporte como voluntario o compartiendo ideas suma al Olleros del futuro.',
                    'benefits' => [
                        ['icon' => 'volunteer_activism', 'title' => 'Voluntariado', 'description' => 'Apoyo en brigadas y eventos.'],
                        ['icon' => 'lightbulb', 'title' => 'Aportes e ideas', 'description' => 'Tu experiencia vale para el plan.'],
                    ],
                    'support_options' => [
                        'Ser voluntario',
                        'Proponer un proyecto',
                        'Mantenerme informado',
                    ],
                ],
            ],
            [
                'key' => 'transparencia',
                'name' => 'Transparencia de aportes',
                'description' => 'Registro público de aportes recibidos para la campaña.',
                'sort_order' => 80,
                'settings' => [
                    'title' => 'Transparencia de aportes',
                    'subtitle' => 'Registro público de aportes recibidos para la campaña.',
                ],
            ],
            [
                'key' => 'contacto',
                'name' => 'Contacto',
                'description' => 'Información visible de contacto y sede.',
                'sort_order' => 90,
                'settings' => [
                    'title' => 'Contacto',
                    'subtitle' => 'Visítanos en la sede central o escríbenos para coordinar reuniones vecinales, voluntariado y propuestas.',
                ],
            ],
            [
                'key' => 'copa_olleros',
                'name' => 'Copa Olleros',
                'description' => 'Modal de inscripción al campeonato relámpago.',
                'sort_order' => 100,
                'settings' => [
                    'badge' => 'Copa Olleros 2026',
                    'title' => 'Inscripción al Campeonato Relámpago',
                    'subtitle' => 'Completa los datos de tu equipo para participar en el gran evento deportivo del distrito.',
                    'status_label' => 'Nuevo',
                ],
            ],
            [
                'key' => 'chatbot',
                'name' => 'Chatbot',
                'description' => 'Asistente virtual de propuestas.',
                'sort_order' => 110,
                'settings' => [
                    'bubble_text' => '¿Tienes dudas? ¡Pregúntame!',
                    'title' => 'Asistente Virtual',
                ],
            ],
        ];

        foreach ($sections as $section) {
            DB::table('site_sections')->updateOrInsert(
                ['key' => $section['key']],
                [
                    'name' => $section['name'],
                    'description' => $section['description'],
                    'is_visible' => true,
                    'sort_order' => $section['sort_order'],
                    'settings' => json_encode($section['settings'], JSON_UNESCAPED_UNICODE),
                    'active' => true,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }

    /**
     * Carga la portada principal: etiqueta, titular, botones y foto hero.
     */
    private function seedHero($now): void
    {
        DB::table('landing_hero_contents')->updateOrInsert(
            ['title' => 'Agua, chacra y futuro para'],
            [
                'eyebrow' => 'Candidato a Alcalde 2026',
                'highlighted_title' => 'Olleros',
                'description' => 'Mirko Cacha, candidato a la alcaldía distrital de Olleros. Un plan de gobierno construido desde el canal, la chacra y la plaza — no desde un escritorio.',
                'primary_button_label' => 'Súmate al cambio',
                'primary_button_url' => '#sumate',
                'secondary_button_label' => 'Ver Plan de Gobierno',
                'secondary_button_url' => '#plan',
                'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDgCorCyDnL3U6fpvzz9_KkG9Mvy8nfzviGLDZreVRtJWjQB01fOhnyLnTo7QYwJvJCViY72gEptCJ61Xz6usCU8Ltd-mV6o_thXu9zuPquFMqKevhN6qjhQKuOBQI4wf0ybmKfl9B-oFbrEmh_gh09H2OcpUVnDN6PHYRTyqLB-JJTbX_UAJJS_zuAhLOdcMVSCFjuuc7jla0CvxKTc55Ypdue6ntwA8pjZoUOJ-eKcIoTSNQti5TYuIaa0rQp3OQ7Dh00KpMHLA',
                'image_alt' => 'Mirko Cacha en paisaje andino de Olleros',
                'campaign_year' => 2026,
                'active' => true,
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );
    }

    /**
     * Carga la biografía principal del candidato y sus tres credenciales visibles.
     */
    private function seedBiography($now): void
    {
        DB::table('candidate_biographies')->updateOrInsert(
            ['title' => 'Mirko Cacha: experiencia y compromiso'],
            [
                'summary' => 'Contador público colegiado con trayectoria en gestión pública, administración municipal y docencia. Conoce de cerca la realidad del campo, el turno de agua, la educación rural y las necesidades de cada caserío.',
                'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBjyBWYiwBoWfIj_gqGQyhWLs81N1I1WNEw4-B-eLi70wefeP_R0437rB1zduntzUAypyshKURPJyCdncY66L-1bwLVI_0kBYwx5hU1eaOiP8q7zwAUpO4wDVE2mGEqJpyUkOT9VqUr3hG1rfB7f4uHXJgO5QoEIClECThkK2CbQHYP2RjVzFKf7fFuCo4-yAJCQp5duQRJewhR4aLF9KnVwW_cm5evB4mwGSoImHluZLMh5xD0T1Rnl0fHL3rlFO3an3LWGI16OQ',
                'image_alt' => 'Mirko Cacha dialogando con agricultores de Olleros',
                'facts' => json_encode(['Gestión pública', 'Trayectoria académica', 'Trabajo comunal'], JSON_UNESCAPED_UNICODE),
                'active' => true,
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );
    }

    /**
     * Carga las tarjetas del plan de gobierno que aparecen en la sección Propuestas.
     */
    private function seedProposals($now): void
    {
        $proposals = [
            ['water_drop', 'Agua y saneamiento', 'Servicios básicos', 'Agua potable de calidad y saneamiento digno para los centros poblados.'],
            ['agriculture', 'Agricultura y riego', 'Campo', 'Canales tecnificados, apoyo al productor y asistencia técnica permanente.'],
            ['school', 'Educación', 'Desarrollo social', 'Infraestructura moderna y programas de oportunidades para jóvenes.'],
            ['local_hospital', 'Salud', 'Desarrollo social', 'Atención preventiva, postas fortalecidas y campañas médicas descentralizadas.'],
            ['route', 'Caminos', 'Infraestructura', 'Mantenimiento vial para conectar comunidades, chacras y mercados.'],
            ['account_balance_wallet', 'Transparencia', 'Gestión municipal', 'Aportes, gastos y avances publicados para todos los vecinos.'],
        ];

        foreach ($proposals as $index => [$icon, $title, $category, $summary]) {
            DB::table('government_proposals')->updateOrInsert(
                ['title' => $title],
                [
                    'icon' => $icon,
                    'category' => $category,
                    'summary' => $summary,
                    'description' => $summary,
                    'image_path' => null,
                    'image_alt' => null,
                    'cta_label' => null,
                    'cta_url' => null,
                    'sort_order' => ($index + 1) * 10,
                    'is_featured' => $index < 3,
                    'active' => true,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }

    /**
     * Carga el equipo de regidores de la maqueta con cargo, descripción y foto.
     */
    private function seedCouncilMembers($now): void
    {
        $members = [
            ['Carmen Rojas', 'Primera Regidora', 'Ingeniera de Sistemas con especialidad en modernización del estado.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBQFhthJVk2oysLMe9NvFApkFB-Kr3TdvP6SwCdQcLShHOHyflhy2kSAyEwBzoqMUB4fU3T2eoMTwtFyEgompIJzg7K0lHqk4qSlaFVFyjr4M8eeH3FP24VKB5tS_PkBngyvRGpIIDDU8ksX7ime1Tgi8U1XICi6Qu66Wd8VZF18T_i_TuS0htk42Axja61XmEKuQYXAPhdzLLCPGFGl0dZqrvaSZWQcC-mbv-2eOiQEla_RmyyUE62KYuTEcocZaW-XW3qBbBcPA'],
            ['Juan Huamán', 'Segundo Regidor', 'Especialista agrario con experiencia en riego tecnificado.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBZPAWWn2JpegQV_OkUjFlpQRpimxixhmkngOnFzhmYjeCupLbn08-s00yAVRt25jZqTOzotYvtA6R73-w04dn6ParP3oOwiZcmUANS24V7Ky1EsC3ZRti7e8GzWxEZpkNNGPahFwy_w4vjsYFYJ2R01r1gEP_jtQiSPAugnwOO7JvijYE2LoiGoedU2IdIozNXfFL3n2x4EK603_mN_ihmBiIf3kL12NV8kLh5QBCcI3Hwtn1kMTGlrX_Fldlz-vHhyjnCS84ihw'],
            ['Sofía Paredes', 'Tercera Regidora', 'Abogada especialista en derecho administrativo y gestión municipal.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuCJjWxvycLpoub4d8BjXZ_Wt_BHnHa8kR2F3bJxshBbxWqHnt0A_ERdtL3n_E4AgxbeX7UFvQBJpYJBJPj09C69v329-UYvMYwA0pKx8g38x7qssafMd0Jel_fUPnkTEACWgBYpIAArvgvWd1RKdMRi-oANZl286rjM94yAdAHGl6dSWv1-383av8OuNT3nl8F7nCPYdFbSsXpEHZe_PtcQT2Zxx_wpegqRR5g1tS-UqzfULOnYCNejVrVZV1qnE5bO42Mgbvh8Ew'],
            ['Luis Castro', 'Cuarto Regidor', 'Ingeniero Civil experto en infraestructura vial y saneamiento rural.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDEHZJZ4ZCfJ5d_x7UQUHFa44sVERu2gXHfDEuTcW3j4pk_TNxg7qGLzjjZfkC2BuIriAcvQWIr4G8KrxsyzIjkc3W9Yg6xuUx2IohP5o49ZNQSR8P_G7z9Yg_Izvp9QPmcN5VN1k1X9c3k5bjZD3uflDVbKkQR2WGnqK1IXCrMlMIggmGQYwtTU32oe620Q1G7qF1q7PRY1uaG55TaY9H8sSmQXLZkRVGYsBAvmrnBMUo3UDcNgvIGHcTe3H_aR8bDkedEcJch8w'],
        ];

        foreach ($members as $index => [$name, $position, $bio, $photo]) {
            DB::table('council_members')->updateOrInsert(
                ['name' => $name],
                [
                    'position' => $position,
                    'bio' => $bio,
                    'photo_path' => $photo,
                    'photo_alt' => $name,
                    'sort_order' => ($index + 1) * 10,
                    'active' => true,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }

    /**
     * Carga el equipo técnico. Si una persona no tiene foto real, se usa el placeholder
     * que ya venía en la maqueta para mantener consistencia visual.
     */
    private function seedTechnicalTeam($now): void
    {
        $defaultPhoto = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIj48cmVjdCB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgcng9IjgiIGZpbGw9IiNlOGVhZWQiLz48cGF0aCBkPSJNMTcwIDEzMCBsMzAgNDAgbDIwLTE1IGw0MCA1NSBIMTQweiIgZmlsbD0iI2JkYzFjNiIvPjxjaXJjbGUgY3g9IjI1MCIgY3k9IjEyMCIgcj0iMTgiIGZpbGw9IiNiZGMxYzYiLz48L3N2Zz4=';

        $members = [
            ['Juan Mendoza', 'Coordinador de Base', 'Ingeniero Civil con amplia experiencia en organización comunitaria y desarrollo local.', $defaultPhoto],
            ['Luis Tinoco', 'Coordinador de Sedes', 'Ingeniero Agrónomo especializado en gestión de infraestructura y logística rural.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuAHgCrUmOWo1qfHSy-4zCo8rrxJJ2gqaBgvhjL7gu7mXQC1KWeB1jzNL2y71GBLv7EZiBrRuiZPGvd3blZdbETxYYX5bPLge0jSmeV3D5FlpQWi2-WzzXY7KoF9quubDDuslH6jvLudjCLCtN0IwUyacYqfrv3a5lazTPgXBo5RiNuqtcqD4bml0O0jcNCfASQd5vomUxOhopC5h109eY_wh3aWwEdORh7kfxaVov0Uw-r-A87pcNfk59koiaUAU7G3vpeuwbAlTg'],
            ['Ana Valdivia', 'Coordinadora de Plan de Gobierno', 'Gestora Pública experta en diseño de políticas municipales y transparencia.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDalZJjYC4JTdjtcRqYppi5BJgRSI1Q7DXMDrKyyXCsT7pG9P9nBSKLHYXyZfotQ4P_tPVQCisd16HRyv3IKYdj2EPsmahspsZMa-XWuYUTAAwSQNZeDKtwMfTpNk4K6zte9N1fYxysIPuxeamQuJyWI80WIetSGroSDnzyyk7D88kNN-rNwKpdMam8dwFwK8NJwmIH9v8MufFbDxC0FDn2f3Y5oa7cz1K_H_UPJoNOpqPEuNSBQcExvvzBhEdBeAZ9UrR_dwh_FA'],
        ];

        foreach ($members as $index => [$name, $role, $bio, $photo]) {
            DB::table('technical_team_members')->updateOrInsert(
                ['name' => $name],
                [
                    'role' => $role,
                    'bio' => $bio,
                    'photo_path' => $photo,
                    'photo_alt' => $name,
                    'sort_order' => ($index + 1) * 10,
                    'active' => true,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }

    /**
     * Carga las fotos de "En el distrito" y el tipo de layout de cada imagen.
     */
    private function seedDistrictGallery($now): void
    {
        $images = [
            ['Jornada de diálogo en Olleros', 'Imágenes de nuestras jornadas de diálogo y trabajo en las diversas comunidades de Olleros.', 'featured', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBhvx8BI88fuvxfyTbMgUUSUR4wJamKwLJIdAiGNlbvFgQNVNgFx4IWct-_JHKMzBRd0gvRz-SP7DvIRDrWzfJ6ffIRN_QOhSNtPqR6VTcRaAK2Ct8tLZIC7wrZI3sTKMye9aXUnUOK1cjqBbZKX6y7VzniWdHB4YV9Wj6Y5abhJcEvsiOcTpQ76fv53DA_LnB-ZDgyZfzKGenHBpTcEl5OVkiC-StI0MUpipWDE26Ka7jYVZXJDOfvfcu-fKvi9khSzKJxU1o1rQ'],
            ['Saludo con vecinos de Olleros', 'Encuentros vecinales para escuchar necesidades y propuestas.', 'small', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDalZJjYC4JTdjtcRqYppi5BJgRSI1Q7DXMDrKyyXCsT7pG9P9nBSKLHYXyZfotQ4P_tPVQCisd16HRyv3IKYdj2EPsmahspsZMa-XWuYUTAAwSQNZeDKtwMfTpNk4K6zte9N1fYxysIPuxeamQuJyWI80WIetSGroSDnzyyk7D88kNN-rNwKpdMam8dwFwK8NJwmIH9v8MufFbDxC0FDn2f3Y5oa7cz1K_H_UPJoNOpqPEuNSBQcExvvzBhEdBeAZ9UrR_dwh_FA'],
            ['Taller con jóvenes de Olleros', 'Espacios de conversación para construir oportunidades con jóvenes.', 'small', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDhQg7J9iBM4WwQftWaJD1P3QMCkgRfmPdRVvtxIj662OPzrbRLkKz58w6v6c9ILIs8SPKBEbq8K4xWH8VwLNhBygcsG649lCWOjgJ1gi5GxfBoaIyulSE5D1Eb1b71zszNHA1rhbc1TAK3LvydQYyHVuJPVPPtWEi9wfxRnqGnQeYohkTMM8py4J7i6SoBEZJNcz8igg5s7QQhKpmjnKwUY7p-1-xOnqijd_kh9FnLDftxkorbmklX07hDUAylJ0c9sD5i6dl33A'],
            ['Campo agrícola de Olleros', 'Trabajo en campo, agricultura y diálogo con las comunidades.', 'wide', 'https://lh3.googleusercontent.com/aida-public/AB6AXuAHgCrUmOWo1qfHSy-4zCo8rrxJJ2gqaBgvhjL7gu7mXQC1KWeB1jzNL2y71GBLv7EZiBrRuiZPGvd3blZdbETxYYX5bPLge0jSmeV3D5FlpQWi2-WzzXY7KoF9quubDDuslH6jvLudjCLCtN0IwUyacYqfrv3a5lazTPgXBo5RiNuqtcqD4bml0O0jcNCfASQd5vomUxOhopC5h109eY_wh3aWwEdORh7kfxaVov0Uw-r-A87pcNfk59koiaUAU7G3vpeuwbAlTg'],
        ];

        foreach ($images as $index => [$title, $description, $layout, $photo]) {
            DB::table('district_gallery_images')->updateOrInsert(
                ['title' => $title],
                [
                    'description' => $description,
                    'image_path' => $photo,
                    'image_alt' => $title,
                    'layout' => $layout,
                    'sort_order' => ($index + 1) * 10,
                    'active' => true,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }

    /**
     * Carga ejemplos iniciales para la tabla pública de transparencia de aportes.
     */
    private function seedTransparency($now): void
    {
        $contributions = [
            ['Asociación de Productores', 'Materiales', '1000 volantes', null, '2026-10-15'],
            ['Comité Vecinal Barrio Centro', 'Organización', 'Sede para reunión', null, '2026-10-12'],
            ['Aporte voluntario individual', 'Económico', 'S/ 500.00', 500.00, '2026-10-10'],
        ];

        foreach ($contributions as [$contributor, $type, $detail, $amount, $date]) {
            DB::table('transparency_contributions')->updateOrInsert(
                [
                    'contributor_name' => $contributor,
                    'contribution_date' => $date,
                ],
                [
                    'contribution_type' => $type,
                    'detail' => $detail,
                    'amount' => $amount,
                    'currency' => 'PEN',
                    'active' => true,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }

    /**
     * Carga los datos visibles de sede, correo y teléfono de contacto.
     */
    private function seedContact($now): void
    {
        DB::table('contact_settings')->updateOrInsert(
            ['venue_name' => 'Sede Central Olleros'],
            [
                'address' => 'Jr. Libertad 123, Plaza de Armas de Olleros, Ancash',
                'email' => 'contacto@mirkocacha.pe',
                'phone' => '+51 987 654 321',
                'whatsapp' => '+51987654321',
                'map_url' => null,
                'office_hours' => null,
                'social_links' => json_encode([], JSON_UNESCAPED_UNICODE),
                'active' => true,
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );
    }

    /**
     * Carga preguntas base del chatbot para dejar mapeado el contenido en BD.
     *
     * La interfaz actual todavía responde desde JavaScript, pero esta tabla queda lista
     * para migrar el chatbot a datos dinámicos cuando armemos el controlador.
     */
    private function seedChatbotFaqs($now): void
    {
        $faqs = [
            ['¿Cuáles son las propuestas principales?', 'El plan se ordena en cuatro frentes: desarrollo social, economía local, ambiente y gestión municipal. En simple: mejor educación y salud, agua y saneamiento, apoyo real al productor, turismo, seguridad, limpieza pública y una municipalidad más transparente.', ['propuesta', 'propuestas', 'plan', 'gobierno', 'principal']],
            ['¿Qué harán por la educación?', 'Se propone reforzar aprendizajes, capacitar docentes, impulsar una academia de preparación en convenio con la UNASAM, crear una biblioteca municipal con internet, promover educación técnica con CETPRO y abrir oportunidades para jóvenes y adultos mediante CEBA.', ['educacion', 'educación', 'colegio', 'escuela', 'biblioteca', 'ceba', 'cetpro', 'unasam']],
            ['¿Qué plantea el plan en salud?', 'La prioridad es atender mejor y prevenir. El plan incluye ampliar y equipar el Centro de Salud de Huaripampa, hacer campañas integrales en todo el distrito, reducir anemia y desnutrición infantil, atender a adultos mayores y gestionar especialistas con atención virtual y presencial mediante Jampiwayi.', ['salud', 'posta', 'medico', 'médico', 'anemia', 'desnutricion', 'desnutrición', 'adulto mayor', 'jampiwayi']],
            ['¿Qué se propone para agua y saneamiento?', 'El plan plantea mejorar el monitoreo del agua potable con las JASS, asegurar cloración y mantenimiento, y construir el sistema de agua potable y desagüe del Centro Poblado de Huaripampa, incluyendo planta de tratamiento e instalación para caseríos que aún faltan.', ['agua', 'saneamiento', 'desague', 'desagüe', 'jass', 'cloracion', 'cloración', 'huaripampa']],
            ['¿Cómo apoyarían a la chacra y a los productores?', 'La propuesta es pasar del discurso al agua y asistencia en campo: riego tecnificado, canales y reservorios, capacitación, producción de semillas y almácigos, abono orgánico y proyectos de hortalizas y frutales en caseríos como Ututupampa, Lloclla, Pacchapampa, Mashuan, Aco y otros.', ['agricultura', 'chacra', 'productor', 'productores', 'riego', 'canal', 'reservorio', 'semilla', 'hortalizas', 'frutales']],
            ['¿Cómo puedo sumarme?', 'Puedes dejar tus datos en la sección Súmate. La idea es que vecinos, jóvenes, productores y profesionales puedan aportar como voluntarios, proponer proyectos o mantenerse informados.', ['sumar', 'sumarme', 'voluntario', 'contacto', 'ayudar', 'apoyar']],
        ];

        foreach ($faqs as $index => [$question, $answer, $keywords]) {
            DB::table('chatbot_faqs')->updateOrInsert(
                ['question' => $question],
                [
                    'answer' => $answer,
                    'keywords' => json_encode($keywords, JSON_UNESCAPED_UNICODE),
                    'sort_order' => ($index + 1) * 10,
                    'active' => true,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }
}
