<?php

namespace App\Http\Controllers;

use App\Models\Songs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    public function songlist(int $id = 0): JsonResponse
    {
        $songs = Songs::query();

        if ($id !== 0) {
            $songs->where('position', '>', 0)->orderBy('position');
        } else {
            $songs->orderByRaw('CONVERT(numb, SIGNED) ASC');
        }

        return response()->json($songs->get());
    }

    public function songlist2(): JsonResponse
    {
        return response()->json(
            Songs::query()
                ->select('id', 'numb', 'title', 'autor', 'groups', 'video', 'position')
                ->orderBy('position')
                ->get()
        );
    }

    public function lyrics2(?int $id = null): JsonResponse
    {
        if ($id !== null && $id > 0) {
            $songs = Songs::query()->select('id', 'txt', 'autor')->findOrFail($id);
        } else {
            $songs = Songs::query()
                ->select('id', 'txt', 'autor')
                ->where('position', '<>', 0)
                ->orderBy('position')
                ->get();
        }

        return response()->json($songs);
    }

    public function songByID(int $id): JsonResponse
    {
        return response()->json(Songs::query()->findOrFail($id));
    }

    public function songUpdate(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'numb' => ['sometimes', 'nullable', 'string', 'max:255'],
            'title' => ['sometimes', 'nullable', 'string', 'max:255'],
            'autor' => ['sometimes', 'nullable', 'string'],
            'groups' => ['sometimes', 'nullable', 'string', 'max:255'],
            'video' => ['sometimes', 'nullable', 'string', 'max:255'],
            'status' => ['sometimes', 'nullable', 'string', 'max:255'],
            'position' => ['sometimes', 'nullable', 'integer'],
            'description' => ['sometimes', 'nullable', 'string'],
            'txt' => ['sometimes', 'nullable', 'string'],
        ]);

        $song = Songs::query()->findOrFail($id);
        $song->fill($validated);
        $song->save();

        if (array_key_exists('txt', $validated)) {
            Storage::disk('public')->put("lyrics/{$song->id}.txt", $validated['txt'] ?? '');
        }

        return response()->json($song->fresh());
    }

    public function songsheet(): JsonResponse
    {
        $songs = Songs::query()
            ->select('numb', 'txt', 'title', 'autor')
            ->where('position', '>', 0)
            ->orderBy('position')
            ->get();

        return response()->json($songs);
    }

    public function songschoice(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ids' => ['nullable', 'string'],
        ]);

        $ids = collect(explode(',', $validated['ids'] ?? ''))
            ->map(fn (string $id) => trim($id))
            ->filter(fn (string $id) => ctype_digit($id) && (int) $id > 0)
            ->map(fn (string $id) => (int) $id)
            ->unique()
            ->values();

        DB::transaction(function () use ($ids): void {
            Songs::query()->where('position', '>', 0)->update(['position' => 0]);

            foreach ($ids as $index => $id) {
                Songs::query()->whereKey($id)->update(['position' => $index + 1]);
            }
        });

        return response()->json(['saved' => true, 'ids' => $ids]);
    }
}
