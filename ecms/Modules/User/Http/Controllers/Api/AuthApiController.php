<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\User\Exceptions\InvalidOrExpiredResetCode;
use Modules\User\Exceptions\UserNotFoundException;
use Modules\User\Http\Requests\LoginRequest;
use Modules\User\Http\Requests\RegisterRequest;
use Modules\User\Http\Requests\ResetCompleteRequest;
use Modules\User\Http\Requests\ResetRequest;
use Modules\User\Services\UserRegistration;
use Modules\User\Services\UserResetter;
use Modules\User\Transformers\UserLoginTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\Parser;


class AuthApiController extends BaseApiController
{
    use DispatchesJobs;

    public function __construct()
    {
        parent::__construct();
    }

    public function login(Request $request)
    {
        try {
            $credentials = [ //Get credentials
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ];
            $this->validateRequestApi(new LoginRequest($credentials));
            $user = auth()->attempt($credentials);
            if (!$user) {
                throw new \Exception('User or Password invalid', 401);
            }
            $token = $this->getToken($user);
            $response=[
                'userData'=> new UserLoginTransformer($user),
                'userToken' =>  'Bearer ' . $token->accessToken,
                'expiresIn' => $token->token->expires_at,
            ];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);

    }

    public function reset(ResetRequest $request)
    {
        try {

            app(UserResetter::class)->startReset($request->all());

            $response = ['data' => [
                'msj' => trans('user::messages.check email to reset password')
            ]];

        } catch (UserNotFoundException $ex) {
            $status = $this->getStatusError($ex->getCode());
            $response = ["errors" => trans('user::messages.no user found')];
        } catch (\Exception $e) {
            \Log::error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
    }

    /**
     * Logout Api Controller
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        try {
            $token = $this->validateResponseApi($this->getRequestToken($request));//Get Token
            DB::table('oauth_access_tokens')->where('id', $token->id)->delete();//Delete Token
        } catch (Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "You have been successfully logged out!"], $status ?? 200);
    }


    public function resetComplete($userId, $code, ResetCompleteRequest $request)
    {
        try {
            app(UserResetter::class)->finishReset(
                array_merge($request->all(), ['userId' => $userId, 'code' => $code])
            );
        } catch (UserNotFoundException $e) {
            return redirect()->back()->withInput()
                ->withError(trans('user::messages.user no longer exists'));
        } catch (InvalidOrExpiredResetCode $e) {
            return redirect()->back()->withInput()
                ->withError(trans('user::messages.invalid reset code'));
        }

        return redirect()->route('login')
            ->withSuccess(trans('user::messages.password reset'));
    }



    /**
     * @param $request
     * @return mixed
     */
    private function getRequestToken($request)
    {
        try {
            $value = $request->bearerToken();//Get from request

            if ($value) {
                $id = (new Parser())->parse($value)->getHeader('jti');//Decode and get ID
                $token = \DB::table('oauth_access_tokens')->where('id', $id)->first();//Find data Token
                $success = true;//Default state

                //Validate if exist token
                if (!isset($token)) $success = false;

                //Validate if is revoked
                if (isset($token) && (int)$token->revoked >= 1) $success = false;

                //Validate if Token expirated
                if (isset($token) && (strtotime(now()) >= strtotime($token->expires_at))) $success = false;

                //Revoke Token if is invalid
                if (!$success) {
                    if (isset($token)) $token->delete();//Delete token
                    throw new Exception('Unauthorized', 401);//Throw unautorize
                }

                $response = ['data' => $token];//Response Token ID decode
                \DB::commit();//Commit to DataBase
            } else throw new Exception('Unauthorized', 401);//Throw unautorize
        } catch (Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }
    /**
     * @param $user
     * @return bool
     */
    private function getToken($user)
    {
        if (isset($user))
            return $user->createToken('Laravel Password Grant Client');
        else return false;
    }
}
