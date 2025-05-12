<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\clients\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        $url = Socialite::driver('google')->redirect()->getTargetUrl();
        return response()->json(['url' => $url]);
    }
    public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->user();

        // Vérifier si l'utilisateur existe avec ce google_id
        $user = User::where('google_id', $googleUser->id)->first();

        // Si non, vérifier si l'utilisateur existe avec cet email
        if (!$user) {
            $user = User::where('email', $googleUser->email)->first();

            // Si l'utilisateur existe, mettre à jour son google_id
            if ($user) {
                $user->update([
                    'google_id' => $googleUser->id,
                ]);
            } else {
                // Créer un nouvel utilisateur
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(Str::random(24)),
                ]);
            }
        }

        // Générer un token Passport comme dans votre login traditionnel
        $token = $user->createToken('UserToken')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);

    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}
public function loginWithToken(Request $request)
{
    try {
        $request->validate([
            'access_token' => 'required|string',
        ]);

        // Obtenir les informations de l'utilisateur à partir du token Google
        $googleUser = Socialite::driver('google')($request->access_token);

        // Vérifier si l'utilisateur existe avec ce google_id
        $user = User::where('google_id', $googleUser->id)->first();

        // Si non, vérifier si l'utilisateur existe avec cet email
        if (!$user) {
            $user = User::where('email', $googleUser->email)->first();

            // Si l'utilisateur existe, mettre à jour son google_id
            if ($user) {
                $user->update([
                    'google_id' => $googleUser->id,
                ]);
            } else {
                // Créer un nouvel utilisateur
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(Str::random(24)),
                ]);
            }
        }

        // Générer un token Passport comme dans votre login traditionnel
        $token = $user->createToken('UserToken')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);

    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}
}
