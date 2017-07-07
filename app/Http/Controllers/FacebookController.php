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
        return Socialite::driver('facebook')
            ->setScopes(['email', 'public_profile','user_friends'])->redirect();

    }

    public function handleProviderCallback(Request $request)
    {

        // conecion al token de  Facebook 
        $facebook_user = Socialite::driver('facebook')->fields([
            'name', 'email', 'gender', 'birthday','about','location'
        ])->scopes(['email', 'public_profile','user_friends'])->user();
        //busca si esiste el usuario en la base 
        $user = User::where('facebook_id',$facebook_user->getId())->first();
        if(!$user)//si no esta, lo crea en la bd
        {
            User::create([
               'facebook_id' => $facebook_user->getId(),
                'name' => $facebook_user->getName(),
                'email' => $facebook_user->getEmail(),
            ]);

            auth()->login($facebook_user);
            /* aQUI TRATO QUE ME SALGA LA PANTALLA CON EL NUEVO 
            USUARIO CREADO PERO NO SALE XD XD XD */
        }
       else auth()->login($user);//selecciona la informacion del usuario 
       
        return redirect()->route('/home');
    }
}