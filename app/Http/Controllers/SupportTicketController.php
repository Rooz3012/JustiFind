<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupportTicketController extends Controller {

    public function index(Request $request) {
        $role = $request->session()->get('role');
        if (!$role) return redirect('/');

        if ($role == 'Client') {
            $clientId = $request->session()->get('client_id');
            $tickets  = DB::select("SELECT t.*,
                (SELECT COUNT(*) FROM ticket_replies WHERE ticket_id = t.id) AS reply_count
                FROM support_tickets t
                WHERE t.client_id = ?
                ORDER BY t.created_at DESC", [$clientId]);
        } else {
            $tickets = DB::select("SELECT t.*,
                C.Name AS Client_Name,
                (SELECT COUNT(*) FROM ticket_replies WHERE ticket_id = t.id) AS reply_count
                FROM support_tickets t
                JOIN Client C ON t.client_id = C.CID
                ORDER BY t.created_at DESC");
        }

        return view('support.index', compact('tickets', 'role'));
    }

    public function store(Request $request) {
        $role = $request->session()->get('role');
        if ($role != 'Client') return redirect('/');

        $clientId   = $request->session()->get('client_id');
        $subject    = trim($request->input('subject'));
        $description = trim($request->input('description'));

        if (empty($subject) || empty($description)) {
            $request->session()->put('ticket_error', 'Please fill in all fields.');
            return redirect('http://localhost/justifind/public/support-tickets');
        }

        DB::table('support_tickets')->insert([
            'client_id'   => $clientId,
            'subject'     => $subject,
            'description' => $description,
            'status'      => 'Open',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $request->session()->put('ticket_success', 'Support ticket created successfully!');
        return redirect('http://localhost/justifind/public/support-tickets');
    }

    public function reply(Request $request) {
        $role = $request->session()->get('role');
        if (!$role) return redirect('/');

        $ticketId  = $request->input('ticket_id');
        $message   = trim($request->input('message'));
        $senderId  = $role == 'Client'
            ? $request->session()->get('client_id')
            : ($role == 'Lawyer'
                ? $request->session()->get('lawyer_id')
                : $request->session()->get('admin_id'));

        if (!empty($message)) {
            DB::table('ticket_replies')->insert([
                'ticket_id'   => $ticketId,
                'sender_type' => $role,
                'sender_id'   => $senderId,
                'message'     => $message,
                'created_at'  => now(),
            ]);

            // Update ticket status
            if ($role == 'Admin') {
                DB::table('support_tickets')
                    ->where('id', $ticketId)
                    ->update(['status' => 'In Progress', 'updated_at' => now()]);
            }
        }

        return redirect('http://localhost/justifind/public/support-tickets');
    }
}