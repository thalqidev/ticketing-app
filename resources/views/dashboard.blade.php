@extends('layouts.admin_layouts')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-8 max-w-5xl mx-auto border border-gray-100">
    
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-800 tracking-tight">Manajemen Kategori</h3>
        <button onclick="modal_tambah_kategori.showModal()" class="btn bg-blue-700 hover:bg-blue-800 text-white border-none rounded-lg px-4 btn-sm h-10 shadow-sm">
            Tambah Kategori
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="table w-full">
            <thead>
                <tr class="text-gray-500 border-b border-gray-200 text-sm font-semibold">
                    <th class="w-20 py-3 text-center">No</th>
                    <th class="py-3">Nama Kategori</th>
                    <th class="text-center py-3 w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @foreach($categories as $index => $kategori)
                <tr class="hover:bg-gray-50/55 transition-colors">
                    <td class="font-bold text-gray-600 py-4 text-center">{{ $index + 1 }}</td>
                    <td class="text-gray-800 font-medium py-4">{{ $kategori->nama }}</td>
                    <td class="py-4 text-center flex justify-center gap-2">
                        <button onclick="document.getElementById('modal_edit_{{ $kategori->id }}').showModal()" class="btn btn-xs bg-blue-600 hover:bg-blue-700 text-white border-none rounded px-3 py-1">
                            Edit
                        </button>
                        
                        <form action="{{ route('categories.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus kategori ini, jir?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-xs bg-red-600 hover:bg-red-700 text-white border-none rounded px-3 py-1">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>

                <dialog id="modal_edit_{{ $kategori->id }}" class="modal">
                    <div class="modal-box bg-white text-gray-800">
                        <h3 class="font-bold text-lg mb-4">Edit Kategori</h3>
                        <form action="{{ route('categories.update', $kategori->id) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nama Kategori</label>
                                <input type="text" name="nama" value="{{ old('nama', $kategori->nama) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm bg-white text-gray-800 focus:outline-blue-700">
                            </div>
                            <div class="modal-action">
                                <button type="button" onclick="document.getElementById('modal_edit_{{ $kategori->id }}').close()" class="btn btn-sm btn-ghost">Batal</button>
                                <button type="submit" class="btn btn-sm bg-blue-700 text-white border-none">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </dialog>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<dialog id="modal_tambah_kategori" class="modal">
    <div class="modal-box bg-white text-gray-800">
        <h3 class="font-bold text-lg mb-4">Tambah Kategori Baru</h3>
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nama Kategori</label>
                <input type="text" name="nama" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm bg-white text-gray-850 focus:outline-blue-700" placeholder="Contoh: Konser, Seminar">
            </div>
            <div class="modal-action">
                <button type="button" onclick="modal_tambah_kategori.close()" class="btn btn-sm btn-ghost">Batal</button>
                <button type="submit" class="btn btn-sm bg-blue-700 text-white border-none">Simpan</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
@endsection