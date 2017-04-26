<?php
namespace App\Http\Controllers;


use App\Admin;
use App\Helpers\Mail;
use App\Helpers\Session;
use App\User;
use Exception;
use Illuminate\Http\Request;
use function abort;
use function addError;
use function decrypt;
use function password_verify;
use function redirect;
use function response;
use function setErrors;
use function url;

class LoginController extends Controller
{
    public function __construct()
    {
    }

    public function login()
    {
        return view('login');
    }

    public function logout(Request $request)
    {
        Session::destroy();
        return redirect('/');
    }

    public function loginHandel(Request $request)
    {
        try{
            $this->validate($request, [
                'username' => 'required|exists:admins|min:4|max:25',
                'password' => 'required|min:8|max:25',
            ]);

            $username = $request->input('username');
            $password = $request->input('password');

            $admin = Admin::where('username',$username)->first();

            if(password_verify($password,$admin->password))
            {
                Session::put('admin',($admin->id));
                Session::put('login',($admin->last_login));

                Admin::findOrFail($admin->id)->update(['last_login' => $request->ip()]);

                return redirect(url('/'));

            }else
            {
                setInputs($request->except('password'));
                addError('Authentication Failed.');
                return redirect('/login');
            }

        }catch (\Illuminate\Validation\ValidationException $e)
        {
            setInputs($request->except('password'));
            setErrors($e->getResponse()->getContent());
            return redirect('/login');
        }
    }

    public function passwordRest($id, $token, Request $request)
    {
        try {
            $id = decrypt($id);

            $user = User::findOrFail($id);
            if (empty($user))
                abort(404);

            if ($user->compareResetToken($token)) {
                Mail::init($user)->sendNewPassword()->send();
                return response('Password Reset Successful. Please check your email address for new password.');
            } else
                return response("Failed To Reset Password");
        } catch (Exception $e) {
            return response('Something Went Wrong. Please contact Administrator for help', 500);
        }
    }

    public function passwordRestRequest(Request $request)
    {
        $requestType = 'PasswordReset';
        try {
            $this->validate($request, [
                'number' => 'required|digits_between:7,12|exists:users'
            ]);

            $number = $request->input('number');
            $user = User::where('number', $number)->first();
            if (empty($user))
                abort(404);

            (Mail::init($user)->passwordReset()->send());
            return APIResponse($requestType, ['msg' => "Please check your email for the reset link"]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return APIError($requestType, json_decode($e->getResponse()->getContent(), true), 422);

        } catch (Exception $e) {
            return APIError($requestType, [$e->getMessage()], 422);
        }
    }
}