<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // $credentialsString = env('ADMIN_CREDENTIALS', '');
        $credentialsString = config('services.admin_credentials', '');

        $credentials = explode(',', $credentialsString);

        foreach ($credentials as $credential) {

            $credential = trim($credential);

            if (empty($credential) || !str_contains($credential, ':')) {
                continue;
            }

            [$envEmail, $envPassword] = explode(':', $credential, 2);

            $envEmail = trim($envEmail);
            $envPassword = trim($envPassword);

            if (
                trim($request->email) === $envEmail &&
                trim($request->password) === $envPassword
            ) {

                session([
                    'admin_logged_in' => true,
                    'admin_email' => $envEmail,
                    'admin_username' => 'Admin',
                ]);

                return redirect()->route('dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }

    public function logout()
    {
        session()->flush();

        return redirect()->route('login');
    }
}