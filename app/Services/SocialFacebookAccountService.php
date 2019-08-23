<?php
namespace App\Services;
use App\SocialFacebookAccount;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;
class SocialFacebookAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        // dd($providerUser);
        $account = User::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if ($account) {
            return $account;
        } else {
            $account = new User([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'password' => md5(rand(0,10000)),
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);
            $account->save();
            return $account;
        }
    }
}