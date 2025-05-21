<?php

namespace App\Http\Controllers;

use App\Models\Finemaster;
use Illuminate\Http\Request;

class FineMasterController extends Controller
{
    public function getFineSettings()
    {
        $fine = Finemaster::where('status', 'active')->first();
        
        if (!$fine) {
            $fine = FineMaster::create([
                'fine_amount' => 5000,
                'grace_period' => 7,
                'status' => 'active'
            ]);
        }
        
        return response()->json($fine);
    }

    public function updateFineSettings(Request $request)
    {
        $request->validate([
            'fine_amount' => 'required|numeric|min:0',
            'grace_period' => 'required|integer|min:1'
        ]);

        // Deactivate all current settings
        Finemaster::where('status', 'active')->update(['status' => 'inactive']);
        
        // Create new active setting
        $fine = Finemaster::create([
            'fine_amount' => $request->fine_amount,
            'grace_period' => $request->grace_period,
            'status' => 'active'
        ]);

        return response()->json([
            'message' => 'Pengaturan denda berhasil diperbarui',
            'data' => $fine
        ]);
    }
}