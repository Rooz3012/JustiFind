<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller {

    public function appointments(Request $request) {
        if (!$request->session()->has('role')) return redirect('/');
        $clientId = $request->session()->get('client_id');
        $appointments = DB::select("SELECT Con.C_NO, Con.Date, Con.Time,
            Con.CStatus, Con.Type, Con.Offline, Con.Online, Con.Pay_Sts,
            L.Name AS Lawyer_Name, L.LID AS Lawyer_ID, L.Hourly_Rate,
            CASE
                WHEN F.LID IS NOT NULL THEN 'Family Law'
                WHEN CR.LID IS NOT NULL THEN 'Criminal Law'
                WHEN CO.LID IS NOT NULL THEN 'Corporate Law'
                ELSE 'General Law'
            END AS Practice_Area,
            P.Amount, P.Method AS Payment_Method, P.PStatus AS Payment_Status
            FROM Consultation Con
            LEFT JOIN Lawyer L ON Con.LID = L.LID
            LEFT JOIN Family F ON L.LID = F.LID
            LEFT JOIN Criminal CR ON L.LID = CR.LID
            LEFT JOIN Corporate CO ON L.LID = CO.LID
            LEFT JOIN Payment P ON Con.C_NO = P.C_NO
            WHERE Con.CID = ?
            ORDER BY Con.Date DESC", [$clientId]);
        return view('client.appointments', compact('appointments'));
    }

    public function book(Request $request) {
        if ($request->session()->get('role') != 'Client') return redirect('/');

        $lawyerId  = $request->input('lawyer_id');
        $clientId  = $request->session()->get('client_id');
        $date      = $request->input('consultation_date');
        $time      = $request->input('consultation_time');
        $type      = $request->input('consultation_type');
        $mode      = $request->input('consultation_mode');
        $payMethod = $request->input('payment_method');
        $online    = ($mode == 'online')  ? 1 : 0;
        $offline   = ($mode == 'offline') ? 1 : 0;

        $consultationId = DB::table('Consultation')->insertGetId([
            'LID' => $lawyerId, 'CID' => $clientId,
            'Date' => $date, 'Time' => $time,
            'Offline' => $offline, 'Online' => $online,
            'CStatus' => 'Scheduled', 'Type' => $type, 'Pay_Sts' => 'Pending',
        ]);

        if ($consultationId) {
            $lawyer = DB::table('Lawyer')->where('LID', $lawyerId)->first();
            DB::table('Payment')->insert([
                'PStatus' => 'Pending', 'Method' => $payMethod,
                'Date' => now()->format('Y-m-d'),
                'Amount' => $lawyer->Hourly_Rate, 'C_NO' => $consultationId,
            ]);

            DB::table('notifications')->insert([
                'user_id' => $lawyerId, 'user_type' => 'Lawyer',
                'title' => 'New Booking!',
                'message' => 'You have a new consultation booking #' . $consultationId .
                    ' scheduled for ' . $date,
                'created_at' => now(),
            ]);

            $request->session()->put('booking_success',
                'Appointment booked! Consultation ID: #' . $consultationId);
        } else {
            $request->session()->put('booking_error', 'Booking failed.');
        }
        return redirect('/');
    }

    public function cancelBooking(Request $request) {
        if ($request->session()->get('role') != 'Client') return redirect('/');

        $consultationId = $request->input('consultation_id');
        $clientId       = $request->session()->get('client_id');

        $consultation = DB::table('Consultation')
            ->where('C_NO', $consultationId)
            ->where('CID', $clientId)->first();

        if ($consultation && $consultation->CStatus == 'Scheduled') {
            DB::table('Consultation')
                ->where('C_NO', $consultationId)
                ->update(['CStatus' => 'Cancelled']);

            DB::table('Payment')
                ->where('C_NO', $consultationId)
                ->update(['PStatus' => 'Refunded']);

            DB::table('notifications')->insert([
                'user_id' => $consultation->LID, 'user_type' => 'Lawyer',
                'title' => 'Booking Cancelled',
                'message' => 'Consultation #' . $consultationId . ' has been cancelled by client.',
                'created_at' => now(),
            ]);

            $request->session()->put('cancel_success',
                'Appointment #' . $consultationId . ' cancelled successfully.');
        }
        return redirect('http://localhost/justifind/public/appointments');
    }

    public function rescheduleBooking(Request $request) {
        if ($request->session()->get('role') != 'Client') return redirect('/');

        $consultationId = $request->input('consultation_id');
        $clientId       = $request->session()->get('client_id');
        $newDate        = $request->input('new_date');
        $newTime        = $request->input('new_time');

        $consultation = DB::table('Consultation')
            ->where('C_NO', $consultationId)
            ->where('CID', $clientId)->first();

        if ($consultation && $consultation->CStatus == 'Scheduled') {
            DB::table('Consultation')
                ->where('C_NO', $consultationId)
                ->update(['Date' => $newDate, 'Time' => $newTime]);

            DB::table('notifications')->insert([
                'user_id' => $consultation->LID, 'user_type' => 'Lawyer',
                'title' => 'Booking Rescheduled',
                'message' => 'Consultation #' . $consultationId .
                    ' rescheduled to ' . $newDate . ' at ' . $newTime,
                'created_at' => now(),
            ]);

            $request->session()->put('reschedule_success',
                'Appointment rescheduled to ' . $newDate . ' at ' . $newTime);
        }
        return redirect('http://localhost/justifind/public/appointments');
    }

    public function uploadDocument(Request $request) {
        if ($request->session()->get('role') != 'Client') return redirect('/');

        $consultationId = $request->input('consultation_id');
        $clientId       = $request->session()->get('client_id');
        $consultation   = DB::table('Consultation')
            ->where('C_NO', $consultationId)->first();

        if ($consultation && $consultation->CID == $clientId) {
            if ($request->hasFile('document_file')) {
                $file = $request->file('document_file');
                $allowedTypes = ['application/pdf', 'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'image/jpeg', 'image/png'];
                if (!in_array($file->getMimeType(), $allowedTypes)) {
                    $request->session()->put('upload_error', 'Invalid file type.');
                } elseif ($file->getSize() > 10 * 1024 * 1024) {
                    $request->session()->put('upload_error', 'File too large. Max 10MB.');
                } else {
                    $uploadDir  = public_path('uploads/documents/');
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                    $uniqueName = time() . '_' . preg_replace(
                        '/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName()
                    );
                    $file->move($uploadDir, $uniqueName);
                    DB::table('Client_Documents')->insert([
                        'C_NO' => $consultationId, 'CID' => $clientId,
                        'LID' => $consultation->LID,
                        'Document_Name' => $request->input('document_name', $file->getClientOriginalName()),
                        'File_Path' => 'uploads/documents/' . $uniqueName,
                        'File_Size' => $file->getSize(),
                        'File_Type' => $file->getMimeType(),
                        'Description' => $request->input('document_description', ''),
                        'Upload_Date' => now(),
                    ]);
                    $request->session()->put('upload_message', 'Document uploaded successfully!');
                }
            } else {
                $request->session()->put('upload_error', 'No file selected.');
            }
        }
        return redirect('http://localhost/justifind/public/appointments');
    }

    public function submitReview(Request $request) {
        if ($request->session()->get('role') != 'Client') return redirect('/');

        $consultationId = $request->input('consultation_id');
        $lawyerId       = $request->input('lawyer_id');
        $clientId       = $request->session()->get('client_id');
        $reviewText     = trim($request->input('review_text', ''));

        if (strlen($reviewText) < 10) {
            $request->session()->put('review_error', 'Review must be at least 10 characters.');
            return redirect('http://localhost/justifind/public/appointments');
        }

        $consultation = DB::table('Consultation')
            ->where('C_NO', $consultationId)->first();

        if ($consultation && $consultation->CID == $clientId &&
            $consultation->LID == $lawyerId &&
            $consultation->CStatus == 'Completed') {
            DB::table('Review')->insert([
                'Rev_Text' => $reviewText,
                'Rev_Date' => now(),
                'CID' => $clientId, 'LID' => $lawyerId,
            ]);
            $request->session()->put('review_message', 'Review submitted successfully!');
        } else {
            $request->session()->put('review_error', 'Can only review completed consultations.');
        }
        return redirect('http://localhost/justifind/public/appointments');
    }
}