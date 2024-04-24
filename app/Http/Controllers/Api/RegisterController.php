<?php
namespace App\Http\Controllers\Api;

use App\Requests\Users\CreateUserValidator;
use App\Requests\Users\LoginUserValidator;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class RegisterController extends BaseController
{
    public UserService $userService;

    public function __construct(UserService $userService){
        $this->userService=$userService;
    }

    public function register(CreateUserValidator $createUserValidator){
        if(!empty($createUserValidator->getErrors())){
            return response()->json($createUserValidator->getErrors(),406);
        }
        $user=$this->userService->createUser($createUserValidator->request()->all());
        $message['user']=$user;
        $message['token'] =  $user->createToken('MyApp')->plainTextToken;
        return $this->sendResponse($message);
    }

    public function login(LoginUserValidator $loginUserValidator){
        if(!empty($loginUserValidator->getErrors())){
            return response()->json($loginUserValidator->getErrors(),406);
        }
        $request=$loginUserValidator->request();
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success);
        }
        else{
            return $this->sendResponse('Unauthorised', 'fail',401);
        }
    }
}
