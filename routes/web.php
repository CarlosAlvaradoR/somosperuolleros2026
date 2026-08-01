<?php

use App\Http\Controllers\CampaignDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/limpiar-cache-app', function () {
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');

    return 'Cache limpiada correctamente.';
});

Route::get('/', function () {
    $sections = DB::table('site_sections')
        ->whereNull('deleted_at')
        ->where('active', true)
        ->get()
        ->keyBy('key');

    $proposals = DB::table('government_proposals')
        ->whereNull('deleted_at')
        ->where('active', true)
        ->orderBy('sort_order')
        ->get();

    $councilMembers = DB::table('council_members')
        ->whereNull('deleted_at')
        ->where('active', true)
        ->orderBy('sort_order')
        ->get();

    $technicalTeam = DB::table('technical_team_members')
        ->whereNull('deleted_at')
        ->where('active', true)
        ->orderBy('sort_order')
        ->get();

    $districtImages = DB::table('district_gallery_images')
        ->whereNull('deleted_at')
        ->where('active', true)
        ->orderBy('sort_order')
        ->get();

    $contributions = DB::table('transparency_contributions')
        ->whereNull('deleted_at')
        ->where('active', true)
        ->orderBy('sort_order')
        ->orderByDesc('contribution_date')
        ->get();

    $heroContent = DB::table('landing_hero_contents')
        ->whereNull('deleted_at')
        ->where('active', true)
        ->orderByDesc('id')
        ->first();

    $candidateBio = DB::table('candidate_biographies')
        ->whereNull('deleted_at')
        ->where('active', true)
        ->orderByDesc('id')
        ->first();
    return view('welcome', compact(
        'sections',
        'proposals',
        'councilMembers',
        'technicalTeam',
        'districtImages',
        'contributions',
        'heroContent',
        'candidateBio'
    ));
})->name('landing');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [CampaignDashboardController::class, 'index'])->name('dashboard');
    Route::patch('/dashboard/visibility', [CampaignDashboardController::class, 'updateVisibility'])->name('dashboard.visibility.update');
    Route::post('/dashboard/portada', [CampaignDashboardController::class, 'updateHero'])->name('dashboard.hero.update');
    Route::post('/dashboard/biografia', [CampaignDashboardController::class, 'updateBiography'])->name('dashboard.biography.update');
    Route::match(['post', 'patch'], '/dashboard/reordenar/{type}', [CampaignDashboardController::class, 'reorder'])->name('dashboard.reorder');
    Route::post('/dashboard/proposals', [CampaignDashboardController::class, 'storeProposal'])->name('dashboard.proposals.store');
    Route::patch('/dashboard/proposals/{proposal}', [CampaignDashboardController::class, 'updateProposal'])->name('dashboard.proposals.update');
    Route::delete('/dashboard/proposals/{proposal}', [CampaignDashboardController::class, 'destroyProposal'])->name('dashboard.proposals.destroy');
    Route::post('/dashboard/regidores', [CampaignDashboardController::class, 'storeCouncilMember'])->name('dashboard.council.store');
    Route::patch('/dashboard/regidores/{member}', [CampaignDashboardController::class, 'updateCouncilMember'])->name('dashboard.council.update');
    Route::delete('/dashboard/regidores/{member}', [CampaignDashboardController::class, 'destroyCouncilMember'])->name('dashboard.council.destroy');
    Route::post('/dashboard/distrito', [CampaignDashboardController::class, 'storeDistrictImage'])->name('dashboard.district.store');
    Route::patch('/dashboard/distrito/{image}', [CampaignDashboardController::class, 'updateDistrictImage'])->name('dashboard.district.update');
    Route::delete('/dashboard/distrito/{image}', [CampaignDashboardController::class, 'destroyDistrictImage'])->name('dashboard.district.destroy');
    Route::post('/dashboard/aportes', [CampaignDashboardController::class, 'storeContribution'])->name('dashboard.contributions.store');
    Route::patch('/dashboard/aportes/{contribution}', [CampaignDashboardController::class, 'updateContribution'])->name('dashboard.contributions.update');
    Route::delete('/dashboard/aportes/{contribution}', [CampaignDashboardController::class, 'destroyContribution'])->name('dashboard.contributions.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
