<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Lcobucci\JWT\Encoding\JoseEncoder;
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
use Lcobucci\JWT\Token\Parser;
use Modules\User\Repositories\UserRepository;
use Exception;


class AuthApiController extends BaseApiController
{
    use DispatchesJobs;

    private $user;

    public function __construct(UserRepository $user)
    {
        parent::__construct();
        $this->user = $user;
        $this->clearTokens();//CLear tokens

    }

    public function login(Request $request)
    {
        try {
            $credentials = [ //Get credentials
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ];

            $user = auth()->attempt($credentials);
            if (!$user) {
                throw new \Exception('User or Password invalid', 401);
            }
            $token = $this->getToken($user);
            $response = [
                'userData' => new UserLoginTransformer($user),
                'userToken' => 'Bearer ' . $token->accessToken,
                'expiresIn' => $token->token->expires_at,
            ];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);

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


    public function register(Request $request)
    {
        try {
            $data = $request->input('attributes') ?? [];//Get data

            $this->validateRequestApi(new RegisterRequest($data));

            app(UserRegistration::class)->register($data);
            $response = ["data" => ['msg' => trans('user::messages.account created check email for activation'), 'email' => $data['email']]];
        } catch (\Exception $e) {
            \Log::error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

//Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }


    public function reset(Request $request)
    {
        try {

            $data = $request->input('attributes') ?? [];//Get data
            $this->validateRequestApi(new ResetRequest($data));
            app(UserResetter::class)->startReset($data);

            $response = ['data' => [
                'msj' => trans('user::messages.check email to reset password')
            ]];
        } catch (UserNotFoundException $ex) {
            $status = $this->getStatusError($ex->getCode());
            $response = ["errors" => trans('user::messages.no user found')];
        } catch (Exception $e) {
            \Log::error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }


    public function resetComplete(Request $request)
    {
        try {
            $credentials = [ //Get credentials
                'password' => $request->input('password'),
                'password_confirmation' => $request->input('passwordConfirmation'),
                'userId' => $request->input('userId'),
                'code' => $request->input('token')
            ];
            $this->validateRequestApi(new ResetCompleteRequest($credentials));
            app(UserResetter::class)->finishReset($credentials);

            $user = $this->user->find($request->input('userId'));

            $response = ["data" => ['email' => $user->email]];//Response

        } catch (UserNotFoundException $e) {
            \Log::error($e->getMessage());
            $status = $this->getStatusError(404);
            $response = ["errors" => trans('user::messages.no user found')];

        } catch (InvalidOrExpiredResetCode $e) {
            $status = $this->getStatusError(402);
            $response = ["errors" => trans('user::messages.invalid reset code')];
        } catch (Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
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

                $tokenId = (new Parser(new JoseEncoder()))->parse($value)->claims()
                    ->all()['jti'];
                $token = \DB::table('oauth_access_tokens')->where('id', $tokenId)->first();//Find data Token

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
                DB::commit();//Commit to DataBase
            } else throw new Exception('Unauthorized', 401);//Throw unautorize
        } catch (Exception $e) {
            \Log::error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }


    /**
     * Provate method Clear Tokens
     */
    private function clearTokens()
    {
        //Delete all tokens expirateds or revoked
        DB::table('oauth_access_tokens')->where('expires_at', '<=', now())
            ->orWhere('revoked', 1)
            ->delete();
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
