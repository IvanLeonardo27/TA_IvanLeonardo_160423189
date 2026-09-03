<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ActivityLogController extends Controller
{
    /**
     * Tampilkan Halaman Monitoring Log Aktivitas Interaksi Pembelajaran
     */
    public function index(Request $request)
    {
        Gate::authorize('admin');

        $roleFilter   = $request->query('role', 'all');   // all, teacher, student, admin
        $actionFilter = $request->query('action', 'all'); // all, login, logout, classroom, post, submission, quiz, comment
        $search       = trim($request->query('search', ''));

        $query = ActivityLog::with('user');

        // Filter Peran
        if ($roleFilter !== 'all') {
            $query->where('role', $roleFilter);
        }

        // Filter Jenis Aktivitas
        if ($actionFilter !== 'all') {
            if ($actionFilter === 'grade') {
                $query->whereIn('action_type', ['grade', 'submission']);
            } else {
                $query->where('action_type', $actionFilter);
            }
        }

        // Pencarian Kata Kunci
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%")
                  ->orWhere('target', 'like', "%{$search}%");
            });
        }

        // Data terurut berdasarkan riwayat aktivitas terbaru
        $paginatedLogs = $query->latest('created_at')->paginate(15)->withQueryString();

        // Perhitungan Statistik yang Benar dan Akurat dari Database
        $stats = [
            'total_activities'   => ActivityLog::count(),
            'teacher_activities' => ActivityLog::where('role', 'teacher')->count(),
            'student_activities' => ActivityLog::where('role', 'student')->count(),
            'admin_activities'   => ActivityLog::where('role', 'admin')->count(),
        ];

        // Perhitungan Masa Retensi & Aturan Pembatasan Reset Log (Minimal 90 hari / 3 bulan)
        $firstLog = ActivityLog::oldest('created_at')->first();
        $logStartDate = $firstLog ? \Carbon\Carbon::parse($firstLog->created_at)->startOfDay() : now()->startOfDay();
        $today = now()->startOfDay();
        $daysActive = (int) $logStartDate->diffInDays($today);
        
        // Log baru bisa direset jika masa pencatatan sudah mencapai 90 hari (3 bulan)
        $canReset = $daysActive >= 90;

        // Tanggal 3 bulan + 1 hari
        $eligibleDate = (clone $logStartDate)->addMonths(3)->addDay();
        $eligibleDateFromToday = (clone $today)->addMonths(3)->addDay();
        $daysRemaining = max(0, 90 - $daysActive);

        $retention = [
            'can_reset'                => $canReset,
            'is_under_90_days'         => $daysActive < 90,
            'days_active'              => $daysActive,
            'days_remaining'           => $daysRemaining,
            'start_date'               => $logStartDate,
            'eligible_date'            => $eligibleDate,
            'eligible_date_from_today' => $eligibleDateFromToday,
            'total_logs'               => ActivityLog::count(),
            'trashed_logs'             => ActivityLog::onlyTrashed()->count(),
        ];

        return view('admin.activities.index', compact('paginatedLogs', 'stats', 'roleFilter', 'actionFilter', 'search', 'retention'));
    }

    /**
     * Reset Seluruh Log Aktivitas Menggunakan Soft Deletes jika masa retensi >= 90 hari
     */
    public function reset(Request $request)
    {
        Gate::authorize('admin');

        $firstLog = ActivityLog::oldest('created_at')->first();
        $logStartDate = $firstLog ? \Carbon\Carbon::parse($firstLog->created_at)->startOfDay() : now()->startOfDay();
        $daysActive = (int) $logStartDate->diffInDays(now()->startOfDay());
        $eligibleDate = (clone $logStartDate)->addMonths(3)->addDay();

        // Validasi perlindungan server-side: Larangan hapus jika masih di bawah 90 hari
        if ($daysActive < 90) {
            $formattedDate = $eligibleDate->translatedFormat('d F Y');
            return redirect()->route('admin.activities.index')->with('error', "Pencatatan log belum mencapai masa retensi 90 hari (baru {$daysActive} hari). Reset log baru dapat dilakukan pada tanggal {$formattedDate}.");
        }

        $totalDeleted = ActivityLog::count();
        if ($totalDeleted === 0) {
            return redirect()->route('admin.activities.index')->with('error', "Tidak ada data log aktif yang dapat direset.");
        }

        // Lakukan soft delete sehingga data tidak tampil di UI namun tetap tersimpan utuh di database
        ActivityLog::query()->delete();

        // Catat aktivitas reset oleh Super Administrator
        $user = auth()->user();
        ActivityLog::create([
            'user_id'     => $user ? $user->id : null,
            'name'        => $user ? $user->name : 'Administrator BasaKula',
            'code'        => $user ? ($user->user_code ?? 'ADM001') : 'ADM001',
            'email'       => $user ? $user->email : 'admin@sekolah.com',
            'role'        => 'admin',
            'action'      => 'Reset Log Aktivitas',
            'action_type' => 'logout',
            'target'      => 'Sistem Log BasaKula',
            'description' => "Super Administrator berhasil melakukan reset log aktivitas ({$totalDeleted} riwayat diarsipkan via soft delete).",
            'ip_address'  => $request->ip(),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->route('admin.activities.index')->with('success', "Seluruh riwayat log aktivitas ({$totalDeleted} riwayat) berhasil direset menggunakan sistem soft delete (data tetap tersimpan aman di database).");
    }

    /**
     * Pulihkan Log Aktivitas yang Diarsipkan (Soft Deletes Restore)
     */
    public function restore()
    {
        Gate::authorize('admin');

        $trashedCount = ActivityLog::onlyTrashed()->count();
        if ($trashedCount === 0) {
            return redirect()->route('admin.activities.index')->with('error', "Tidak ada data log terarsip yang perlu dipulihkan.");
        }

        ActivityLog::onlyTrashed()->restore();

        return redirect()->route('admin.activities.index')->with('success', "Sebanyak {$trashedCount} data log aktivitas berhasil dipulihkan kembali ke linimasa.");
    }
}
