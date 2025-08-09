<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function destroy($id): RedirectResponse
    {
        $attachment = Attachment::findOrFail($id);

        // Hapus file dari storage
        Storage::delete('public/attachments/' . $attachment->filename);

        // Hapus dari database
        $attachment->delete();

        return back()->with('success', 'Lampiran berhasil dihapus');
    }
}
