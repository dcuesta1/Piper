<?php


namespace App\Http\Controllers\Api\V1\Auth;


use App\{AuthToken, User};
use App\Bin\Auth\AuthFacade as Auth;
use App\Exceptions\UnauthorizedAccessException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(Request $req)
    {
        $clientId = $req->has('refresh') ? $req->input('refresh') : null;

        $credentials = $req->only(['username', 'password']);
        if (!Auth::checkCredentials($credentials)) {
            throw new UnauthorizedAccessException('Invalid login credentials.');
        }

        $token = Auth::createToken($clientId);
        //TODO: enhance user model before response
        return response(Auth::user())
            ->withHeaders([
                'token' => $token->value,
                'refresh' => $token->client_id
            ]);
    }
}
