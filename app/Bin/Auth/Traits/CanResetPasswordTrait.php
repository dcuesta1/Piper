<?php


namespace App\Bin\Auth\Traits;

use App\Bin\Auth\User;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Support\Facades\DB;

trait CanResetPasswordTrait
{

    public function getUserByPasswordResetCode(int $code)
    {
        return new User();
    }

    /**
     * Sends an email to the user with a temporary code to reset the user's password.
     */
    public function sendEmailWithCode()
    {
        // TODO: create custom reset password notification email
        $this->notify(new ResetPasswordNotification($this->makeCode()));
    }

    /**
     * Checks if the password reset is found in the database.
     *
     * @param string $code
     * @return bool
     */
    public function validateResetPasswordCode($code = '')
    {
        $code = DB::table('password_reset_codes')
            ->select('code')
            ->where([
                ['code', '=', $code],
                ['email', '=', $this->getEmail()]
            ]);

        return $code ? true : false;
    }

    public function updatePassword($password)
    {
    }

    protected function makeCode()
    {
        return mt_rand(100000, 999999);
    }
}
