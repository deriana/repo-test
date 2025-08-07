<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClassificationController extends Controller
{
    public function index(Request $request): View
    {
        return view('pages.reference.classification', [
            'data' => Classification::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        try {
            Classification::create($request->only(['code', 'type', 'description']));
            return back()->with('success', 'Klasifikasi berhasil ditambahkan.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        try {
            $classification = Classification::findOrFail($id);
            $classification->update($request->only(['code', 'type', 'description']));

            return back()->with('success', 'Klasifikasi berhasil diperbarui.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $classification = Classification::findOrFail($id);
            $classification->delete();

            return back()->with('success', 'Klasifikasi berhasil dihapus.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
