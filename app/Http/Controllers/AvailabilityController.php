<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AvailabilityController extends Controller {

    public function index(Request $request) {
        $role = $request->session()->get('role');
        if ($role != 'Lawyer') return redirect('/');

        $lawyerId     = $request->session()->get('lawyer_id');
        $availability = DB::table('lawyer_availability')
            ->where('lawyer_id', $lawyerId)
            ->orderByRaw("FIELD(day_of_week,
                'Monday','Tuesday','Wednesday',
                'Thursday','Friday','Saturday','Sunday')")
            ->get();

        return view('lawyer.availability', compact('availability'));
    }

    public function store(Request $request) {
        $role = $request->session()->get('role');
        if ($role != 'Lawyer') return redirect('/');

        $lawyerId  = $request->session()->get('lawyer_id');
        $day       = $request->input('day_of_week');
        $startTime = $request->input('start_time');
        $endTime   = $request->input('end_time');

        // Check if already exists for this day
        $existing = DB::table('lawyer_availability')
            ->where('lawyer_id', $lawyerId)
            ->where('day_of_week', $day)
            ->first();

        if ($existing) {
            DB::table('lawyer_availability')
                ->where('id', $existing->id)
                ->update([
                    'start_time'   => $startTime,
                    'end_time'     => $endTime,
                    'is_available' => true,
                ]);
        } else {
            DB::table('lawyer_availability')->insert([
                'lawyer_id'    => $lawyerId,
                'day_of_week'  => $day,
                'start_time'   => $startTime,
                'end_time'     => $endTime,
                'is_available' => true,
            ]);
        }

        $request->session()->put('availability_success',
            'Availability updated successfully!');
        return redirect('http://localhost/justifind/public/lawyer-availability');
    }

    public function delete(Request $request) {
        $role = $request->session()->get('role');
        if ($role != 'Lawyer') return redirect('/');

        $id = $request->input('id');
        DB::table('lawyer_availability')->where('id', $id)->delete();

        $request->session()->put('availability_success', 'Availability removed.');
        return redirect('http://localhost/justifind/public/lawyer-availability');
    }
}