<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Uts3supplier; // Use Uts3supplier model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Uts3SupplierController extends Controller
{
    // READ ALL: GET /api/uts3suppliers
    public function index()
    {
        $uts3suppliers = Uts3supplier::with('createdBy')->paginate(15); // Relasi disesuaikan
        return response()->json($uts3suppliers);
    }

    // CREATE: POST /api/uts3suppliers
    public function store(Request $request)
    {
        $adminId = $request->input('created_by', 1); // Asumsi admin ID, sesuaikan nama input

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'contact_info' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $validatedData['created_by'] = $adminId;

        try {
            $uts3supplier = Uts3supplier::create($validatedData);
            $uts3supplier->load('createdBy'); // Relasi disesuaikan
            return response()->json($uts3supplier, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan supplier', 'error' => $e->getMessage()], 500);
        }
    }

    // READ ONE: GET /api/uts3suppliers/{uts3supplier}
    public function show(Uts3supplier $uts3supplier) // Route Model Binding dengan Uts3supplier
    {
        $uts3supplier->load('createdBy'); // Relasi disesuaikan
        return response()->json($uts3supplier);
    }
}