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

class IncomingLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return view('pages.transaction.incoming.index', [
            'data' => Letter::with('dispositions')->where('type', LetterType::INCOMING->type())->get(),
            'search' => $request->search,
        ]);
    }

    /**
     * Display a listing of the incoming letter agenda.
     *
     * @param Request $request
     * @return View
     */
    public function agenda()
    {
        $letters = Letter::where('type', LetterType::INCOMING->type())->get();
        return view('transaction.incoming.agenda', compact('letters'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('pages.transaction.incoming.create', [
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
                'from'                 => 'nullable|string',
                // 'to'                   => 'nullable|string',
                'letter_date'          => 'nullable|date',
                'received_date'        => 'nullable|date',
                'description'          => 'nullable|string',
                'note'                 => 'nullable|string',
                'type'                 => 'required|string|in:incoming,outgoing',
                'classification_code'  => 'required|exists:classifications,code',
                'attachments.*'        => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:2048',
            ]);

            // dd($validated);

            // Pastikan tipe surat sesuai
            if ($validated['type'] != LetterType::INCOMING->type()) {
                throw new \Exception('Incoming letter');
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
                ->route('transaction.incoming.index')
                ->with('success', ('Surat Berhasil Dibuat'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }


    public function show($id)
    {
        $incoming = Letter::findOrFail($id);

        return view('pages.transaction.incoming.show', [
            'data' => $incoming->load(['classification', 'user', 'attachments']),
        ]);
    }

    public function edit($id): View
    {
        $incoming = Letter::findOrFail($id);

        return view('pages.transaction.incoming.edit', [
            'data' => $incoming,
            'classifications' => Classification::all(),
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $incoming = Letter::findOrFail($id);

            // Validasi langsung di controller
            $validated = $request->validate([
                'reference_number'     => 'required|string|unique:letters,reference_number,' . $incoming->id,
                'agenda_number'        => 'required|string',
                'from'                 => 'nullable|string',
                // 'to'                   => 'nullable|string',
                'letter_date'          => 'nullable|date',
                'received_date'        => 'nullable|date',
                'description'          => 'nullable|string',
                'note'                 => 'nullable|string',
                'type'                 => 'required|string|in:incoming,outgoing',
                'classification_code'  => 'required|exists:classifications,code',
                'attachments.*'        => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:2048',
            ]);

            // Update data surat
            $incoming->update($validated);

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
                        'letter_id' => $incoming->id,
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
            $incoming = Letter::findOrFail($id);

            $incoming->delete();
            return redirect()
                ->route('transaction.incoming.index')
                ->with('success', ('Surat Berhasil Dihapus'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
