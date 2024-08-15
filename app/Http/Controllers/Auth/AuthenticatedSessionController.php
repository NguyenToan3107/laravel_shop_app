<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Models\UserProvider;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

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

        return redirect()->intended(RouteServiceProvider::HOME);
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

    /**
     * Login with OAuth2 (Facebook, Google)
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            // Lấy thông tin người dùng từ provider (Google, Facebook, etc.)
            $socialUser = Socialite::driver($provider)->stateless()->user();
            $avatarUrl = $socialUser->getAvatar();

            $avatarContents = Http::get($avatarUrl)->body();

            $filename = '/photos/users/' . $socialUser->getId() . '.jpg';

            Storage::disk('public')->put($filename, $avatarContents);

            $existingUserByProvider_Id = User::where('provider_id', $socialUser->getId())
                ->where('provider', $provider)
                ->first();

            if ($existingUserByProvider_Id) {
                $user = $existingUserByProvider_Id;
            } else {
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'image_path' => '/storage' . $filename,
                    'password' => bcrypt(Str::random(16)),
                    'status' => 1,
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                ]);

                $user->syncRoles(['user']);
            }

            Auth::login($user);

            return redirect()->intended('/');
        } catch (\Exception $exception) {
            return redirect('/login');
        }

    }
}
