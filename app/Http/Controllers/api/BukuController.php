<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\JsonResponse;

class BukuController extends Controller
{
    public function index(): JsonResponse
    {
        $bukus = Buku::all();
        return response()->json(['bukus' => $bukus], 200);
    }

    public function show(string $id): JsonResponse
    {
        $buku = Buku::findOrFail($id);
        return response()->json(['buku' => $buku], 200);
    }
}
