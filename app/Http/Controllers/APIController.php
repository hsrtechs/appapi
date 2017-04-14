<?php

namespace App\Http\Controllers;

use function APIError;
use App\InstallLog;
use App\Offer;
use App\RechargeRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use function is_integer;
use function json_decode;
use function loggedAdmin;
use function password_verify;
use function str_random;
use const true;


class APIController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api');
        $this->middleware('auth', ['except' => ['createUser', 'loginUser']]);
    }

    public function getOffers(int $offer = NULL)
    {
        $requestType = 'GetOffers';
        $country = Auth::user()->country;

        if(!empty($offer))
            $json = Offer::active($country)->where('id', $offer)->first();
        else
            $json = Offer::active($country)->get()->toArray();


        if(!empty($json))
            return APIResponse($requestType, ['offers' => $json]);
        else
            return APIError($requestType, ['Entry not found' => 'The item you are trying to access cannot be found.'], 500);

    }

    public function getUserData(int $id = NULL)
    {
        $requestType = 'GetUserData';
        if(!empty($id) && is_integer($id))
        {
            $user = User::where('id',$id)->first();
        }else if(Auth::check())
        {
            $user = Auth::user();
        }else {
            $user = NULL;
        }
        if(!empty($user))
            return APIResponse($requestType, ['user' => $user]);
        else
            return APIError($requestType, ['Entry not found' => 'The item you are trying to access cannot be found.']);
    }

    public function getUserCredits(int $user = NULL)
    {
        $requestType = 'GetUsersCredits';
        if(!empty($user))
        {
            $credits = User::where('id',$user)->first()->credits ?? NULL;
        }
        else{
            if(Auth::check())
                $credits = Auth::user()->credits;
            else
                $credits = NULL;
        }

        if($credits)
            return APIResponse($requestType, ['credits' => $credits]);
        else
            return APIError($requestType, ['Entry not found' => 'The item you are trying to access cannot be found.']);
    }

    public function createUser(Request $request)
    {
        $requestType = 'CreateUser';
        try {
            $this->validate($request, [
                'name' => 'required|string',
                'password' => 'required|string|min:8',
                'number' => 'required|numeric|min:10|unique:users',
                'email' => 'required|email|unique:users',
                'country' => 'required|string',
                'device_id' => 'required|min:10|max:20|unique:users',
            ]);


            $user = new User;
            $user->name = $request->input('name');
            $user->password = $request->input('password');
            $user->number = $request->input('number');
            $user->email = $request->input('email');
            $user->country = $request->input('country');
            $user->device_id = $request->input('device_id');
            $user->access_token = str_random(64);

            if ($user->saveOrFail())
                return APIResponse($requestType, ['user' => $user->makeVisible('access_token')]);
            else
                return APIError($requestType, ['error' => 'Failed for some reason']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return APIError($requestType, json_decode($e->getResponse()->getContent(), true));
        }
    }

    public function offerInstalled()
    {
        $requestType = 'InstalledOffers';
        $user = Auth::user();
        $logs = InstallLog::where('user_id', $user->id)->select('package', 'device_id', 'created_at as installed_on')->get()->toArray();
        if (true)
            return APIResponse($requestType, ['installed' => $logs]);
        else
            return APIError($requestType, ['error' => 'Failed for some reason']);

    }

    public function offerInstallLogs(Request $request)
    {

        $requestType = 'OfferLogs';
        if (!$request->has('package'))
            return APIError($requestType, ["Invalid id" => "The pre-requisite id is invalid or not found."]);

        $user = Auth::user();

        $package = $request->input('package');

        if (InstallLog::where('user_id', $user->id)->where('package', $package)->count())
            return APIError($requestType, ["Already availed" => "The offer is already availed."]);

        $offer = Offer::where('package_id', $package)->first();

        $credits = $offer->credits;

        $log = new InstallLog;
        $log->package = $package;
        $log->credits = $credits;
        $log->user_id = $user->id;
        $log->device_id = $user->device_id;

        if ($log->saveOrFail() && $user->addCredits($credits))
            return APIResponse($requestType, ['user' => $user]);
        else
            return APIError($requestType, ['error' => 'Failed for some reason']);

    }

    public function requestRecharge(Request $request)
    {

        $requestType = 'RequestRecharge';
        try {
            $this->validate($request, [
                'recharge' => 'required|integer|min:10',
                'number' => 'required|string|min:10',
            ]);


            $user = Auth::user();
            $recharge = (int)$request->input('recharge');
            $number = $request->input('number');

            if ($user->credits < $recharge)
                return APIError($requestType, ["Invalid id" => "Insufficient Credits."]);

            $temp = new RechargeRequest;
            $temp->user_id = $user->id;
            $temp->recharge = $recharge;
            $temp->number = $number;
            $temp->ip = $request->ip();

            if ($temp->saveOrFail() && $user->deductCredits($recharge))
                return APIResponse($requestType, ['user' => $user]);
            else
                return APIError($requestType, ['error' => 'Failed for some reason']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return APIError($requestType, json_decode($e->getResponse()->getContent(), true));
        }
    }

    public function loginUser(Request $request)
    {
        $requestType = 'LoginRequest';
        try {
            $this->validate($request, [
                'email' => 'required|email|exists:users',
                'password' => 'required|string|min:8',
                'device_id' => 'required|min:10|max:20',
            ]);

            $user = User::where('email', $request->input('email'))->first();

            if (!password_verify($request->input('password'), $user->password))
                return APIError($requestType, ['error' => 'Invalid Password.']);

            if (!$user->verified)
                return APIError($requestType, ['error' => 'User is not Verified.']);


            if ($user->updateAccessToken() && $user->updateDeviceId($request->input('device_id')))
                return APIResponse($requestType, ['user' => $user->makeVisible('access_token')]);
            else
                return APIError($requestType, ['error' => 'Failed for some reason']);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return APIError($requestType, json_decode($e->getResponse()->getContent(), true));

        }
    }

    public function changePassword(Request $request)
    {
        $requestType = 'ChangePasswordRequest';
        try {
            $this->validate($request, [
                'password' => 'required|string|min:8',
            ]);

            $user = Auth::user();

            if ($user->changePassword($request->input('password')))
                return APIResponse($requestType, ['user' => $user]);
            else
                return APIError($requestType, ['error' => 'Failed for some reason']);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return APIError($requestType, json_decode($e->getResponse()->getContent(), true));

        }

    }

    public function toggleVerification()
    {
        $requestType = 'ChangePasswordRequest';
        try {
            $user = Auth::user();

            if ($user->toggleVerified())
                return APIResponse($requestType, ['user' => $user]);
            else
                return APIError($requestType, ['error' => 'Failed for some reason']);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return APIError($requestType, json_decode($e->getResponse()->getContent(), true));

        }

    }

}
