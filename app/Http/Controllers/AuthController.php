<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {

    public function showRegister() {
        return view('auth.register');
    }

    public function showForgotPassword() {
        return view('auth.forgot-password');
    }

    public function resetPassword(Request $request) {
        $email        = trim($request->input('email', ''));
        $phone        = trim($request->input('phone', ''));
        $newPassword  = trim($request->input('new_password', ''));
        $confirm      = trim($request->input('confirm_password', ''));

        if (empty($email) || empty($phone) || empty($newPassword)) {
            return redirect('http://localhost/justifind/public/forgot-password')
                ->with('reset_error', 'All fields are required.');
        }

        if ($newPassword !== $confirm) {
            return redirect('http://localhost/justifind/public/forgot-password')
                ->with('reset_error', 'Passwords do not match.');
        }

        if (strlen($newPassword) < 6) {
            return redirect('http://localhost/justifind/public/forgot-password')
                ->with('reset_error', 'Password must be at least 6 characters.');
        }

        $hashedPassword = Hash::make($newPassword);

        if (str_ends_with($email, '@Client.com')) {
            $user = DB::table('Client')->where('Email', $email)->first();
            if (!$user) {
                return redirect('http://localhost/justifind/public/forgot-password')
                    ->with('reset_error', 'No account found with that email.');
            }
            if ($user->Phone != $phone) {
                return redirect('http://localhost/justifind/public/forgot-password')
                    ->with('reset_error', 'Phone number does not match our records.');
            }
            DB::table('Client')->where('Email', $email)
                ->update(['Password' => $hashedPassword]);

        } elseif (str_ends_with($email, '@Law.co')) {
            $user = DB::table('Lawyer')->where('Email', $email)->first();
            if (!$user) {
                return redirect('http://localhost/justifind/public/forgot-password')
                    ->with('reset_error', 'No account found with that email.');
            }
            if ($user->Phone != $phone) {
                return redirect('http://localhost/justifind/public/forgot-password')
                    ->with('reset_error', 'Phone number does not match our records.');
            }
            DB::table('Lawyer')->where('Email', $email)
                ->update(['Password' => $hashedPassword]);

        } else {
            return redirect('http://localhost/justifind/public/forgot-password')
                ->with('reset_error', 'Invalid email domain. Only Client and Lawyer accounts can reset password.');
        }

        return redirect('http://localhost/justifind/public')
            ->with('message', 'Password reset successfully! You can now sign in with your new password.');
    }

    public function register(Request $request) {
        $name     = trim($request->input('name', ''));
        $email    = trim($request->input('email', ''));
        $password = trim($request->input('password', ''));
        $confirm  = trim($request->input('password_confirm', ''));
        $role     = $request->input('role', 'Client');

        if (empty($name) || empty($email) || empty($password)) {
            return redirect('http://localhost/justifind/public/register')
                ->with('reg_error', 'All fields are required.');
        }

        if ($password !== $confirm) {
            return redirect('http://localhost/justifind/public/register')
                ->with('reg_error', 'Passwords do not match.');
        }

        if (strlen($password) < 6) {
            return redirect('http://localhost/justifind/public/register')
                ->with('reg_error', 'Password must be at least 6 characters.');
        }

        $hashedPassword = Hash::make($password);

        if ($role == 'Client') {
            if (!str_ends_with($email, '@Client.com')) {
                return redirect('http://localhost/justifind/public/register')
                    ->with('reg_error', 'Client email must end with @Client.com');
            }
            $exists = DB::table('Client')->where('Email', $email)->first();
            if ($exists) {
                return redirect('http://localhost/justifind/public/register')
                    ->with('reg_error', 'Email already registered.');
            }
            $clientId = DB::table('Client')->insertGetId([
                'Name'     => $name,
                'Email'    => $email,
                'Password' => $hashedPassword,
                'Phone'    => $request->input('phone', ''),
                'Address'  => $request->input('address', ''),
                'Age'      => (int)$request->input('age', 0),
                'Gender'   => $request->input('gender', ''),
            ]);

            $request->session()->put('role', 'Client');
            $request->session()->put('email', $email);
            $request->session()->put('client_id', $clientId);
            $request->session()->put('client_name', $name);
            return redirect('http://localhost/justifind/public')
                ->with('message', 'Welcome to JustiFind, ' . $name . '! 🎉');

        } elseif ($role == 'Lawyer') {
            if (!str_ends_with($email, '@Law.co')) {
                return redirect('http://localhost/justifind/public/register')
                    ->with('reg_error', 'Lawyer email must end with @Law.co');
            }
            $exists = DB::table('Lawyer')->where('Email', $email)->first();
            if ($exists) {
                return redirect('http://localhost/justifind/public/register')
                    ->with('reg_error', 'Email already registered.');
            }
            $lawyerId = DB::table('Lawyer')->insertGetId([
                'Name'         => $name,
                'Email'        => $email,
                'Password'     => $hashedPassword,
                'Phone'        => $request->input('phone', ''),
                'Experience'   => (int)$request->input('experience', 0),
                'Profile'      => $request->input('profile', 'New lawyer on JustiFind.'),
                'Hourly_Rate'  => (float)$request->input('hourly_rate', 1000),
                'Success_Rate' => 0.00,
            ]);

            DB::table('lawyer_verification')->insert([
                'lawyer_id'   => $lawyerId,
                'is_verified' => false,
            ]);

            $request->session()->put('role', 'Lawyer');
            $request->session()->put('email', $email);
            $request->session()->put('lawyer_id', $lawyerId);
            $request->session()->put('lawyer_name', $name);
            return redirect('http://localhost/justifind/public/lawyer-dashboard')
                ->with('message', 'Welcome to JustiFind, ' . $name . '! 🎉');
        }

        return redirect('http://localhost/justifind/public/register')
            ->with('reg_error', 'Invalid role selected.');
    }

    public function login(Request $request) {
        $email    = trim($request->input('login_email', ''));
        $password = trim($request->input('login_pass', ''));

        if (empty($email) || empty($password)) {
            return redirect('http://localhost/justifind/public')
                ->with('error', 'Email and password are required.');
        }

        if (str_ends_with($email, '@Admin.com')) {
            $admin = DB::table('Admin')->where('Email', $email)->first();
            if (!$admin) {
                return redirect('http://localhost/justifind/public')
                    ->with('error', 'Admin account not found.');
            }
            if (isset($admin->Password) && !empty($admin->Password)) {
                if (!Hash::check($password, $admin->Password)) {
                    return redirect('http://localhost/justifind/public')
                        ->with('error', 'Invalid password. Please try again.');
                }
            }
            $request->session()->put('role', 'Admin');
            $request->session()->put('email', $email);
            $request->session()->put('admin_id', $admin->AID);
            $request->session()->put('admin_name', $admin->Name);
            return redirect('http://localhost/justifind/public');

        } elseif (str_ends_with($email, '@Client.com')) {
            $client = DB::table('Client')->where('Email', $email)->first();
            if (!$client) {
                return redirect('http://localhost/justifind/public')
                    ->with('error', 'No client account found with that email.');
            }
            if (empty($client->Password)) {
                return redirect('http://localhost/justifind/public')
                    ->with('error', 'Account has no password set. Please register again or contact support.');
            }
            if (!Hash::check($password, $client->Password)) {
                return redirect('http://localhost/justifind/public')
                    ->with('error', 'Invalid password. Please try again.');
            }
            $request->session()->put('role', 'Client');
            $request->session()->put('email', $email);
            $request->session()->put('client_id', $client->CID);
            $request->session()->put('client_name', $client->Name);
            return redirect('http://localhost/justifind/public');

        } elseif (str_ends_with($email, '@Law.co')) {
            $lawyer = DB::table('Lawyer')->where('Email', $email)->first();
            if (!$lawyer) {
                return redirect('http://localhost/justifind/public')
                    ->with('error', 'No lawyer account found with that email.');
            }
            if (empty($lawyer->Password)) {
                return redirect('http://localhost/justifind/public')
                    ->with('error', 'Account has no password set. Please register again or contact support.');
            }
            if (!Hash::check($password, $lawyer->Password)) {
                return redirect('http://localhost/justifind/public')
                    ->with('error', 'Invalid password. Please try again.');
            }
            $request->session()->put('role', 'Lawyer');
            $request->session()->put('email', $email);
            $request->session()->put('lawyer_id', $lawyer->LID);
            $request->session()->put('lawyer_name', $lawyer->Name);
            return redirect('http://localhost/justifind/public');

        } else {
            return redirect('http://localhost/justifind/public')
                ->with('error', 'Invalid email domain. Use @Client.com, @Law.co or @Admin.com');
        }
    }

    public function logout(Request $request) {
        $request->session()->flush();
        return redirect('http://localhost/justifind/public');
    }
}