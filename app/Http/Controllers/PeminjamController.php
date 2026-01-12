<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Notification;
use Illuminate\Http\Request;

class PeminjamController extends Controller
{
    /**
     * Display browse/search alat page
     */
    public function browse(Request $request)
    {
        $query = Alat::with('kategori');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_alat', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        // Filter by kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter by availability
        if ($request->has('available') && $request->available == '1') {
            $query->where('stok', '>', 0);
        }

        $alats = $query->orderBy('created_at', 'desc')->paginate(12);
        $kategoris = \App\Models\Kategori::all();
        
        return view('peminjam.browse', compact('alats', 'kategoris'));
    }

    /**
     * Display my bookings page
     */
    public function bookings()
    {
        $peminjamans = Peminjaman::with(['alat', 'user'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('peminjam.bookings', compact('peminjamans'));
    }

    /**
     * Display favorites page
     */
    public function favorites()
    {
        // For now, we'll show all available alats
        // Later you can implement a favorites table
        $favorites = Alat::with('kategori')
            ->where('stok', '>', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(12);
            
        return view('peminjam.favorites', compact('favorites'));
    }

    /**
     * Display notifications page
     */
    public function notifications()
    {
        // Get user's notifications
        $notifications = Notification::with(['peminjaman.alat'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('peminjam.notifications', compact('notifications'));
    }

    /**
     * Show alat detail
     */
    public function show(Alat $alat)
    {
        $alat->load('kategori');
        return view('peminjam.show', compact('alat'));
    }
}
