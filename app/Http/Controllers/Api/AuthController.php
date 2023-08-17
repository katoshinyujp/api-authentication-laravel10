<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\AuthenticationException;
use App\Http\Requests\CreateUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUser;
use App\Http\Requests\ResetPassword;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends ApiController
{
    /**
     * register User
     * @param Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function register(CreateUser $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        event(new Registered($user));
        return $this->success(null, ['token' => $user->createToken("API TOKEN")->plainTextToken]);
    }

    /**
     * Login The User
     * @param LoginUser $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function login(LoginUser $request)
    {
        if(!Auth::attempt($request->only(['email', 'password']))) {
            throw new AuthenticationException();
        }

        $user = User::where('email', $request->email)->first();
        return $this->success($user->attributesToArray(), ['token' => $user->createToken("API TOKEN")->plainTextToken]);
    }

    /**
     * logout
     * @param Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function logout(Request $request) {
		$request->user()->currentAccessToken()->delete();
		//$request->user->tokens()->delete(); // use this to revoke all tokens (logout from all devices)
        return $this->success();
	}

    public function sendPasswordResetLinkEmail(Request $request) {
		$request->validate(['email' => 'required|email']);

		$status = Password::sendResetLink(
			$request->only('email')
		);
        
		if($status === Password::RESET_LINK_SENT) {
            return $this->success();
		} else {
			return $this->errors();
		}
	}

	public function resetPassword(ResetPassword $request) {
		$status = Password::reset(
			$request->only('email', 'password', 'password_confirmation', 'token'),
			function ($user, $password) use ($request) {
				$user->forceFill([
					'password' => Hash::make($password)
				])->setRememberToken(Str::random(60));

				$user->save();
				event(new PasswordReset($user));
			}
		);

		if($status == Password::PASSWORD_RESET) {
            return $this->success();
		} else {
			return $this->errors();
		}
	}

    /**
     * verify
     * @param EmailVerificationRequest $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function verify(EmailVerificationRequest $request) {
        $request->fulfill();
        return $this->success();
    }

    /**
     * verify
     * @param Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function verificationSend(Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return $this->success();
    }
}