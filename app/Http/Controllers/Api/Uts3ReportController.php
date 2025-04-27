<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Uts3item; // Use Uts3item model
use App\Models\Uts3category; // Use Uts3category model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import DB

class Uts3ReportController extends Controller
{
    // 4. Ringkasan Stok: GET /api/uts3reports/stock-summary
    public function stockSummary()
    {
        $totalStock = Uts3item::sum('quantity');
        // Hitung total nilai: SUM(price * quantity)
        $totalValue = Uts3item::sum(DB::raw('price * quantity'));
        $averagePrice = Uts3item::avg('price');

        return response()->json([
            'total_stock' => (int) $totalStock, // Casting ke integer
            'total_stock_value' => (float) $totalValue, // Casting ke float
            'average_item_price' => (float) $averagePrice,
        ]);
    }

    // 5. Stok di Bawah Ambang Batas: GET /api/uts3reports/low-stock?threshold=5
    public function lowStockItems(Request $request)
    {
        // Ambil threshold dari query parameter, default 5
        $threshold = $request->query('threshold', 5);

        // Validasi threshold harus angka positif
        if (!is_numeric($threshold) || $threshold < 0) {
            return response()->json(['message' => 'Threshold harus angka positif.'], 400); // Bad Request
        }

        $lowStockItems = Uts3item::where('quantity', '<', $threshold)
            ->with(['category', 'supplier']) // Eager load relasi (nama tetap category dan supplier sesuai definisi di Uts3item)
            ->orderBy('quantity', 'asc') // Urutkan dari yg paling sedikit
            ->get();

        return response()->json($lowStockItems);
    }

    // 6. Laporan Barang Berdasarkan Kategori: GET /api/uts3reports/items-by-category/{uts3category}
    public function itemsByCategory(Uts3category $uts3category) // Gunakan Route Model Binding dengan Uts3category
    {
        // Load item yang berelasi dengan kategori ini
        // Anda bisa menambahkan paginasi jika perlu: ->paginate(15)
        $items = $uts3category->uts3items()->with(['supplier', 'createdBy'])->get(); // Gunakan relasi uts3items dan createdBy

        return response()->json([
            'category' => $uts3category->load('createdBy'), // Kirim info kategori juga, gunakan relasi createdBy
            'items' => $items,
        ]);
    }
}