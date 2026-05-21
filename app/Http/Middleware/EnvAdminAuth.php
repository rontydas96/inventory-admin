<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnvAdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        $email = $request->email;
        $password = $request->password;

        $credentials = explode(',', env('ADMIN_CREDENTIALS'));

        foreach ($credentials as $credential) {
            [$envEmail, $envPassword] = explode(':', $credential);

            if ($email === $envEmail && $password === $envPassword) {
                session([
                    'admin_logged_in' => true,
                    'admin_email' => $email,
                ]);

                return redirect('/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }
}
