<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {

    public function dashboard(Request $request) {
        if ($request->session()->get('role') != 'Admin') return redirect('/');

        $clients = DB::table('Client')->get();
        $lawyers = DB::table('Lawyer')->get();

        $bookings = DB::select("SELECT Con.C_NO, Con.Date, Con.Time,
            Con.CStatus, Con.Type, Con.Offline, Con.Online, Con.Pay_Sts,
            Cl.Name AS Client_Name, Cl.Email AS Client_Email,
            L.Name AS Lawyer_Name, L.Hourly_Rate
            FROM Consultation Con
            LEFT JOIN Client Cl ON Con.CID = Cl.CID
            LEFT JOIN Lawyer L ON Con.LID = L.LID
            ORDER BY Con.Date DESC");

        $transactions = DB::select("SELECT P.Pay_ID, P.PStatus, P.Method,
            P.Date, P.Amount, Con.Type,
            Cl.Name AS Client_Name, L.Name AS Lawyer_Name
            FROM Payment P
            JOIN Consultation Con ON P.C_NO = Con.C_NO
            JOIN Client Cl ON Con.CID = Cl.CID
            JOIN Lawyer L ON Con.LID = L.LID
            ORDER BY P.Date DESC LIMIT 20");

        $unverifiedLawyers = DB::select("SELECT L.*, lv.is_verified
            FROM Lawyer L
            LEFT JOIN lawyer_verification lv ON L.LID = lv.lawyer_id
            ORDER BY lv.is_verified ASC, L.LID DESC");

        $tickets = DB::select("SELECT t.*, C.Name AS Client_Name
            FROM support_tickets t
            JOIN Client C ON t.client_id = C.CID
            ORDER BY t.created_at DESC");

        $stats = [
            'total_clients'       => count($clients),
            'total_lawyers'       => count($lawyers),
            'total_bookings'      => count($bookings),
            'total_transactions'  => count($transactions),
            'pending_tickets'     => DB::table('support_tickets')
                ->where('status', 'Open')->count(),
            'unverified_lawyers'  => DB::table('lawyer_verification')
                ->where('is_verified', false)->count(),
            'total_revenue'       => DB::table('Payment')
                ->where('PStatus', 'Completed')->sum('Amount'),
        ];

        return view('admin.dashboard', compact(
            'clients', 'lawyers', 'bookings', 'transactions',
            'unverifiedLawyers', 'tickets', 'stats'
        ));
    }

    public function deleteBooking(Request $request) {
        if ($request->session()->get('role') != 'Admin') return redirect('/');

        $bookingId = $request->input('booking_id');
        $reason    = trim($request->input('delete_reason', ''));
        $adminId   = $request->session()->get('admin_id');

        if ($bookingId > 0) {
            try {
                $booking = DB::table('Consultation')->where('C_NO', $bookingId)->first();
                if ($booking) {
                    DB::beginTransaction();

                    // Log deletion
                    DB::table('Deletion_Log')->insert([
                        'Admin_ID'      => $adminId,
                        'Booking_ID'    => $bookingId,
                        'Client_ID'     => $booking->CID,
                        'Lawyer_ID'     => $booking->LID,
                        'Reason'        => $reason,
                        'Deletion_Date' => now(),
                    ]);

                    DB::table('Payment')->where('C_NO', $bookingId)->delete();
                    DB::table('Client_Documents')->where('C_NO', $bookingId)->delete();
                    DB::table('Consultation')->where('C_NO', $bookingId)->delete();
                    DB::commit();
                    $request->session()->put('delete_message',
                        'Booking #' . $bookingId . ' deleted successfully.');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                $request->session()->put('delete_error', $e->getMessage());
            }
        }

        return redirect('http://localhost/justifind/public/admin');
    }

    public function verifyLawyer(Request $request) {
        if ($request->session()->get('role') != 'Admin') return redirect('/');

        $lawyerId  = $request->input('lawyer_id');
        $adminId   = $request->session()->get('admin_id');
        $isVerified = $request->input('is_verified') == '1' ? true : false;

        DB::table('lawyer_verification')
            ->where('lawyer_id', $lawyerId)
            ->update([
                'is_verified' => $isVerified,
                'verified_by' => $adminId,
                'verified_at' => now(),
                'notes'       => $request->input('notes', ''),
            ]);

        DB::table('notifications')->insert([
            'user_id'    => $lawyerId,
            'user_type'  => 'Lawyer',
            'title'      => $isVerified ? 'Profile Verified!' : 'Verification Rejected',
            'message'    => $isVerified
                ? 'Congratulations! Your profile has been verified by admin.'
                : 'Your verification was rejected. Please contact support.',
            'created_at' => now(),
        ]);

        $request->session()->put('verify_message',
            'Lawyer verification status updated successfully.');
        return redirect('http://localhost/justifind/public/admin');
    }

    public function updateTicket(Request $request) {
        if ($request->session()->get('role') != 'Admin') return redirect('/');

        $ticketId = $request->input('ticket_id');
        $status   = $request->input('status');
        $reply    = trim($request->input('reply', ''));
        $adminId  = $request->session()->get('admin_id');

        DB::table('support_tickets')
            ->where('id', $ticketId)
            ->update(['status' => $status, 'updated_at' => now()]);

        if (!empty($reply)) {
            DB::table('ticket_replies')->insert([
                'ticket_id'   => $ticketId,
                'sender_type' => 'Admin',
                'sender_id'   => $adminId,
                'message'     => $reply,
                'created_at'  => now(),
            ]);
        }

        $request->session()->put('ticket_message', 'Ticket updated successfully.');
        return redirect('http://localhost/justifind/public/admin');
    }
}