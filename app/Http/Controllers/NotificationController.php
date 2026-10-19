<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller {

    public function index(Request $request) {
        $role = $request->session()->get('role');
        if (!$role) return redirect('/');

        $userId   = $role == 'Client'
            ? $request->session()->get('client_id')
            : ($role == 'Lawyer'
                ? $request->session()->get('lawyer_id')
                : $request->session()->get('admin_id'));

        $notifications = DB::select("SELECT * FROM notifications
            WHERE user_id = ? AND user_type = ?
            ORDER BY created_at DESC LIMIT 50",
            [$userId, $role]);

        // Mark all as read
        DB::table('notifications')
            ->where('user_id', $userId)
            ->where('user_type', $role)
            ->update(['is_read' => true]);

        return view('notifications.index', compact('notifications', 'role'));
    }

    public function markRead(Request $request) {
        $role = $request->session()->get('role');
        if (!$role) return redirect('/');

        $userId = $role == 'Client'
            ? $request->session()->get('client_id')
            : $request->session()->get('lawyer_id');

        DB::table('notifications')
            ->where('user_id', $userId)
            ->where('user_type', $role)
            ->update(['is_read' => true]);

        return redirect()->back();
    }

    public static function create($userId, $userType, $title, $message) {
        DB::table('notifications')->insert([
            'user_id'    => $userId,
            'user_type'  => $userType,
            'title'      => $title,
            'message'    => $message,
            'created_at' => now(),
        ]);
    }
}