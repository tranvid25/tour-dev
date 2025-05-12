<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\clients\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
        return response()->json(['url' => $url]);
    }
    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $finduser = User::where('email', $user->getEmail())->first();

            if ($finduser) {
                session([
                    'user' => [
                        'id' => $finduser->userId,
                        'name' => $finduser->userName,
                        'email' => $finduser->email
                    ]
                ]);
            } else {
                $newUser = User::create([
                    'userName' => $user->getName(),
                    'email' => $user->getEmail(),
                    'facebook_id'=> $user->getId(),
                    'passWord' => encrypt('12345678'),
                    'status' => 1,
                    'level' => 0
                ]);
                session([
                    'user' => [
                        'id' => $newUser->userId,
                        'name' => $newUser->userName,
                        'email' => $newUser->email
                    ]
                ]);


                return redirect()->intended('home');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

}
// <?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// u
// class GoogleController extends Controller
// {
//     /**
//      * Rediriger l'utilisateur vers Google pour l'authentification
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function redirectToGoogle()
//     {
//         $url = Socialite::driver('google')->redirect()->getTargetUrl();
//         return response()->json(['url' => $url]);
//     }

//     /**
//      * Obtenir les informations utilisateur de Google après l'authentification
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function handleGoogleCallback()
//     {
//         try {
//             $googleUser = Socialite::driver('google')->user();

//             // Vérifier si l'utilisateur existe avec ce google_id
//             $user = User::where('google_id', $googleUser->id)->first();

//             // Si non, vérifier si l'utilisateur existe avec cet email
//             if (!$user) {
//                 $user = User::where('email', $googleUser->email)->first();

//                 // Si l'utilisateur existe, mettre à jour son google_id
//                 if ($user) {
//                     $user->update([
//                         'google_id' => $googleUser->id,
//                     ]);
//                 } else {
//                     // Créer un nouvel utilisateur
//                     $user = User::create([
//                         'name' => $googleUser->name,
//                         'email' => $googleUser->email,
//                         'google_id' => $googleUser->id,
//                         'password' => Hash::make(Str::random(24)),
//                     ]);
//                 }
//             }

//             // Générer un token Passport comme dans votre login traditionnel
//             $token = $user->createToken('UserToken')->accessToken;

//             return response()->json([
//                 'token' => $token,
//                 'user' => $user,
//             ]);

//         } catch (\Exception $e) {
//             return response()->json(['message' => $e->getMessage()], 500);
//         }
//     }

//     /**
//      * Connexion avec un token Google (pour les applications mobiles/SPA)
//      *
//      * @param Request $request
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function loginWithToken(Request $request)
//     {
//         try {
//             $request->validate([
//                 'access_token' => 'required|string',
//             ]);

//             // Obtenir les informations de l'utilisateur à partir du token Google
//             $googleUser = Socialite::driver('google')->userFromToken($request->access_token);

//             // Vérifier si l'utilisateur existe avec ce google_id
//             $user = User::where('google_id', $googleUser->id)->first();

//             // Si non, vérifier si l'utilisateur existe avec cet email
//             if (!$user) {
//                 $user = User::where('email', $googleUser->email)->first();

//                 // Si l'utilisateur existe, mettre à jour son google_id
//                 if ($user) {
//                     $user->update([
//                         'google_id' => $googleUser->id,
//                     ]);
//                 } else {
//                     // Créer un nouvel utilisateur
//                     $user = User::create([
//                         'name' => $googleUser->name,
//                         'email' => $googleUser->email,
//                         'google_id' => $googleUser->id,
//                         'password' => Hash::make(Str::random(24)),
//                     ]);
//                 }
//             }

//             // Générer un token Passport comme dans votre login traditionnel
//             $token = $user->createToken('UserToken')->accessToken;

//             return response()->json([
//                 'token' => $token,
//                 'user' => $user,
//             ]);

//         } catch (\Exception $e) {
//             return response()->json(['message' => $e->getMessage()], 500);
//         }
//     }
// }se Illuminate\Support\Facades\Hash;
// use Laravel\Socialite\Facades\Socialite;
// use Illuminate\Support\Str;


