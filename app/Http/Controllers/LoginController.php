<?php
namespace App\Http\Controllers;


use App\Admin;
use App\Helpers\Session;
use function dd;
use function encrypt;
use Illuminate\Http\Request;
use function password_verify;
use function redirect;
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
        redirect('/');
    }

    public function loginHandel(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $admin = Admin::where('username',$username)->first();

        if($admin)
        {
            if(password_verify($password,$admin->password))
            {
                $admin = $admin->id;
            }
        }else
        {
            $error = "";
        }

        Session::put('admin',encrypt($admin));

        redirect(url('/'));

    }
}