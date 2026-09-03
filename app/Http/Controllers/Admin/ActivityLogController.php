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

        return view('admin.activities.index', compact('paginatedLogs', 'stats', 'roleFilter', 'actionFilter', 'search'));
    }
}
