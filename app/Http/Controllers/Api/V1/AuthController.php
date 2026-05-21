<?php

namespace App\Http\Controllers\Api\V1;
use App\Models\User ;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash ;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException ;
 use Illuminate\Support\Facades\Auth ;
class AuthController extends Controller
{
    //
//register
    public function register(Request $request) { 

  $request->validate([
             'name' => 'required', 

        'email' => 'required|email|unique:users',

         'password' => 'required|min:6',
         
         ]);
          $user = User::create([
             'name' => $request->name,

           'email' => $request->email, 

           'password' => Hash::make($request->password), 
           ]); 
           $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([ 
                'token' => $token, 
                'user' => $user,
                 ]);
                  }


//login
 public function login(Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['Invalid credentials']
        ]);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'token' => $token,
        'user' => $user
    ]);
}




//logout

public function logout(Request $request)
 { 
    
$request->user()->currentAccessToken()->delete(); 
return response()->json([
     'message' => 'Logged out successfully'
      ]);
       }

}
