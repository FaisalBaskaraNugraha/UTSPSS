<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Uts3category; // Use Uts3category model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Uts3CategoryController extends Controller
{
    // READ ALL: GET /api/uts3categories
    public function index()
    {
        $uts3categories = Uts3category::with('createdBy')->paginate(15); // Relasi disesuaikan
        return response()->json($uts3categories);
    }

    // CREATE: POST /api/uts3categories
    public function store(Request $request)
    {
        $adminId = $request->input('created_by', 1); // Asumsi admin ID, sesuaikan nama input

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:uts3categories,name', // Nama kategori unik
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $validatedData['created_by'] = $adminId;

        try {
            $uts3category = Uts3category::create($validatedData);
            $uts3category->load('createdBy'); // Relasi disesuaikan
            return response()->json($uts3category, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan kategori', 'error' => $e->getMessage()], 500);
        }
    }

    // READ ONE: GET /api/uts3categories/{uts3category}
    public function show(Uts3category $uts3category) // Route Model Binding dengan Uts3category
    {
        $uts3category->load('createdBy'); // Relasi disesuaikan
        return response()->json($uts3category);
    }
}