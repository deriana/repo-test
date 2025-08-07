<?php

namespace App\Http\Controllers;

use App\Models\LetterStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LetterStatusController extends Controller
{
    public function index(Request $request): View
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Khusus admin');
        }

        return view('pages.reference.status', [
            'data' => LetterStatus::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        try {
            LetterStatus::create([
                'status' => $request->status,
            ]);

            return back()->with('success', 'Status berhasil ditambahkan.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        try {
            $status = LetterStatus::findOrFail($id);

            $status->update([
                'status' => $request->status,
            ]);

            return back()->with('success', 'Status berhasil diperbarui.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $status = LetterStatus::findOrFail($id);
            $status->delete();

            return back()->with('success', 'Status berhasil dihapus.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
