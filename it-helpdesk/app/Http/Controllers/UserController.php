<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use App\Models\StatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user');
    }

    // Dashboard User
    public function dashboard()
    {
        $userId = Auth::id();

        $stats = [
            'total' => Ticket::where('user_id', $userId)->count(),
            'open' => Ticket::where('user_id', $userId)->where('status', 'Open')->count(),
            'in_progress' => Ticket::where('user_id', $userId)->where('status', 'In Progress')->count(),
            'resolved' => Ticket::where('user_id', $userId)->where('status', 'Resolved')->count(),
            'closed' => Ticket::where('user_id', $userId)->where('status', 'Closed')->count(),
        ];

        $recentTickets = Ticket::where('user_id', $userId)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('user.dashboard', compact('stats', 'recentTickets'));
    }

    // Form create ticket
    public function createTicket()
    {
        $categories = Category::all();
        return view('user.create-ticket', compact('categories'));
    }

    // Store ticket
    public function storeTicket(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|min:5|max:200',
            'description' => 'required|min:10',
            'priority' => 'required|in:Low,Medium,High'
        ]);

        $ticket = Ticket::create([
            'ticket_number' => Ticket::generateTicketNumber(),
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'Open'
        ]);

        return redirect()->route('user.my-tickets')
            ->with('success', 'Tiket berhasil dibuat. Nomor tiket: ' . $ticket->ticket_number);
    }

    // Menampilkan tiket user
    public function myTickets(Request $request)
    {
        $query = Ticket::where('user_id', Auth::id())->with('category');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'LIKE', "%{$search}%")
                    ->orWhere('title', 'LIKE', "%{$search}%");
            });
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(10);
        $statuses = ['Open', 'In Progress', 'Resolved', 'Closed'];

        return view('user.my-tickets', compact('tickets', 'statuses'));
    }

    // Detail tiket
    public function ticketDetail($id)
    {
        $ticket = Ticket::with(['category', 'responses.user', 'statusLogs.changer'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.ticket-detail', compact('ticket'));
    }

    // Form edit tiket
    public function editTicket($id)
    {
        $ticket = Ticket::with(['category'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if (!in_array($ticket->status, ['Open', 'In Progress'])) {
            return redirect()->route('user.my-tickets')
                ->with('error', 'Tiket dengan status ' . $ticket->status . ' tidak dapat diedit.');
        }

        $categories = Category::all();
        $priorities = ['Low', 'Medium', 'High'];

        return view('user.edit-ticket', compact('ticket', 'categories', 'priorities'));
    }

    // Update tiket
    public function updateTicket(Request $request, $id)
    {
        $ticket = Ticket::where('user_id', Auth::id())->findOrFail($id);

        if (!in_array($ticket->status, ['Open', 'In Progress'])) {
            return redirect()->route('user.my-tickets')
                ->with('error', 'Tiket dengan status ' . $ticket->status . ' tidak dapat diedit.');
        }

        $request->validate([
            'title' => 'required|min:5|max:200',
            'description' => 'required|min:10',
            'category_id' => 'required|exists:categories,id',
            'priority' => 'required|in:Low,Medium,High'
        ]);

        $ticket->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'priority' => $request->priority
        ]);

        return redirect()->route('user.my-tickets')
            ->with('success', 'Tiket berhasil diperbarui.');
    }

    // Delete tiket
    public function deleteTicket($id)
    {
        $ticket = Ticket::where('user_id', Auth::id())->findOrFail($id);

        if ($ticket->status != 'Open') {
            return redirect()->route('user.my-tickets')
                ->with('error', 'Hanya tiket dengan status Open yang dapat dihapus.');
        }

        $ticketNumber = $ticket->ticket_number;
        $ticket->delete();

        return redirect()->route('user.my-tickets')
            ->with('success', 'Tiket ' . $ticketNumber . ' berhasil dihapus.');
    }

    // Tambah respon ke tiket
    public function addResponse(Request $request, $id)
    {
        $request->validate([
            'response' => 'required|string|min:3'
        ]);

        $ticket = Ticket::where('user_id', Auth::id())->findOrFail($id);

        $ticket->responses()->create([
            'user_id' => Auth::id(),
            'response' => $request->response,
            'is_admin_response' => false
        ]);

        return redirect()->back()->with('success', 'Respon berhasil ditambahkan.');
    }

    // Close ticket
    public function closeTicket($id)
    {
        $ticket = Ticket::where('user_id', Auth::id())
            ->where('status', 'Resolved')
            ->findOrFail($id);

        $oldStatus = $ticket->status;
        $ticket->status = 'Closed';
        $ticket->save();

        StatusLog::create([
            'ticket_id' => $ticket->id,
            'old_status' => $oldStatus,
            'new_status' => 'Closed',
            'changed_by' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Tiket berhasil ditutup.');
    }
}