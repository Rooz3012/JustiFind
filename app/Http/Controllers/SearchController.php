<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller {

    public function index(Request $request) {
        $filters = [
            'search'         => $request->input('q', ''),
            'practice_area'  => $request->input('practice_area', ''),
            'min_experience' => $request->input('min_experience', ''),
            'max_fee'        => $request->input('max_fee', ''),
            'min_success'    => $request->input('min_success', ''),
        ];

        $query = DB::table('Lawyer AS L')
            ->select(
                'L.LID', 'L.Name', 'L.Experience',
                'L.Profile', 'L.Hourly_Rate', 'L.Success_Rate',
                DB::raw("(SELECT CASE
                    WHEN EXISTS (SELECT 1 FROM Family WHERE LID = L.LID) THEN 'Family Law'
                    WHEN EXISTS (SELECT 1 FROM Criminal WHERE LID = L.LID) THEN 'Criminal Law'
                    WHEN EXISTS (SELECT 1 FROM Corporate WHERE LID = L.LID) THEN 'Corporate Law'
                    ELSE 'General Law' END) AS Practice_Area")
            );

        if (!empty($filters['search'])) {
            $query->where(function($q) use ($filters) {
                $q->where('L.Name', 'LIKE', '%'.$filters['search'].'%')
                  ->orWhere('L.Profile', 'LIKE', '%'.$filters['search'].'%');
            });
        }
        if (!empty($filters['practice_area'])) {
            if ($filters['practice_area'] == 'family')
                $query->whereExists(function($q) {
                    $q->select(DB::raw(1))->from('Family')->whereColumn('LID', 'L.LID');
                });
            if ($filters['practice_area'] == 'criminal')
                $query->whereExists(function($q) {
                    $q->select(DB::raw(1))->from('Criminal')->whereColumn('LID', 'L.LID');
                });
            if ($filters['practice_area'] == 'corporate')
                $query->whereExists(function($q) {
                    $q->select(DB::raw(1))->from('Corporate')->whereColumn('LID', 'L.LID');
                });
        }

        if ($filters['min_experience'] !== '' && $filters['min_experience'] !== null)
            $query->where('L.Experience', '>=', (int)$filters['min_experience']);
        if ($filters['max_fee'] !== '' && $filters['max_fee'] !== null)
            $query->where('L.Hourly_Rate', '<=', (float)$filters['max_fee']);
        if ($filters['min_success'] !== '' && $filters['min_success'] !== null)
            $query->where('L.Success_Rate', '>=', (float)$filters['min_success']);

        $lawyers = $query->orderBy('L.Experience', 'desc')
                         ->orderBy('L.Success_Rate', 'desc')
                         ->get();

        return view('search.index', compact('lawyers', 'filters'));
    }

    public function profile(Request $request) {
        $lawyerId   = $request->input('lawyer_id', 0);
        $lawyer     = null;
        $reviews    = [];
        $notFound   = false;
        $isVerified = false;

        if ($lawyerId > 0) {
            $lawyer = DB::table('Lawyer')->where('LID', $lawyerId)->first();
            if ($lawyer) {
                $family = DB::table('Family')->where('LID', $lawyerId)->first();
                if ($family) {
                    $lawyer->Practice_Area = 'Family Law';
                    $lawyer->specialty = $family;
                } else {
                    $criminal = DB::table('Criminal')->where('LID', $lawyerId)->first();
                    if ($criminal) {
                        $lawyer->Practice_Area = 'Criminal Law';
                        $lawyer->specialty = $criminal;
                    } else {
                        $corporate = DB::table('Corporate')->where('LID', $lawyerId)->first();
                        if ($corporate) {
                            $lawyer->Practice_Area = 'Corporate Law';
                            $lawyer->specialty = $corporate;
                        } else {
                            $lawyer->Practice_Area = 'General Law';
                            $lawyer->specialty = null;
                        }
                    }
                }

                $verif      = DB::table('lawyer_verification')->where('lawyer_id', $lawyerId)->first();
                $isVerified = $verif && $verif->is_verified;

                $reviews = DB::select("SELECT R.Rev_Text, R.Rev_Date,
                    C.Name AS Client_Name
                    FROM Review R
                    JOIN Client C ON R.CID = C.CID
                    WHERE R.LID = ?
                    ORDER BY R.Rev_Date DESC", [$lawyerId]);
            } else {
                $notFound = true;
            }
        } else {
            $notFound = true;
        }

        return view('search.profile', compact('lawyer', 'reviews', 'notFound', 'isVerified'));
    }
}