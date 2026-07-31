<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CampaignDashboardController extends Controller
{
    public function index(): View
    {
        $sections = DB::table('site_sections')
            ->whereNull('deleted_at')
            ->where('active', true)
            ->orderBy('sort_order')
            ->get();

        $proposals = DB::table('government_proposals')
            ->whereNull('deleted_at')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $councilMembers = DB::table('council_members')
            ->whereNull('deleted_at')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $districtImages = DB::table('district_gallery_images')
            ->whereNull('deleted_at')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $contributions = DB::table('transparency_contributions')
            ->whereNull('deleted_at')
            ->orderByDesc('contribution_date')
            ->orderByDesc('id')
            ->get();

        $stats = [
            'visible_sections' => $sections->where('is_visible', true)->count(),
            'supporters' => DB::table('supporter_submissions')->whereNull('deleted_at')->where('active', true)->count(),
            'contributions' => DB::table('transparency_contributions')->whereNull('deleted_at')->where('active', true)->sum('amount'),
            'football_teams' => DB::table('football_team_registrations')->whereNull('deleted_at')->where('active', true)->count(),
        ];

        return view('dashboard', compact('sections', 'proposals', 'councilMembers', 'districtImages', 'contributions', 'stats'));
    }

    public function updateVisibility(Request $request): RedirectResponse|JsonResponse
    {
        $visibleKeys = collect($request->input('sections', []))
            ->filter()
            ->values()
            ->all();

        DB::transaction(function () use ($visibleKeys) {
            DB::table('site_sections')
                ->whereNull('deleted_at')
                ->update([
                    'is_visible' => false,
                    'updated_at' => now(),
                ]);

            if ($visibleKeys !== []) {
                DB::table('site_sections')
                    ->whereIn('key', $visibleKeys)
                    ->whereNull('deleted_at')
                    ->update([
                        'is_visible' => true,
                        'updated_at' => now(),
                    ]);
            }
        });

        $message = 'Visibilidad actualizada correctamente.';

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'visible_sections' => DB::table('site_sections')
                    ->whereNull('deleted_at')
                    ->where('active', true)
                    ->where('is_visible', true)
                    ->count(),
            ]);
        }

        return back()->with('status', $message);
    }

    public function storeProposal(Request $request): RedirectResponse|JsonResponse
    {
        $nextOrder = ((int) DB::table('government_proposals')
            ->whereNull('deleted_at')
            ->max('sort_order')) + 10;

        $id = DB::table('government_proposals')->insertGetId([
            'icon' => 'flag',
            'title' => 'Nueva propuesta',
            'category' => 'General',
            'summary' => 'Describe aquí la propuesta para mostrarla en la landing.',
            'description' => 'Describe aquí la propuesta para mostrarla en la landing.',
            'image_path' => null,
            'image_alt' => 'Nueva propuesta',
            'sort_order' => $nextOrder,
            'is_featured' => false,
            'active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($request->expectsJson()) {
            $proposal = DB::table('government_proposals')->find($id);

            return $this->jsonFragment('Nueva propuesta creada.', 'dashboard.partials.proposal', compact('proposal'));
        }

        return back()->with('status', 'Nueva propuesta creada.');
    }

    public function updateProposal(Request $request, int $proposal): RedirectResponse|JsonResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'image_path' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        DB::table('government_proposals')
            ->where('id', $proposal)
            ->whereNull('deleted_at')
            ->update([
                'title' => $data['title'],
                'category' => $data['category'] ?? null,
                'summary' => $data['summary'] ?? null,
                'description' => $data['summary'] ?? null,
                'icon' => $data['icon'] ?: 'flag',
                'image_path' => $data['image_path'] ?? null,
                'image_alt' => $data['title'],
                'sort_order' => $data['sort_order'] ?? 0,
                'active' => $request->boolean('active'),
                'is_featured' => $request->boolean('is_featured'),
                'updated_at' => now(),
            ]);

        if ($request->expectsJson()) {
            $proposal = DB::table('government_proposals')->find($proposal);

            return $this->jsonFragment('Propuesta guardada correctamente.', 'dashboard.partials.proposal', compact('proposal'));
        }

        return back()->with('status', 'Propuesta guardada.');
    }

    public function destroyProposal(Request $request, int $proposal): RedirectResponse|JsonResponse
    {
        DB::table('government_proposals')
            ->where('id', $proposal)
            ->whereNull('deleted_at')
            ->update([
                'active' => false,
                'deleted_at' => now(),
                'updated_at' => now(),
            ]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Propuesta retirada de la landing.']);
        }

        return back()->with('status', 'Propuesta retirada de la landing.');
    }

    public function storeCouncilMember(Request $request): JsonResponse
    {
        $data = $this->validateCouncilMember($request);
        $data['photo_path'] = $this->storeUploadedImage($request, 'photo', 'regidores') ?: $this->defaultImagePlaceholder();
        $data['photo_alt'] = $data['name'];
        $data['sort_order'] = $data['sort_order'] ?? $this->nextSortOrder('council_members');
        $data['active'] = $request->boolean('active', true);
        $data['created_at'] = now();
        $data['updated_at'] = now();

        $id = DB::table('council_members')->insertGetId($data);
        $member = DB::table('council_members')->find($id);

        return $this->jsonFragment('Regidor agregado correctamente.', 'dashboard.partials.council-member', compact('member'));
    }

    public function updateCouncilMember(Request $request, int $member): JsonResponse
    {
        $current = DB::table('council_members')->where('id', $member)->whereNull('deleted_at')->first();
        abort_if(! $current, 404);

        $data = $this->validateCouncilMember($request);
        $data['photo_path'] = $this->storeUploadedImage($request, 'photo', 'regidores', $current->photo_path);
        $data['photo_alt'] = $data['name'];
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['active'] = $request->boolean('active');
        $data['updated_at'] = now();

        DB::table('council_members')->where('id', $member)->update($data);
        $member = DB::table('council_members')->find($member);

        return $this->jsonFragment('Regidor guardado correctamente.', 'dashboard.partials.council-member', compact('member'));
    }

    public function destroyCouncilMember(int $member): JsonResponse
    {
        DB::table('council_members')->where('id', $member)->whereNull('deleted_at')->update([
            'active' => false,
            'deleted_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Regidor retirado correctamente.']);
    }

    public function storeDistrictImage(Request $request): JsonResponse
    {
        $data = $this->validateDistrictImage($request);
        $data['image_path'] = $this->storeUploadedImage($request, 'image', 'distrito') ?: $request->input('image_path') ?: $this->defaultImagePlaceholder();
        $data['image_alt'] = $data['title'] ?: 'Imagen del distrito';
        $data['sort_order'] = $data['sort_order'] ?? $this->nextSortOrder('district_gallery_images');
        $data['active'] = $request->boolean('active', true);
        $data['created_at'] = now();
        $data['updated_at'] = now();

        $id = DB::table('district_gallery_images')->insertGetId($data);
        $image = DB::table('district_gallery_images')->find($id);

        return $this->jsonFragment('Foto del distrito agregada correctamente.', 'dashboard.partials.district-image', compact('image'));
    }

    public function updateDistrictImage(Request $request, int $image): JsonResponse
    {
        $current = DB::table('district_gallery_images')->where('id', $image)->whereNull('deleted_at')->first();
        abort_if(! $current, 404);

        $data = $this->validateDistrictImage($request);
        $data['image_path'] = $this->storeUploadedImage($request, 'image', 'distrito', $current->image_path) ?: $request->input('image_path');
        $data['image_alt'] = $data['title'] ?: 'Imagen del distrito';
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['active'] = $request->boolean('active');
        $data['updated_at'] = now();

        DB::table('district_gallery_images')->where('id', $image)->update($data);
        $image = DB::table('district_gallery_images')->find($image);

        return $this->jsonFragment('Foto del distrito guardada correctamente.', 'dashboard.partials.district-image', compact('image'));
    }

    public function destroyDistrictImage(int $image): JsonResponse
    {
        DB::table('district_gallery_images')->where('id', $image)->whereNull('deleted_at')->update([
            'active' => false,
            'deleted_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Foto retirada correctamente.']);
    }

    public function storeContribution(Request $request): JsonResponse
    {
        $data = $this->validateContribution($request);
        $data['active'] = $request->boolean('active', true);
        $data['created_at'] = now();
        $data['updated_at'] = now();

        $id = DB::table('transparency_contributions')->insertGetId($data);
        $contribution = DB::table('transparency_contributions')->find($id);

        return $this->jsonFragment('Aportante agregado correctamente.', 'dashboard.partials.contribution', compact('contribution'));
    }

    public function updateContribution(Request $request, int $contribution): JsonResponse
    {
        $data = $this->validateContribution($request);
        $data['active'] = $request->boolean('active');
        $data['updated_at'] = now();

        DB::table('transparency_contributions')
            ->where('id', $contribution)
            ->whereNull('deleted_at')
            ->update($data);

        $contribution = DB::table('transparency_contributions')->find($contribution);

        return $this->jsonFragment('Aportante guardado correctamente.', 'dashboard.partials.contribution', compact('contribution'));
    }

    public function destroyContribution(int $contribution): JsonResponse
    {
        DB::table('transparency_contributions')->where('id', $contribution)->whereNull('deleted_at')->update([
            'active' => false,
            'deleted_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Aportante retirado correctamente.']);
    }

    private function validateCouncilMember(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'photo' => ['nullable', 'image', 'max:4096'],
        ]);
    }

    private function validateDistrictImage(Request $request): array
    {
        return $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_path' => ['nullable', 'string'],
            'layout' => ['required', 'string', 'max:30'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);
    }

    private function validateContribution(Request $request): array
    {
        return $request->validate([
            'contributor_name' => ['required', 'string', 'max:255'],
            'contribution_type' => ['nullable', 'string', 'max:255'],
            'detail' => ['nullable', 'string'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'max:3'],
            'contribution_date' => ['nullable', 'date'],
        ]) + ['currency' => 'PEN'];
    }

    private function storeUploadedImage(Request $request, string $field, string $folder, ?string $currentPath = null): ?string
    {
        if (! $request->hasFile($field)) {
            return $currentPath;
        }

        $file = $request->file($field);
        $directory = public_path('uploads/campaign/' . $folder);

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            . '-' . Str::random(8)
            . '.' . $file->getClientOriginalExtension();

        $file->move($directory, $filename);

        return 'uploads/campaign/' . $folder . '/' . $filename;
    }

    private function nextSortOrder(string $table): int
    {
        return ((int) DB::table($table)->whereNull('deleted_at')->max('sort_order')) + 10;
    }

    private function defaultImagePlaceholder(): string
    {
        return 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIj48cmVjdCB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgcng9IjgiIGZpbGw9IiNlOGVhZWQiLz48cGF0aCBkPSJNMTcwIDEzMCBsMzAgNDAgbDIwLTE1IGw0MCA1NSBIMTQweiIgZmlsbD0iI2JkYzFjNiIvPjxjaXJjbGUgY3g9IjI1MCIgY3k9IjEyMCIgcj0iMTgiIGZpbGw9IiNiZGMxYzYiLz48L3N2Zz4=';
    }

    private function jsonFragment(string $message, string $view, array $data): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'html' => view($view, $data)->render(),
        ]);
    }
}
