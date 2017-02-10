<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Models\User\SocialAccount;
use Socialite;

class SocialController extends Controller
{
    /**
     * Redirect the user to the facebook authentication page.
     *
     * @return Response
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from facebook.
     *
     * @return Response
     */
    public function handleFacebookCallback()
    {
        $facebook = Socialite::driver('facebook')->stateless()->user();

        $registered = SocialAccount::with('user')
            ->where('provider', 'facebook')
            ->where('provider_uid', $facebook->getId())
            ->first();

        if ($registered) {
            auth()->login($registered->user);
            return redirect()->to('/');
        }

        $user = User::where('email', $facebook->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $facebook->getName(),
                'email' => $facebook->getEmail(),
                'password' => bcrypt(md5(date(time()).$facebook->getName()))
            ]);
        }

        $new = new SocialAccount;
        $new->user()->associate($user);
        $new->provider = 'facebook';
        $new->provider_uid = $facebook->getId();
        $new->save();

        auth()->login($user);

        return redirect()->to('/');
    }
}
