<?php
namespace App\Http\Controllers;


use App\Admin;
use App\Helpers\Session;
use function bcrypt;
use function dd;
use function encrypt;
use function getErrors;
use function hasErrors;
use Illuminate\Http\Request;
use function loggedAdmin;
use function password_verify;
use function redirect;
use function status;
use function url;

class RegistrationController extends Controller
{
    public function __construct()
    {
    }

    public function registration()
    {
        return view('register')->with(status());
    }

    public function registrationHandel(Request $request)
    {

        try{
            $this->validate($request, [
                'name' => 'required|string|min:5|max:100',
                'username' => 'required|unique:admins|min:6|max:25',
                'email' => 'required|unique:admins|email',
            ]);


            $data['name'] = $request->input('name');
            $data['username'] = $request->input('username');
            $data['email'] = $request->input('email');
            $data['password'] = $request->input('password');

            $admin = new Admin;
            $admin->name = $data['name'];
            $admin->username = $data['username'];
            $admin->email = $data['email'];
            $admin->password = bcrypt($data['password']);
            $admin->created_by = loggedAdmin()->id;
            $admin->created_by_ip = $request->ip();
            $admin->last_login = '0.0.0.0';

            $status = $admin->saveOrFail() ? 'true' : 'false';
            return redirect(url('/registration?status='.$status));

        }catch (\Illuminate\Validation\ValidationException $e)
        {
            setInputs($request->except('password'));
            setErrors($e->getResponse()->getContent());
            return redirect('/registration');
        }
    }
}