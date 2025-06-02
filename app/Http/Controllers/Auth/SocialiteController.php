<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class SocialiteController extends Controller
{   
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    
    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Authentication failed. Please try again.');
        }

        // Check if the user already exists in the database
        $customer = Customer::where('provider_id', $socialUser->getId())
            ->where('provider_name', $provider)
            ->first();

        if (!$customer) {
            $user = Customer::where('email', $socialUser->getEmail())->first();
            if (!$user) {
                // Create a new user if it doesn't exist
                $customer = Customer::create([
                    'nama' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'telepon' => null, // Optional, can be set later
                    'alamat' => null, // Optional, can be set later
                    'provider_id' => $socialUser->getId(),
                    'provider_name' => $provider,
                    'avatar' => $socialUser->getAvatar(),
                ]);
            } else {
                // If user exists but not linked to social provider, update the provider info
                $user->update([
                    'provider_id' => $socialUser->getId(),
                    'provider_name' => $provider,
                    'avatar' => $socialUser->getAvatar(),
                ]);
                $customer = $user;
            }
        }

        Auth::guard('customer')->login($customer);

        return redirect('/');
    }
}
