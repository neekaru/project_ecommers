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

        // Find by provider_id and provider_name
        $customer = Customer::where('provider_id', $socialUser->getId())
            ->where('provider_name', $provider)
            ->first();

        if (!$customer) {
            // If not found, try by email
            $customer = Customer::where('email', $socialUser->getEmail())->first();

            if ($customer) {
                // Update provider info if email exists
                $customer->update([
                    'provider_id' => $socialUser->getId(),
                    'provider_name' => $provider,
                    'avatar' => $socialUser->getAvatar(),
                ]);
            } else {
                // Create new user if neither exists
                $customer = Customer::create([
                    'nama' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'telepon' => null,
                    'alamat' => null,
                    'provider_id' => $socialUser->getId(),
                    'provider_name' => $provider,
                    'avatar' => $socialUser->getAvatar(),
                ]);
            }
        }

        Auth::guard('customer')->login($customer);

        return redirect('/');
    }
}
