<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    
    $request->session()->regenerate();

    // Get the authenticated user
    $user = Auth::user();
    if (!$user->email_verified_at) {
        // If not verified, send them to the verify-email route
        return redirect()->route('verification.notice');
    }

    switch($user->role){
        case 'admin':
            // Redirect admins to admin dashboard
            return redirect()->route('dashboard');
        case 'renter':
            // Redirect customers to customer dashboard
            return redirect()->route('renters.home');    
        case 'reserve':
            // Redirect customers to customer dashboard
            return redirect()->route('reserve.wait'); 
        case 'pending':
            // Redirect customers to customer dashboard
            return redirect()->route('reserve.wait'); 
        default:
            return redirect()->route('welcome');
        }

    
    // else {
    //     // Redirect others to default home route
    //     return redirect()->intended(RouteServiceProvider::HOME);
    // }
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
