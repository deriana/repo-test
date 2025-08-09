<?php

namespace App\Http\Controllers;

use App\Models\Disposition;
use App\Models\Letter;
use App\Models\LetterStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DispositionController extends Controller
{
    // Tampilkan list disposition berdasarkan Letter
    public function index(Request $request, Letter $letter): View
    {
        $dispositions = $letter->dispositions;

        return view('pages.transaction.disposition.index', [
            'data' => $dispositions,
            'letter' => $letter
        ]);
    }

    // Form tambah disposition baru
    public function create(Letter $letter): View
    {
        return view('pages.transaction.disposition.create', [
            'letter' => $letter,
            'statuses' => LetterStatus::all(),
        ]);
    }

    // Simpan disposition baru
    public function store(Request $request, Letter $letter): RedirectResponse
    {
        try {
            $user = auth()->user();

            $newDisposition = $request->validate([
                'to'            => 'required|string',
                'due_date'      => 'required|date',
                'content'       => 'required|string',
                'note'          => 'nullable|string',
                'letter_status' => 'required|exists:letter_statuses,id',
            ]);

            $newDisposition['user_id'] = $user->id;
            $newDisposition['letter_id'] = $letter->id;

            Disposition::create($newDisposition);

            return redirect()
                ->route('transaction.disposition.index', $letter->id)
                ->with('success', ('Disposition Sukses Dibuat'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    // Form edit disposition
    public function edit(Letter $letter, Disposition $disposition): View
    {
        // Pastikan disposition itu milik letter (opsional, bisa pakai policy juga)
        if ($disposition->letter_id !== $letter->id) {
            abort(404);
        }

        return view('pages.transaction.disposition.edit', [
            'data' => $disposition,
            'letter' => $letter,
            'statuses' => LetterStatus::all(),
        ]);
    }

    // Update disposition
    public function update(Request $request, Letter $letter, Disposition $disposition): RedirectResponse
    {
        try {
            if ($disposition->letter_id !== $letter->id) {
                abort(404);
            }

            $validated = $request->validate([
                'to'            => 'required|string',
                'due_date'      => 'required|date',
                'content'       => 'required|string',
                'note'          => 'nullable|string',
                'letter_status' => 'required|exists:letter_statuses,id',
            ]);

            $disposition->update($validated);

            return back()->with('success', ('Disposition Sukses Diedit'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    // Hapus disposition
    public function destroy(Letter $letter, Disposition $disposition): RedirectResponse
    {
        try {
            if ($disposition->letter_id !== $letter->id) {
                abort(404);
            }

            $disposition->delete();

            return back()->with('success', ('Disposition Sukses Dihapus'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
