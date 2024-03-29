<?php

namespace App\Http\Controllers;

use Crypt;
use Google2FA;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use \ParagonIE\ConstantTime\Base32;

class Google2FAController extends Controller
{
    use ValidatesRequests;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function enableTwoFactor(Request $request)
    {
        //generate new secret
        $secret = $this->generateSecret();

        //get user
        $user = $request->user();
        $user = $user->makeVisible('password');
        // dd($request->all());

        //encrypt and then save secret
        $user->google2fa_secret = Crypt::encrypt($secret);
        $user->save();

        //generate image for QR barcode
        $imageDataUri = Google2FA::getQRCodeInline(
            $request->getHttpHost(),
            $user->email,
            $secret,
            200
        );
        // Auth::logoutOtherDevices('password');
        return view('2fa/enableTwoFactor', ['image' => $imageDataUri,
            'secret' => $secret]);
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function disableTwoFactor(Request $request)
    {
        $user = $request->user();

        //make secret column blank
        $user->google2fa_secret = null;
        $user->save();

        return view('2fa/disableTwoFactor');
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function disable_2fa($id)
    {
        $user = User::find($id);

        //make secret column blank
        $user->google2fa_secret = null;
        $user->save();
        return $user;
    }

    /**
     * Generate a secret key in Base32 format
     *
     * @return string
     */
    private function generateSecret()
    {
        $randomBytes = random_bytes(10);

        return Base32::encodeUpper($randomBytes);
    }
}
