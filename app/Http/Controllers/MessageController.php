<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller {

    public function index(Request $request) {
        $role = $request->session()->get('role');
        if (!$role) return redirect('/');

        $userId   = $role == 'Client'
            ? $request->session()->get('client_id')
            : $request->session()->get('lawyer_id');

        if ($role == 'Client') {
            $consultations = DB::select("SELECT Con.C_NO, Con.Type, Con.Date,
                L.Name AS Other_Name, L.LID AS Other_ID, 'Lawyer' AS Other_Type,
                (SELECT COUNT(*) FROM messages m WHERE m.consultation_id = Con.C_NO
                    AND m.receiver_id = ? AND m.receiver_type = ? AND m.is_read = 0) AS unread
                FROM Consultation Con
                JOIN Lawyer L ON Con.LID = L.LID
                WHERE Con.CID = ?
                ORDER BY Con.Date DESC", [$userId, $role, $userId]);
        } else {
            $consultations = DB::select("SELECT Con.C_NO, Con.Type, Con.Date,
                C.Name AS Other_Name, C.CID AS Other_ID, 'Client' AS Other_Type,
                (SELECT COUNT(*) FROM messages m WHERE m.consultation_id = Con.C_NO
                    AND m.receiver_id = ? AND m.receiver_type = ? AND m.is_read = 0) AS unread
                FROM Consultation Con
                JOIN Client C ON Con.CID = C.CID
                WHERE Con.LID = ?
                ORDER BY Con.Date DESC", [$userId, $role, $userId]);
        }

        return view('messages.index', compact('consultations', 'role', 'userId'));
    }

    public function conversation(Request $request, $consultationId) {
        $role = $request->session()->get('role');
        if (!$role) return redirect('/');

        $userId = $role == 'Client'
            ? $request->session()->get('client_id')
            : $request->session()->get('lawyer_id');

        // Mark messages as read
        DB::table('messages')
            ->where('consultation_id', $consultationId)
            ->where('receiver_id', $userId)
            ->where('receiver_type', $role)
            ->update(['is_read' => true]);

        $messages = DB::select("SELECT * FROM messages
            WHERE consultation_id = ?
            ORDER BY created_at ASC", [$consultationId]);

        $consultation = DB::table('Consultation')
            ->where('C_NO', $consultationId)->first();

        if (!$consultation) return redirect('http://localhost/justifind/public/messages');

        if ($role == 'Client') {
            $other     = DB::table('Lawyer')->where('LID', $consultation->LID)->first();
            $otherName = $other->Name;
            $otherId   = $other->LID;
            $otherType = 'Lawyer';
        } else {
            $other     = DB::table('Client')->where('CID', $consultation->CID)->first();
            $otherName = $other->Name;
            $otherId   = $other->CID;
            $otherType = 'Client';
        }

        $pusherKey     = config('broadcasting.connections.pusher.key');
        $pusherCluster = config('broadcasting.connections.pusher.options.cluster');

        return view('messages.conversation', compact(
            'messages', 'consultation', 'otherName',
            'otherId', 'otherType', 'role', 'userId',
            'consultationId', 'pusherKey', 'pusherCluster'
        ));
    }

    public function send(Request $request) {
        $role = $request->session()->get('role');
        if (!$role) return redirect('/');

        $userId         = $role == 'Client'
            ? $request->session()->get('client_id')
            : $request->session()->get('lawyer_id');
        $senderName     = $role == 'Client'
            ? $request->session()->get('client_name')
            : $request->session()->get('lawyer_name');
        $consultationId = $request->input('consultation_id');
        $message        = trim($request->input('message'));
        $receiverId     = $request->input('receiver_id');
        $receiverType   = $request->input('receiver_type');

        if (!empty($message)) {
            $messageId = DB::table('messages')->insertGetId([
                'sender_id'       => $userId,
                'sender_type'     => $role,
                'receiver_id'     => $receiverId,
                'receiver_type'   => $receiverType,
                'consultation_id' => $consultationId,
                'message'         => $message,
                'created_at'      => now(),
            ]);

            // Send via Pusher for real-time
            try {
                $pusher = new \Pusher\Pusher(
                    config('broadcasting.connections.pusher.secret'),
                    config('broadcasting.connections.pusher.secret'),
                    config('broadcasting.connections.pusher.app_id'),
                    [
                        'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                        'useTLS'  => true,
                    ]
                );

                $pusher->trigger('chat-' . $consultationId, 'new-message', [
                    'id'          => $messageId,
                    'sender_id'   => $userId,
                    'sender_type' => $role,
                    'sender_name' => $senderName,
                    'message'     => $message,
                    'created_at'  => now()->format('M d, h:i A'),
                ]);
            } catch (\Exception $e) {
                // Pusher failed — message still saved to DB
            }

            // Create notification
            DB::table('notifications')->insert([
                'user_id'    => $receiverId,
                'user_type'  => $receiverType,
                'title'      => 'New Message from ' . $senderName,
                'message'    => substr($message, 0, 100),
                'created_at' => now(),
            ]);
        }

        return redirect('http://localhost/justifind/public/messages/' . $consultationId);
    }

    public function getMessages(Request $request, $consultationId) {
        // API endpoint for real-time polling
        $messages = DB::select("SELECT * FROM messages
            WHERE consultation_id = ?
            ORDER BY created_at ASC", [$consultationId]);

        return response()->json($messages);
    }
}