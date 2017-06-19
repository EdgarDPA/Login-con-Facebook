<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Socialite; 
use Auth; 

class FacebookController extends Controller
{
    public function redirectToProvider()
    {
        //return Socialite::driver('facebook')->redirect();
        /*return Socialite::driver('facebook')->fields([
            'first_name', 'last_name', 'email', 'gender', 'birthday'
        ])->scopes([
            'email', 'user_birthday'
        ])->redirect();*/
        return Socialite::driver('facebook')
            ->setScopes(['email', 'public_profile','user_friends'])->redirect();

    }

    public function handleProviderCallback(Request $request)
    {
        
        $facebook_user = Socialite::driver('facebook')->fields([
            'first_name', 'last_name', 'email', 'gender', 'birthday','about','location'
        ])->scopes(['email', 'public_profile','user_friends'])->user();
        

        dd($facebook_user);

/*
    }try
        {
           $socialUser = Socialite::driver('facebook')->fields([
            'first_name', 'last_name', 'email', 'gender', 'birthday','about','location'
        ])->scopes(['email', 'public_profile','user_friends'])->user();
        }
        catch (\Exception $e)
        {
            return redirect('/');
        }

        $user = User::where('facebook_id',$socialUser->getId())->first();
        if(!$user)
            User::create([
               'facebook_id' => $socialUser->getId(),
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),

            ]);

        auth()->login($user);

        return redirect()->to('/home');





        return $user->getEmail();
        */
    }
}
