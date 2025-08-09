<?php

namespace App\Http\Controllers;

use App\Enums\LetterType;
use App\Models\Attachment;
use App\Models\Classification;
use App\Models\Config;
use App\Models\Letter;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class OutgoingLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return view('pages.transaction.outgoing.index', [
            'data' => Letter::where('type', LetterType::OUTGOING->type())->get(),
            'search' => $request->search,
        ]);
    }

    /**
     * Display a listing of the outgoing letter agenda.
     *
     * @param Request $request
     * @return View
     */
    public function agenda()
    {
        $letters = Letter::where('type', LetterType::OUTGOING->type())->get();
        return view('transaction.outgoing.agenda', compact('letters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('pages.transaction.outgoing.create', [
            'classifications' => Classification::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $user = auth()->user();

            $validated = $request->validate([
                'reference_number'     => 'required|string|unique:letters,reference_number',
                'agenda_number'        => 'required|string',
                // 'from'                 => 'nullable|string',
                'to'                   => 'nullable|string',
                'letter_date'          => 'nullable|date',
                'description'          => 'nullable|string',
                'note'                 => 'nullable|string',
                'type'                 => 'required|string|in:outgoing,outgoing',
                'classification_code'  => 'required|exists:classifications,code',
                'attachments.*'        => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:2048',
            ]);

            // dd($validated);

            // Pastikan tipe surat sesuai
            if ($validated['type'] != LetterType::OUTGOING->type()) {
                throw new \Exception('Outgoing letter');
            }

            // Tambah user_id
            $validated['user_id'] = $user->id;

            // Simpan surat
            $letter = Letter::create($validated);

            // Simpan lampiran jika ada
            if ($request->hasFile('attachments')) {
                foreach ($request->attachments as $attachment) {
                    $extension = $attachment->getClientOriginalExtension();
                    $filename = time() . '-' . str_replace(' ', '-', $attachment->getClientOriginalName());
                    $attachment->storeAs('public/attachments', $filename);

                    Attachment::create([
                        'filename'  => $filename,
                        'extension' => $extension,
                        'user_id'   => $user->id,
                        'letter_id' => $letter->id,
                    ]);
                }
            }

            return redirect()
                ->route('transaction.outgoing.index')
                ->with('success', ('Surat Berhasil Dibuat'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }


    public function show($id)
    {
        $outgoing = Letter::findOrFail($id);

        return view('pages.transaction.outgoing.show', [
            'data' => $outgoing->load(['classification', 'user', 'attachments']),
        ]);
    }

    public function edit($id): View
    {
        $outgoing = Letter::findOrFail($id);

        return view('pages.transaction.outgoing.edit', [
            'data' => $outgoing,
            'classifications' => Classification::all(),
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $outgoing = Letter::findOrFail($id);

            // Validasi langsung di controller
            $validated = $request->validate([
                'reference_number'     => 'required|string|unique:letters,reference_number,' . $outgoing->id,
                'agenda_number'        => 'required|string',
                // 'from'                 => 'nullable|string',
                'to'                   => 'nullable|string',
                'letter_date'          => 'nullable|date',
                'description'          => 'nullable|string',
                'note'                 => 'nullable|string',
                'type'                 => 'required|string|in:outgoing,outgoing',
                'classification_code'  => 'required|exists:classifications,code',
                'attachments.*'        => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:2048',
            ]);

            // Update data surat
            $outgoing->update($validated);

            // Simpan lampiran baru jika ada
            if ($request->hasFile('attachments')) {
                foreach ($request->attachments as $attachment) {
                    $extension = $attachment->getClientOriginalExtension();
                    $filename = time() . '-' . str_replace(' ', '-', $attachment->getClientOriginalName());
                    $attachment->storeAs('public/attachments', $filename);

                    Attachment::create([
                        'filename'  => $filename,
                        'extension' => $extension,
                        'user_id'   => auth()->id(),
                        'letter_id' => $outgoing->id,
                    ]);
                }
            }

            return back()->with('success', ('Surat Berhasil Diedit'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $outgoing = Letter::findOrFail($id);

            $outgoing->delete();
            return redirect()
                ->route('transaction.outgoing.index')
                ->with('success', ('Surat Berhasil Dihapus'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
