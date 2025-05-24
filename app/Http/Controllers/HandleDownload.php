<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ExportHistory;

class HandleDownload extends Controller
{
    public function downloadExport($id)
    {
        $file = ExportHistory::where('id', $id)->first();
    
        if ($file->user_id !== auth()->id() ||
        !Storage::disk('public')->exists($file->file_path)) {
        abort(404, 'File tidak ditemukan.');
    }
        return Storage::disk('public')->download($file->file_path);
    }
}
