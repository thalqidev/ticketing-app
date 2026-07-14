<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori;
use App\Http\Requests\EventFormRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EventController extends Controller
{
    public function show(Event $event): View
    {
        $event->load(['kategori', 'tikets']);

        $relatedEvents = Event::where('kategori_id', $event->kategori_id)
            ->where('id', '!=', $event->id)
            ->upcoming()
            ->take(4)
            ->get();

        return view('events.show', compact('event', 'relatedEvents'));
    }

    public function index(Request $request): View
    {
        $sort = $request->get('sort', 'asc');
        $sort = in_array(strtolower($sort), ['asc', 'desc']) ? $sort : 'asc';

        $events = Event::with(['kategori', 'tikets'])
            ->when($request->filled('kategori_id'), function ($query) use ($request) {
                $query->where('kategori_id', $request->kategori_id);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('judul', 'like', '%' . $request->search . '%')
                      ->orWhere('lokasi', 'like', '%' . $request->search . '%');
                });
            })
            ->orderBy('tanggal_waktu', $sort)
            ->paginate(10)
            ->appends($request->query());

        return view('pages.admin.events.index', compact('events'));
    }

    public function create(): View
    {
        return view('pages.admin.events.create', [
            'kategoris' => Kategori::all()
        ]);
    }

    public function store(EventFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $validatedData['gambar'] = $request->hasFile('gambar')
            ? $request->file('gambar')->store('events', 'public')
            : 'konser.jpg';

        $validatedData['user_id'] = auth()->id();
        $event = Event::create($validatedData);

        foreach ($request->tikets as $tiketData) {
            $event->tikets()->create([
                'tipe'  => $tiketData['tipe'],
                'harga' => $tiketData['harga'],
                'stok'  => $tiketData['stok'],
            ]);
        }

        return redirect()->route('events.index')->with('success', 'Event dan tiket berhasil ditambahkan!');
    }

    public function edit(Event $event): View
    {
        return view('pages.admin.events.edit', [
            'event'     => $event->load('tikets'),
            'kategoris' => Kategori::all(),
            'hasSales'  => $event->hasSales()
        ]);
    }

    public function update(EventFormRequest $request, Event $event): RedirectResponse
    { 
        $validatedData = $request->validated();

        if ($event->hasSales()) {
            $waktuLama = Carbon::parse($event->tanggal_waktu)->timestamp;
            $waktuBaru = Carbon::parse($request->tanggal_waktu)->timestamp;

            if ($waktuLama !== $waktuBaru) {
                return redirect()->back()
                    ->withErrors(['tanggal_waktu' => 'Tanggal dan waktu event tidak boleh diubah karena tiket sudah ada yang terjual!'])
                    ->withInput();
            }
        }

        if ($request->hasFile('gambar')) {
            if ($event->gambar && $event->gambar !== 'konser.jpg' && Storage::disk('public')->exists($event->gambar)) {
                Storage::disk('public')->delete($event->gambar);
            }
            $validatedData['gambar'] = $request->file('gambar')->store('events', 'public');
        }

        $event->update($validatedData);
        $incomingTicketIds = [];

        foreach ($request->tikets as $tiketData) {
            if (!empty($tiketData['id'])) {
                $event->tikets()->where('id', $tiketData['id'])->update([
                    'tipe'  => $tiketData['tipe'],
                    'harga' => $tiketData['harga'],
                    'stok'  => $tiketData['stok'],
                ]);
                $incomingTicketIds[] = $tiketData['id'];
            } else {
                $newTicket = $event->tikets()->create([
                    'tipe'  => $tiketData['tipe'],
                    'harga' => $tiketData['harga'],
                    'stok'  => $tiketData['stok'],
                ]);
                $incomingTicketIds[] = $newTicket->id;
            }
        }

        if (!$event->hasSales()) {
            $event->tikets()->whereNotIn('id', $incomingTicketIds)->delete();
        }

        return redirect()->route('events.index')->with('success', 'Data event dan tiket berhasil diperbarui!');
    }

    public function destroy(Event $event): RedirectResponse
    {
        if ($event->hasSales()) {
            return redirect()->back()->with('error', 'Event tidak dapat dihapus karena tiket sudah ada yang terjual!');
        }

        if ($event->gambar && $event->gambar !== 'konser.jpg' && Storage::disk('public')->exists($event->gambar)) {
            Storage::disk('public')->delete($event->gambar);
        }

        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event beserta data tiket berhasil dihapus permanen!');
    }
}