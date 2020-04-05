<?php


namespace App\Http\Controllers\Api\V1\Auth;


use App\AuthToken;
use App\Exceptions\UnauthorizedAccessException;
use App\Http\Controllers\Controller;
use Auth;
use Str;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __invoke(Request $req)
    {
        $credentials = $req->only(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            throw new UnauthorizedAccessException('Invalid login credentials.');
        }

        $token = new AuthToken();
        $token->value = tokenAuth()->hash();
        $token->uuid = Str::uuid();

        $user = Auth::user();
        $user->authTokens()->save($token);

        return response($user)
            ->header('token', $token->value);
    }
}
