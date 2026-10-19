<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecommendationController extends Controller {

    public function index(Request $request) {
        $role = $request->session()->get('role');
        if ($role != 'Client') return redirect('/');

        $clientId = $request->session()->get('client_id');

        // Get client's past consultation types
        $pastConsultations = DB::select("SELECT Type, COUNT(*) as count,
            CASE
                WHEN EXISTS (SELECT 1 FROM Family WHERE LID = Con.LID) THEN 'family'
                WHEN EXISTS (SELECT 1 FROM Criminal WHERE LID = Con.LID) THEN 'criminal'
                WHEN EXISTS (SELECT 1 FROM Corporate WHERE LID = Con.LID) THEN 'corporate'
                ELSE 'general'
            END AS practice_area
            FROM Consultation Con
            WHERE Con.CID = ?
            GROUP BY Type, practice_area
            ORDER BY count DESC LIMIT 3",
            [$clientId]);

        // Get preferred practice area
        $preferredArea = !empty($pastConsultations)
            ? $pastConsultations[0]->practice_area
            : 'general';

        // Get lawyers already consulted
        $consultedLawyerIds = DB::table('Consultation')
            ->where('CID', $clientId)
            ->pluck('LID')
            ->toArray();

        // Recommend lawyers based on preferred area and high success rate
        $query = DB::table('Lawyer AS L')
            ->select('L.LID', 'L.Name', 'L.Experience',
                'L.Profile', 'L.Hourly_Rate', 'L.Success_Rate',
                DB::raw("(SELECT CASE
                    WHEN EXISTS (SELECT 1 FROM Family WHERE LID = L.LID) THEN 'Family Law'
                    WHEN EXISTS (SELECT 1 FROM Criminal WHERE LID = L.LID) THEN 'Criminal Law'
                    WHEN EXISTS (SELECT 1 FROM Corporate WHERE LID = L.LID) THEN 'Corporate Law'
                    ELSE 'General Law' END) AS Practice_Area"),
                DB::raw("(SELECT COUNT(*) FROM Review WHERE LID = L.LID) AS review_count")
            )
            ->where('L.Success_Rate', '>=', 88)
            ->orderBy('L.Success_Rate', 'desc')
            ->orderBy('L.Experience', 'desc')
            ->limit(6);

        // Filter by preferred area
        if ($preferredArea == 'family') {
            $query->whereExists(function($q) {
                $q->select(DB::raw(1))->from('Family')->whereColumn('LID', 'L.LID');
            });
        } elseif ($preferredArea == 'criminal') {
            $query->whereExists(function($q) {
                $q->select(DB::raw(1))->from('Criminal')->whereColumn('LID', 'L.LID');
            });
        } elseif ($preferredArea == 'corporate') {
            $query->whereExists(function($q) {
                $q->select(DB::raw(1))->from('Corporate')->whereColumn('LID', 'L.LID');
            });
        }

        $recommended = $query->get();

        // If not enough recommendations, get top rated lawyers
        if (count($recommended) < 3) {
            $recommended = DB::table('Lawyer AS L')
                ->select('L.LID', 'L.Name', 'L.Experience',
                    'L.Profile', 'L.Hourly_Rate', 'L.Success_Rate',
                    DB::raw("(SELECT CASE
                        WHEN EXISTS (SELECT 1 FROM Family WHERE LID = L.LID) THEN 'Family Law'
                        WHEN EXISTS (SELECT 1 FROM Criminal WHERE LID = L.LID) THEN 'Criminal Law'
                        WHEN EXISTS (SELECT 1 FROM Corporate WHERE LID = L.LID) THEN 'Corporate Law'
                        ELSE 'General Law' END) AS Practice_Area"),
                    DB::raw("(SELECT COUNT(*) FROM Review WHERE LID = L.LID) AS review_count")
                )
                ->orderBy('L.Success_Rate', 'desc')
                ->orderBy('L.Experience', 'desc')
                ->limit(6)
                ->get();
        }

        return view('recommendations.index', compact(
            'recommended', 'preferredArea', 'pastConsultations'
        ));
    }
}