<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Category;
use App\Models\StatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    // Dashboard Admin
    public function dashboard()
    {
        $totalTickets = Ticket::count();
        $openTickets = Ticket::where('status', 'Open')->count();
        $inProgressTickets = Ticket::where('status', 'In Progress')->count();
        $resolvedTickets = Ticket::where('status', 'Resolved')->count();
        $closedTickets = Ticket::where('status', 'Closed')->count();

        $priorityStats = [
            'High' => Ticket::where('priority', 'High')->count(),
            'Medium' => Ticket::where('priority', 'Medium')->count(),
            'Low' => Ticket::where('priority', 'Low')->count(),
        ];

        $recentTickets = Ticket::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $categoryStats = Category::withCount('tickets')
            ->orderBy('tickets_count', 'desc')
            ->limit(5)
            ->get();

        $dailyStats = Ticket::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "Open" THEN 1 ELSE 0 END) as open'),
            DB::raw('SUM(CASE WHEN status = "Resolved" THEN 1 ELSE 0 END) as resolved')
        )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();

        return view('admin.dashboard', compact(
            'totalTickets',
            'openTickets',
            'inProgressTickets',
            'resolvedTickets',
            'closedTickets',
            'priorityStats',
            'recentTickets',
            'categoryStats',
            'dailyStats',
            'totalUsers',
            'activeUsers'
        ));
    }

    // Menampilkan semua tiket
    public function tickets(Request $request)
    {
        $query = Ticket::with(['user', 'category']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        if ($request->has('priority') && $request->priority != '') {
            $query->where('priority', $request->priority);
        }
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'LIKE', "%{$search}%")
                    ->orWhere('title', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($user) use ($search) {
                        $user->where('full_name', 'LIKE', "%{$search}%");
                    });
            });
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = Category::all();
        $statuses = ['Open', 'In Progress', 'Resolved', 'Closed'];
        $priorities = ['Low', 'Medium', 'High'];

        return view('admin.tickets', compact('tickets', 'categories', 'statuses', 'priorities'));
    }

    // Detail tiket
    public function ticketDetail($id)
    {
        $ticket = Ticket::with(['user', 'category', 'responses.user', 'statusLogs.changer'])
            ->findOrFail($id);
        return view('admin.ticket-detail', compact('ticket'));
    }

    // Form edit tiket
    public function editTicket($id)
    {
        $ticket = Ticket::with(['user', 'category'])->findOrFail($id);
        $categories = Category::all();
        $statuses = ['Open', 'In Progress', 'Resolved', 'Closed'];
        $priorities = ['Low', 'Medium', 'High'];

        return view('admin.edit-ticket', compact('ticket', 'categories', 'statuses', 'priorities'));
    }

    // Update tiket
    public function updateTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $request->validate([
            'title' => 'required|min:5|max:200',
            'description' => 'required|min:10',
            'category_id' => 'required|exists:categories,id',
            'priority' => 'required|in:Low,Medium,High',
            'status' => 'required|in:Open,In Progress,Resolved,Closed'
        ]);

        $oldStatus = $ticket->status;

        $ticket->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'priority' => $request->priority,
            'status' => $request->status
        ]);

        if ($request->status == 'Resolved' && $oldStatus != 'Resolved') {
            $ticket->completed_at = now();
            $ticket->save();
        }

        if ($request->status != 'Resolved' && $oldStatus == 'Resolved') {
            $ticket->completed_at = null;
            $ticket->save();
        }

        StatusLog::create([
            'ticket_id' => $ticket->id,
            'old_status' => $oldStatus,
            'new_status' => $request->status,
            'changed_by' => Auth::id()
        ]);

        return redirect()->route('admin.tickets')->with('success', 'Tiket berhasil diperbarui.');
    }

    // Delete tiket
    public function deleteTicket($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticketNumber = $ticket->ticket_number;
        $ticket->delete();

        return redirect()->route('admin.tickets')->with('success', 'Tiket ' . $ticketNumber . ' berhasil dihapus.');
    }

    // Update status tiket
    public function updateTicketStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Open,In Progress,Resolved,Closed'
        ]);

        $ticket = Ticket::findOrFail($id);
        $oldStatus = $ticket->status;
        $ticket->status = $request->status;

        if ($request->status == 'Resolved' && $oldStatus != 'Resolved') {
            $ticket->completed_at = now();
        }
        if ($oldStatus == 'Resolved' && $request->status != 'Resolved') {
            $ticket->completed_at = null;
        }

        $ticket->save();

        StatusLog::create([
            'ticket_id' => $ticket->id,
            'old_status' => $oldStatus,
            'new_status' => $request->status,
            'changed_by' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Status tiket berhasil diperbarui.');
    }

    // Tambah respon ke tiket
    public function addResponse(Request $request, $id)
    {
        $request->validate([
            'response' => 'required|string|min:3'
        ]);

        $ticket = Ticket::findOrFail($id);

        $ticket->responses()->create([
            'user_id' => Auth::id(),
            'response' => $request->response,
            'is_admin_response' => true
        ]);

        return redirect()->back()->with('success', 'Respon berhasil ditambahkan.');
    }

    // Manajemen User
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        return view('admin.create-user');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users|alpha_dash|min:3|max:50',
            'email' => 'required|email|unique:users',
            'full_name' => 'required|min:3|max:150',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,user',
            'department' => 'nullable|max:100',
            'phone' => 'nullable|max:20',
            'status' => 'required|in:active,inactive'
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'full_name' => $request->full_name,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'department' => $request->department,
            'phone' => $request->phone,
            'status' => $request->status
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan.');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|alpha_dash|min:3|max:50|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'full_name' => 'required|min:3|max:150',
            'role' => 'required|in:admin,user',
            'department' => 'nullable|max:100',
            'phone' => 'nullable|max:20',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|min:6|confirmed'
        ]);

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'full_name' => $request->full_name,
            'role' => $request->role,
            'department' => $request->department,
            'phone' => $request->phone,
            'status' => $request->status
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        if ($user->tickets()->count() > 0) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus user yang masih memiliki tiket.');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
    }

    // Manajemen Kategori
    public function categories()
    {
        $categories = Category::withCount('tickets')->orderBy('name')->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.create-category');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:100',
            'description' => 'nullable|max:500'
        ]);

        Category::create($request->all());
        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.edit-category', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|max:100|unique:categories,name,' . $id,
            'description' => 'nullable|max:500'
        ]);

        $category->update($request->all());
        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);

        if ($category->tickets()->count() > 0) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus kategori yang masih memiliki tiket.');
        }

        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil dihapus.');
    }

    // Laporan dan Statistik
    public function reports(Request $request)
    {
        $dateFrom = $request->get('date_from', date('Y-m-01'));
        $dateTo = $request->get('date_to', date('Y-m-d'));

        $ticketsQuery = Ticket::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);

        $totalTickets = $ticketsQuery->count();
        $resolvedTickets = Ticket::where('status', 'Resolved')
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->count();
        $openTickets = $ticketsQuery->whereIn('status', ['Open', 'In Progress'])->count();
        $closedTickets = $ticketsQuery->where('status', 'Closed')->count();

        $avgResolutionTime = Ticket::where('status', 'Resolved')
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->whereNotNull('completed_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, completed_at)) as avg_time')
            ->first()
            ->avg_time ?? 0;

        $statusStatsAll = [
            'open' => Ticket::where('status', 'Open')->count(),
            'in_progress' => Ticket::where('status', 'In Progress')->count(),
            'resolved' => Ticket::where('status', 'Resolved')->count(),
            'closed' => Ticket::where('status', 'Closed')->count(),
        ];

        $priorityStatsAll = [
            'high' => Ticket::where('priority', 'High')->count(),
            'medium' => Ticket::where('priority', 'Medium')->count(),
            'low' => Ticket::where('priority', 'Low')->count(),
        ];

        $categoryStats = Category::withCount([
            'tickets' => function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);
            }
        ])
            ->having('tickets_count', '>', 0)
            ->orderBy('tickets_count', 'desc')
            ->get()
            ->map(function ($category) {
                return (object) ['name' => $category->name, 'total' => $category->tickets_count];
            });

        $topUsers = User::withCount([
            'tickets' => function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);
            }
        ])
            ->having('tickets_count', '>', 0)
            ->orderBy('tickets_count', 'desc')
            ->limit(5)
            ->get();

        $dailyLabels = [];
        $dailyTotal = [];
        $dailyResolved = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $dailyLabels[] = date('d/m', strtotime($date));
            $dailyTotal[] = Ticket::whereDate('created_at', $date)->count();
            $dailyResolved[] = Ticket::whereDate('created_at', $date)->where('status', 'Resolved')->count();
        }

        $monthlyStats = Ticket::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "Resolved" THEN 1 ELSE 0 END) as resolved'),
            DB::raw('AVG(CASE WHEN status = "Resolved" AND completed_at IS NOT NULL THEN TIMESTAMPDIFF(HOUR, created_at, completed_at) END) as avg_resolution_time')
        )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function ($item) {
                $item->month_name = date('F Y', strtotime($item->year . '-' . $item->month . '-01'));
                return $item;
            });

        return view('admin.reports', compact(
            'totalTickets',
            'resolvedTickets',
            'openTickets',
            'closedTickets',
            'avgResolutionTime',
            'statusStatsAll',
            'priorityStatsAll',
            'categoryStats',
            'topUsers',
            'dailyLabels',
            'dailyTotal',
            'dailyResolved',
            'monthlyStats',
            'dateFrom',
            'dateTo'
        ));
    }
}