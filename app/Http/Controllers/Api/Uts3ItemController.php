<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Uts3item; // Use Uts3item model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Import Validator
use Illuminate\Support\Facades\DB; // Import DB facade jika perlu query kompleks

class Uts3ItemController extends Controller
{
    // READ ALL: GET /api/uts3items
    public function index()
    {
        // Eager load relasi untuk efisiensi (opsional)
        $uts3items = Uts3item::with(['category', 'supplier', 'createdBy'])->paginate(15); // Contoh paginasi, relasi disesuaikan
        return response()->json($uts3items);
    }

    // CREATE: POST /api/uts3items
    public function store(Request $request)
    {
        // --- Asumsi: Admin ID didapat dari request atau Auth ---
        // Ganti '1' dengan ID admin yang sebenarnya, misal: $request->user()->id
        $adminId = $request->input('created_by', 1); // Ambil dari request, default 1 jika tdk ada, sesuaikan nama input

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:uts3categories,id', // Pastikan uts3category ada
            'supplier_id' => 'required|exists:uts3suppliers,id', // Pastikan uts3supplier ada
            'created_by' => 'nullable|exists:uts3admins,id' // Validasi jika created_by dari input
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Unprocessable Entity
        }

        $validatedData = $validator->validated();
        $validatedData['created_by'] = $adminId; // Tambahkan created_by

        try {
            $uts3item = Uts3item::create($validatedData);
            // Load relasi setelah dibuat (opsional)
            $uts3item->load(['category', 'supplier', 'createdBy']);
            return response()->json($uts3item, 201); // 201 Created
        } catch (\Exception $e) {
            // Tangani error database, dll.
            return response()->json(['message' => 'Gagal menyimpan item', 'error' => $e->getMessage()], 500);
        }
    }

    // READ ONE: GET /api/uts3items/{uts3item}
    public function show(Uts3item $uts3item) // Route Model Binding dengan Uts3item
    {
        // Eager load relasi
        $uts3item->load(['category', 'supplier', 'createdBy']);
        return response()->json($uts3item);
    }

    // Metode update dan destroy tidak diminta, tapi bisa ditambahkan
    // public function update(Request $request, Uts3item $uts3item) { ... }
    // public function destroy(Uts3item $uts3item) { ... }

    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
