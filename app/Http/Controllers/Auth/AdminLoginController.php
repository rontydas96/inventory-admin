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

        $credentials = explode(',', env('ADMIN_CREDENTIALS'));

        // foreach ($credentials as $credential) {
        //     [$envEmail, $envPassword] = explode(':', $credential);

        //     if (
        //         trim($request->email) === trim($envEmail) &&
        //         $request->password === trim($envPassword)
        //     ) {
        foreach ($credentials as $credential) {

            $credential = trim($credential);

            if (empty($credential) || !str_contains($credential, ':')) {
                continue;
            }

            [$envEmail, $envPassword] = explode(':', $credential, 2);

            if (
                trim($request->email) === trim($envEmail) &&
                trim($request->password) === trim($envPassword)
            ) {
                session([
                    'admin_logged_in' => true,
                    'admin_email' => $request->email,
                    'admin_username' => "Admin",
                ]);

                return redirect()->route('dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}