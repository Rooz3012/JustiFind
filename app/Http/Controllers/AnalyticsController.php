<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller {

    public function index(Request $request) {
        $role = $request->session()->get('role');
        if ($role != 'Lawyer') return redirect('/');

        $lawyerId = $request->session()->get('lawyer_id');

        // Total consultations
        $totalConsultations = DB::table('Consultation')
            ->where('LID', $lawyerId)->count();

        // Completed consultations
        $completedConsultations = DB::table('Consultation')
            ->where('LID', $lawyerId)
            ->where('CStatus', 'Completed')->count();

        // Cancelled consultations
        $cancelledConsultations = DB::table('Consultation')
            ->where('LID', $lawyerId)
            ->where('CStatus', 'Cancelled')->count();

        // Total earnings
        $earningsResult = DB::select("SELECT SUM(P.Amount) as total
            FROM Payment P
            JOIN Consultation Con ON P.C_NO = Con.C_NO
            WHERE Con.LID = ? AND P.PStatus = 'Completed'",
            [$lawyerId]);
        $totalEarnings = $earningsResult[0]->total ?? 0;

        // Monthly earnings
        $monthlyEarnings = DB::select("SELECT
            DATE_FORMAT(P.Date, '%Y-%m') AS month,
            SUM(P.Amount) AS total
            FROM Payment P
            JOIN Consultation Con ON P.C_NO = Con.C_NO
            WHERE Con.LID = ? AND P.PStatus = 'Completed'
            GROUP BY DATE_FORMAT(P.Date, '%Y-%m')
            ORDER BY month DESC LIMIT 6",
            [$lawyerId]);

        // Average rating
        $ratingResult = DB::select("SELECT COUNT(*) as total_reviews
            FROM Review WHERE LID = ?", [$lawyerId]);
        $totalReviews = $ratingResult[0]->total_reviews ?? 0;

        // Consultation types breakdown
        $typeBreakdown = DB::select("SELECT Type, COUNT(*) as count
            FROM Consultation WHERE LID = ?
            GROUP BY Type ORDER BY count DESC LIMIT 5",
            [$lawyerId]);

        // Recent clients
        $recentClients = DB::select("SELECT DISTINCT
            C.Name AS Client_Name, C.Email AS Client_Email,
            MAX(Con.Date) AS Last_Consultation
            FROM Consultation Con
            JOIN Client C ON Con.CID = C.CID
            WHERE Con.LID = ?
            GROUP BY C.CID, C.Name, C.Email
            ORDER BY Last_Consultation DESC LIMIT 5",
            [$lawyerId]);

        // Payment methods breakdown
        $paymentMethods = DB::select("SELECT Method, COUNT(*) as count,
            SUM(Amount) as total
            FROM Payment P
            JOIN Consultation Con ON P.C_NO = Con.C_NO
            WHERE Con.LID = ?
            GROUP BY Method",
            [$lawyerId]);

        return view('lawyer.analytics', compact(
            'totalConsultations',
            'completedConsultations',
            'cancelledConsultations',
            'totalEarnings',
            'monthlyEarnings',
            'totalReviews',
            'typeBreakdown',
            'recentClients',
            'paymentMethods'
        ));
    }
}