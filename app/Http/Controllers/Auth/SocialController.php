<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Exception;
use App\Http\Controllers\Controller;
use finfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Intervention\Image\Facades\Image as InterImage;

class SocialController extends Controller
{
    protected $providers = [
        'github', 'twitter', 'discord', 'facebook'
    ];

    public function redirectToProvider($driver)
    {
        if( ! $this->isProviderAllowed($driver) ) {
            return $this->sendFailedResponse("$driver is not currently supported");
        }

        try {
            return Socialite::driver($driver)->redirect();
        } catch (Exception $e) {
            // You should show something simple fail message
            return $this->sendFailedResponse($e->getMessage());
        }
    }


    public function handleProviderCallback($driver)
    {
        try {
            $user = Socialite::driver($driver)->user();
        } catch (Exception $e) {
            return redirect()->route('login');
        }

        return empty($user->email)
            ? $this->sendFailedResponse("No email id returned from $driver provider.")
            : $this->loginOrCreateAccount($user, $driver);
    }

    protected function sendFailedResponse($msg = null)
    {
        return redirect()->route('login')
            ->with('error', $msg ?? 'Unable to login, try with another provider to login.');
    }

    protected function loginOrCreateAccount($providerUser, $driver)
    {
        $user = User::where('email', $providerUser->getEmail())->first();

        if ($user) {

            $user->update([
                'provider'              => $driver,
                'provider_id'           => $providerUser->id,
                'provider_access_token' => $providerUser->token
            ]);

        } else {

            $user = User::create([
                'name'                  => $providerUser->getNickname() ?? $providerUser->getName(),
                'email'                 => $providerUser->getEmail(),
                'avatar'                => $providerUser->getAvatar(),
                'provider'              => $driver,
                'provider_id'           => $providerUser->getId(),
                'provider_access_token' => $providerUser->token,

                // user can use reset password to create a password
                'password'              => ''
            ]);

            $user->avatar = $this->avatar($user, $providerUser->getAvatar());
            $user->save();
        }

        // login the user
        Auth::login($user, true);

        return redirect()->intended(route('home'))
            ->with('success', 'You have been successfully log in.');
    }

    public function setUserPassword(Request $request)
    {
        $request->validate([
            'password'              => ['required', 'string', 'min:8'],
            'password_confirmation' => ['same:password'],
        ]);

        $user = User::find($request->user()->id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user, true);

        return redirect()
            ->back()
            ->with('success', 'You have successfully set your password!');
    }

    private function isProviderAllowed($driver): bool
    {
        return in_array($driver, $this->providers) && config()->has("services.$driver");
    }

    private function avatar(User $user, string $avatarUrl)
    {
        $avatarContents = file_get_contents($avatarUrl);
        $avatarExtension = str_replace('image/', '', $this->getMimeType($avatarContents, 'str'));
        $avatarName = 'avatars/'.strtolower(Str::random(6).'-'.$user->id).".$avatarExtension";

        Storage::disk('public')->put($avatarName, $avatarContents);

        return $avatarName;
    }

    private function getMimeType($r, $t = 'file') {
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        return ($t =='str') ? $finfo->buffer($r) : $finfo->file($r);
    }
}
