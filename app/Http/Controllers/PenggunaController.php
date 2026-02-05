<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
        public function edit($id)
        {
            $pengguna = Pengguna::findOrFail($id);
            // Ambil daftar divisi seperti di Dashboard
            $divisiMasuk = DB::table('surat_masuk')
                ->select('penerima_divisi as divisi')
                ->distinct();
            $divisiKeluar = DB::table('surat_keluar')
                ->select('pengirim_divisi as divisi')
                ->distinct();
            $divisi = $divisiMasuk
                ->union($divisiKeluar)
                ->orderBy('divisi')
                ->pluck('divisi');
            return view('manajemen-pengguna.edit-user', compact('pengguna', 'divisi'));
        }

        public function update(Request $request, $id)
        {
            $pengguna = Pengguna::findOrFail($id);
            $request->validate([
                'name'   => 'required|string|max:100',
                'email'  => 'required|email|unique:pengguna,email,' . $pengguna->id,
                'role'   => 'required|in:Admin,Pimpinan,Staff',
                'divisi' => 'required|string|max:100',
                'password' => 'nullable|string|min:8',
            ]);

            $pengguna->name = $request->name;
            $pengguna->email = $request->email;
            $pengguna->role = $request->role;
            $pengguna->divisi = $request->divisi;
            if ($request->filled('password')) {
                $pengguna->password = Hash::make($request->password);
            }
            $pengguna->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data pengguna berhasil diperbarui!',
                    'data'    => $pengguna,
                ]);
            }
            // Tambahkan parameter updated=1 agar toast update muncul, bukan tambah
            return redirect()->route('pengguna.index', ['updated' => 1]);
        }
    public function index()
    {
        // Ambil daftar divisi seperti di Dashboard
        $divisiMasuk = DB::table('surat_masuk')
            ->select('penerima_divisi as divisi')
            ->distinct();

        $divisiKeluar = DB::table('surat_keluar')
            ->select('pengirim_divisi as divisi')
            ->distinct();

        $divisi = $divisiMasuk
            ->union($divisiKeluar)
            ->orderBy('divisi')
            ->pluck('divisi');

        // Ambil data pengguna, urutkan berdasarkan ID (terbaru) dan paginasi
        $pengguna = Pengguna::orderBy('id', 'asc')->paginate(10);

        return view('manajemen-pengguna.index', compact('pengguna', 'divisi'));
    }

    public function create()
    {
        return view('manajemen-pengguna.add-user');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:pengguna,email',
            'role'     => 'required|in:Admin,Pimpinan,Staff',
            'divisi'   => 'required|string|max:100',
            'password' => 'required|string|min:8',
        ]);

        $pengguna = Pengguna::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'divisi'   => $request->divisi,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengguna baru berhasil ditambahkan!',
                'data'    => $pengguna,
            ]);
        }

        // fallback untuk request biasa
        return redirect('/manajemen-pengguna')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    public function destroy($id, Request $request)
    {
        $user = Pengguna::findOrFail($id);
        $user->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengguna berhasil dihapus!'
            ]);
        }
        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}
