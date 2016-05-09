<?php
namespace App\Http\Controllers;

use App\User;
use Dingo\Api\Exception\ValidationHttpException;
use Dingo\Api\Routing\Helpers;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Validator;
use Illuminate\Http\Request;
use Config;

/**
 * Class AuthenticateController
 */
class AuthenticateController extends Controller
{
    use Helpers;

    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function login(Request $request){
        $credentials = $request->only(['email', 'password']);
        $this->validateLoginCredentials($credentials);
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->response->errorUnauthorized();
            }
        } catch (JWTException $e) {
            return $this->response->error('could_not_create_token', 500);
        }
        return response()->json(compact('token'));
    }

    public function validateLoginCredentials($credentials){
        $validator = Validator::make($credentials, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }
    }

    public function signup(Request $request){
        $userData = $request->only(Config::get('authconf.signup_fields'));
        $userData['password'] = bcrypt($userData['password']);
        $this->validateSignUpFields($userData);
        $hasToReleaseToken = Config::get('authconf.signup_token_release');

        User::unguard();
        $user = User::create($userData);
        User::reguard();

        if(!$user->id) {
            return $this->response->error('could_not_create_user', 500);
        }
        if($hasToReleaseToken){
            return $this->login($request);
        }

        return $this->response->created();
    }



    public function validateSignUpFields($userData){
        $rules = Config::get('authconf.signup_fields_rules');
        $validator = Validator::make($userData, $rules);
        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }
}