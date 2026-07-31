<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Estructura inicial del sitio de campaña.
     *
     * Esta migración separa el contenido editable por bloques de la landing.
     * La regla base es simple: cada sección pública puede activarse/desactivarse,
     * ordenarse y editarse luego desde un panel administrativo sin tocar Blade.
     */
    public function up(): void
    {
        // Control maestro de secciones: permite mostrar/ocultar bloques completos
        // como Regidores, Equipo Técnico, En el distrito, Transparencia o Chatbot.
        Schema::create('site_sections', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_visible')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->json('settings')->nullable();
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // Portada principal de la landing: etiqueta, titular, botones y foto del candidato.
        // Se deja image_path como text porque las URLs generadas por la maqueta son largas.
        Schema::create('landing_hero_contents', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->nullable();
            $table->string('title');
            $table->string('highlighted_title')->nullable();
            $table->text('description')->nullable();
            $table->string('primary_button_label')->nullable();
            $table->text('primary_button_url')->nullable();
            $table->string('secondary_button_label')->nullable();
            $table->text('secondary_button_url')->nullable();
            $table->text('image_path')->nullable();
            $table->string('image_alt')->nullable();
            $table->unsignedSmallInteger('campaign_year')->default(2026);
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // Bloque "Quién es": biografía corta, foto de contexto y bullets de experiencia.
        // facts queda en JSON para guardar una lista flexible sin crear otra tabla.
        Schema::create('candidate_biographies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('summary')->nullable();
            $table->text('image_path')->nullable();
            $table->string('image_alt')->nullable();
            $table->json('facts')->nullable();
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // Propuestas del plan de gobierno: tarjetas públicas editables con icono,
        // categoría, resumen y descripción extendida para futuras vistas de detalle.
        Schema::create('government_proposals', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('title');
            $table->string('category')->nullable()->index();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->text('image_path')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('cta_label')->nullable();
            $table->text('cta_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // Regidores: equipo municipal mostrado en la landing con orden, cargo, bio y foto.
        // active + softDeletes permiten ocultar o retirar sin perder historial.
        Schema::create('council_members', function (Blueprint $table) {
            $table->id();
            $table->string('position')->nullable();
            $table->string('name');
            $table->text('bio')->nullable();
            $table->text('photo_path')->nullable();
            $table->string('photo_alt')->nullable();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // Equipo técnico: misma intención visual que regidores, separado para administrar
        // responsabilidades técnicas sin mezclarlo con cargos políticos.
        Schema::create('technical_team_members', function (Blueprint $table) {
            $table->id();
            $table->string('role')->nullable();
            $table->string('name');
            $table->text('bio')->nullable();
            $table->text('photo_path')->nullable();
            $table->string('photo_alt')->nullable();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // Galería "En el distrito": fotos de jornadas, visitas y trabajo de campo.
        // layout permite reconstruir la grilla de la maqueta: featured, small o wide.
        Schema::create('district_gallery_images', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('image_path');
            $table->string('image_alt')->nullable();
            $table->string('layout', 30)->default('small')->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // Formularios de "Únete al cambio": contactos ciudadanos, voluntarios e ideas.
        // status separa lo nuevo, atendido o archivado sin borrar el registro.
        Schema::create('supporter_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('support_type')->nullable()->index();
            $table->text('message')->nullable();
            $table->string('status', 30)->default('new')->index();
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // Transparencia de aportes: registro público de aportantes, tipo, detalle y monto.
        // amount es nullable porque algunos aportes son materiales u organización.
        Schema::create('transparency_contributions', function (Blueprint $table) {
            $table->id();
            $table->string('contributor_name');
            $table->string('contribution_type')->nullable()->index();
            $table->text('detail')->nullable();
            $table->decimal('amount', 12, 2)->nullable();
            $table->string('currency', 3)->default('PEN');
            $table->date('contribution_date')->nullable()->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // Datos de contacto visibles: sede, correo, teléfono, WhatsApp, mapa y redes.
        // Se conserva como tabla para permitir cambiar la sede sin redeploy.
        Schema::create('contact_settings', function (Blueprint $table) {
            $table->id();
            $table->string('venue_name')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('map_url')->nullable();
            $table->text('office_hours')->nullable();
            $table->json('social_links')->nullable();
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // Inscripciones de Copa Olleros: captura lo enviado desde el modal del menú.
        // players queda en JSON porque cada equipo puede registrar distinta cantidad.
        Schema::create('football_team_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('team_name');
            $table->string('delegate_name');
            $table->string('phone');
            $table->json('players')->nullable();
            $table->string('status', 30)->default('new')->index();
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // Base editable del chatbot: preguntas, respuestas y palabras clave de búsqueda.
        // De momento replica el contenido mapeado en JS; luego podrá consultarse desde BD.
        Schema::create('chatbot_faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->longText('answer');
            $table->json('keywords')->nullable();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * El rollback elimina en orden inverso para respetar dependencias futuras.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_faqs');
        Schema::dropIfExists('football_team_registrations');
        Schema::dropIfExists('contact_settings');
        Schema::dropIfExists('transparency_contributions');
        Schema::dropIfExists('supporter_submissions');
        Schema::dropIfExists('district_gallery_images');
        Schema::dropIfExists('technical_team_members');
        Schema::dropIfExists('council_members');
        Schema::dropIfExists('government_proposals');
        Schema::dropIfExists('candidate_biographies');
        Schema::dropIfExists('landing_hero_contents');
        Schema::dropIfExists('site_sections');
    }
};
