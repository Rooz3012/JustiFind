<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller {

    public function process(Request $request) {
        $role = $request->session()->get('role');
        if ($role != 'Client') return redirect('/');

        $consultationId = $request->input('consultation_id');
        $method         = $request->input('payment_method');
        $amount         = $request->input('amount');

        // Update payment status
        DB::table('Payment')
            ->where('C_NO', $consultationId)
            ->update([
                'PStatus' => 'Completed',
                'Method'  => $method,
                'Date'    => now()->format('Y-m-d'),
            ]);

        // Update consultation pay status
        DB::table('Consultation')
            ->where('C_NO', $consultationId)
            ->update(['Pay_Sts' => 'Paid']);

        // Create notification for lawyer
        $consultation = DB::table('Consultation')
            ->where('C_NO', $consultationId)->first();

        if ($consultation) {
            DB::table('notifications')->insert([
                'user_id'    => $consultation->LID,
                'user_type'  => 'Lawyer',
                'title'      => 'Payment Received',
                'message'    => 'Payment of ৳' . number_format($amount) .
                    ' received for consultation #' . $consultationId,
                'created_at' => now(),
            ]);
        }

        $request->session()->put('payment_success',
            'Payment of ৳' . number_format($amount) . ' processed successfully!');
        return redirect('http://localhost/justifind/public/appointments');
    }

    public function success(Request $request) {
        return view('payment.success');
    }
}