<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    public function showSetup()
    {
        $user = Auth::user();
        $google2fa = new Google2FA();
        
        if (!$user->two_factor_secret) {
            $secret = $google2fa->generateSecretKey();
            $user->two_factor_secret = $secret;
            $user->save();
        }
        
        $qrCode = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $user->two_factor_secret
        );
        
        return view('auth.two-factor-setup', compact('qrCode'));
    }
    
    public function enable(Request $request)
    {
        $user = Auth::user();
        $user->two_factor_enabled = true;
        $user->save();
        
        return redirect()->route('dashboard')->with('success', '2FA berhasil diaktifkan!');
    }
    
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6'
        ]);
        
        $user = Auth::user();
        $google2fa = new Google2FA();
        
        $valid = $google2fa->verifyKey($user->two_factor_secret, $request->code);
        
        if ($valid) {
            session(['2fa_verified' => true]);
            return redirect()->intended('/dashboard');
        }
        
        return back()->withErrors(['code' => 'Kode 2FA tidak valid']);
    }
    
    public function showVerify()
    {
        return view('auth.two-factor-verify');
    }
}
