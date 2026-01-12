<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Notification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of pending loans for verification.
     */
    public function verifikasiIndex()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'asc')
            ->get();
            
        return view('petugas.verifikasi.index', compact('peminjamans'));
    }

    /**
     * Approve a loan request.
     */
    public function approve(Request $request, Peminjaman $peminjaman)
    {
        // Check stock
        if ($peminjaman->alat->stok < $peminjaman->jumlah) {
            return back()->with('error', 'Stok alat tidak mencukupi untuk peminjaman ini.');
        }

        // Decrement stock
        $peminjaman->alat->decrement('stok', $peminjaman->jumlah);

        $peminjaman->update(['status' => 'disetujui']);

        // Create notification for user
        Notification::create([
            'user_id' => $peminjaman->user_id,
            'peminjaman_id' => $peminjaman->id,
            'type' => 'peminjaman_disetujui',
            'title' => 'Peminjaman Disetujui',
            'message' => "Peminjaman {$peminjaman->alat->nama_alat} Anda telah disetujui. Silakan ambil alat sesuai jadwal yang ditentukan."
        ]);

        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    /**
     * Reject a loan request.
     */
    public function reject(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'reason' => 'required|string|max:255'
        ]);

        $peminjaman->update([
            'status' => 'ditolak',
            'catatan_petugas' => $request->reason
        ]);

        // Create notification for user
        Notification::create([
            'user_id' => $peminjaman->user_id,
            'peminjaman_id' => $peminjaman->id,
            'type' => 'peminjaman_ditolak',
            'title' => 'Peminjaman Ditolak',
            'message' => "Peminjaman {$peminjaman->alat->nama_alat} Anda ditolak. Alasan: {$request->reason}"
        ]);

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    /**
     * Display a listing of active loans for return processing.
     */
    public function pengembalianIndex()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->where('status', 'disetujui') // Assuming 'disetujui' means actively borrowed
            ->orderBy('tanggal_kembali', 'asc')
            ->get();

        return view('petugas.pengembalian.index', compact('peminjamans'));
    }

    /**
     * Process the return of a tool.
     */
    public function processReturn(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'denda' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string'
        ]);

        // Increment stock back
        $peminjaman->alat->increment('stok', $peminjaman->jumlah);

        $peminjaman->update([
            'status' => 'kembali',
            'tanggal_dikembalikan' => now(),
            'denda' => $request->denda ?? 0,
            'catatan_petugas' => $request->catatan
        ]);

        // Create notification for user
        $dendaMessage = $request->denda > 0 
            ? " Denda: Rp " . number_format($request->denda, 0, ',', '.') 
            : "";
            
        Notification::create([
            'user_id' => $peminjaman->user_id,
            'peminjaman_id' => $peminjaman->id,
            'type' => 'pengembalian_diproses',
            'title' => 'Pengembalian Diproses',
            'message' => "Pengembalian {$peminjaman->alat->nama_alat} telah diproses.{$dendaMessage}"
        ]);

        return back()->with('success', 'Pengembalian berhasil diproses.');
    }

    /**
     * Display a listing of personal borrowings for the user.
     */
    public function indexPeminjam()
    {
        $peminjamans = Peminjaman::with(['alat.kategori'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('peminjam.bookings', compact('peminjamans'));
    }

    public function create(Request $request)
    {
        $alat = \App\Models\Alat::findOrFail($request->alat);
        return view('peminjam.create', compact('alat'));
    }

    /**
     * Store a newly created borrowing request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'jumlah' => 'required|integer|min:1',
            'catatan' => 'nullable|string|max:500',
        ]);

        $alat = \App\Models\Alat::findOrFail($request->alat_id);

        if ($alat->stok < $request->jumlah) {
            return back()->with('error', 'Stok alat tidak mencukupi.');
        }

        // Calculate total cost
        $tanggalPinjam = \Carbon\Carbon::parse($request->tanggal_pinjam);
        $tanggalKembali = \Carbon\Carbon::parse($request->tanggal_kembali);
        $jumlahHari = $tanggalPinjam->diffInDays($tanggalKembali) + 1; // +1 to include first day
        $totalBiaya = $alat->harga_sewa_per_hari * $jumlahHari * $request->jumlah;

        Peminjaman::create([
            'user_id' => auth()->id(),
            'alat_id' => $request->alat_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'jumlah' => $request->jumlah,
            'total_biaya' => $totalBiaya,
            'catatan' => $request->catatan,
            'status' => 'menunggu',
        ]);

        return redirect()->route('peminjam.bookings')->with('success', 'Permintaan peminjaman berhasil dikirim. Menunggu verifikasi petugas.');
    }
}
