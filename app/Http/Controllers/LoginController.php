<?php
namespace App\Http\Controllers;


use function addError;
use App\Admin;
use App\Helpers\Session;
use function dd;
use function decrypt;
use function encrypt;
use function getErrors;
use Illuminate\Http\Request;
use function loggedAdmin;
use function password_verify;
use function redirect;
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
}