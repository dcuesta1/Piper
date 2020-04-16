<?php


namespace App\Http\Controllers\Api\V1\Auth;

use App\Bin\Auth\AuthFacade as Auth;
use App\Exceptions\BadInputException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CheckPasswordRecoverCodeController extends Controller
{
    public function __invoke(Request $req)
    {
        if ( !$user = Auth::getUserbyPasswordResetCode($req->only('code')) ) {
            throw new BadInputException('Invalid code');
        }

        return response($user);
    }
}
