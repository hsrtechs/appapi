<?php
namespace App\Http\Controllers;


use App\Helpers\Session;
use Illuminate\Http\Request;
use function redirect;

class LoginController extends Controller
{
    public function __construct()
    {
    }

    public function login(Request $request)
    {

    }

    public function logout(Request $request)
    {
        Session::destroy();
        redirect('/');
    }

    public function loginHandel(Request $request)
    {

    }
}