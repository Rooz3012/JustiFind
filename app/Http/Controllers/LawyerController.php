<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LawyerController extends Controller {

    public function dashboard(Request $request) {
        if ($request->session()->get('role') != 'Lawyer') return redirect('/');

        $lawyerId = $request->session()->get('lawyer_id');
        $profile  = DB::table('Lawyer')->where('LID', $lawyerId)->first();

        if ($profile) {
            $family = DB::table('Family')->where('LID', $lawyerId)->first();
            if ($family) {
                $profile->Practice_Area = 'Family Law';
            } else {
                $criminal = DB::table('Criminal')->where('LID', $lawyerId)->first();
                if ($criminal) {
                    $profile->Practice_Area = 'Criminal Law';
                } else {
                    $corporate = DB::table('Corporate')->where('LID', $lawyerId)->first();
                    $profile->Practice_Area = $corporate ? 'Corporate Law' : 'General Law';
                }
            }
        }

        $upcoming = DB::select("SELECT Con.C_NO, Con.Date, Con.Time,
            Con.Type, Con.Online, Con.Offline, Con.CStatus,
            C.Name AS Client_Name, C.Email AS Client_Email
            FROM Consultation Con
            LEFT JOIN Client C ON Con.CID = C.CID
            WHERE Con.LID = ? AND Con.CStatus = 'Scheduled'
            AND Con.Date >= CURDATE()
            ORDER BY Con.Date ASC LIMIT 5", [$lawyerId]);

        $past = DB::select("SELECT Con.C_NO, Con.Date, Con.Type,
            C.Name AS Client_Name, P.Amount, P.Method AS Payment_Method
            FROM Consultation Con
            LEFT JOIN Client C ON Con.CID = C.CID
            LEFT JOIN Payment P ON Con.C_NO = P.C_NO
            WHERE Con.LID = ? AND Con.CStatus = 'Completed'
            ORDER BY Con.Date DESC LIMIT 5", [$lawyerId]);

        $earningsResult = DB::select("SELECT SUM(P.Amount) as total
            FROM Payment P JOIN Consultation Con ON P.C_NO = Con.C_NO
            WHERE Con.LID = ? AND P.PStatus = 'Completed'", [$lawyerId]);
        $earnings = $earningsResult[0]->total ?? 0;

        $unreadMessages = DB::table('messages')
            ->where('receiver_id', $lawyerId)
            ->where('receiver_type', 'Lawyer')
            ->where('is_read', false)->count();

        $unreadNotifications = DB::table('notifications')
            ->where('user_id', $lawyerId)
            ->where('user_type', 'Lawyer')
            ->where('is_read', false)->count();

        $verification = DB::table('lawyer_verification')
            ->where('lawyer_id', $lawyerId)->first();

        return view('lawyer.dashboard', compact(
            'profile', 'upcoming', 'past', 'earnings',
            'unreadMessages', 'unreadNotifications', 'verification'
        ));
    }

    public function editProfile(Request $request) {
        if ($request->session()->get('role') != 'Lawyer') return redirect('/');

        $lawyerId = $request->session()->get('lawyer_id');
        $profile  = DB::table('Lawyer')->where('LID', $lawyerId)->first();

        $family    = DB::table('Family')->where('LID', $lawyerId)->first();
        $criminal  = DB::table('Criminal')->where('LID', $lawyerId)->first();
        $corporate = DB::table('Corporate')->where('LID', $lawyerId)->first();

        return view('lawyer.edit-profile', compact(
            'profile', 'family', 'criminal', 'corporate'
        ));
    }

    public function updateProfile(Request $request) {
        if ($request->session()->get('role') != 'Lawyer') return redirect('/');

        $lawyerId = $request->session()->get('lawyer_id');

        DB::table('Lawyer')->where('LID', $lawyerId)->update([
            'Name'        => $request->input('name'),
            'Profile'     => $request->input('profile'),
            'Hourly_Rate' => $request->input('hourly_rate'),
            'Experience'  => $request->input('experience'),
        ]);

        $request->session()->put('profile_success', 'Profile updated successfully!');
        return redirect('http://localhost/justifind/public/lawyer-dashboard');
    }

    public function updateStatus(Request $request) {
        if ($request->session()->get('role') != 'Lawyer') return redirect('/');

        $consultationId = $request->input('consultation_id');
        $status         = $request->input('status');

        DB::table('Consultation')
            ->where('C_NO', $consultationId)
            ->update(['CStatus' => $status]);

        // Notify client
        $consultation = DB::table('Consultation')
            ->where('C_NO', $consultationId)->first();

        if ($consultation) {
            DB::table('notifications')->insert([
                'user_id'    => $consultation->CID,
                'user_type'  => 'Client',
                'title'      => 'Consultation Status Updated',
                'message'    => 'Your consultation #' . $consultationId .
                    ' status has been updated to: ' . $status,
                'created_at' => now(),
            ]);
        }

        $request->session()->put('status_success',
            'Consultation status updated to ' . $status);
        return redirect('http://localhost/justifind/public/lawyer-dashboard');
    }
}