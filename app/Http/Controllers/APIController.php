<?php

namespace App\Http\Controllers;

use function APIError;
use App\InstallLog;
use App\Offer;
use App\RechargeRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function is_integer;
use function json_decode;
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
        $this->middleware('auth', ['except' => ['createUser']]);
    }

    public function getOffers(int $offer = NULL)
    {
        if(!empty($offer))
            $json = Offer::active()->where('id',$offer)->first();
        else
            $json = Offer::active()->get()->toArray();

        if(!empty($json))
            return APIResponse('GetOffers',['offers' => $json]);
        else
            return APIError('GetOffers',['Entry not found' => 'The item you are trying to access cannot be found.'], 500);

    }

    public function getUserData(int $user = NULL)
    {
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
            return APIResponse('GetUserData',['user' => $user]);
        else
            return APIError('GetUserData',['Entry not found' => 'The item you are trying to access cannot be found.']);
    }

    public function getUserCredits(int $user = NULL)
    {
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
            return APIResponse('GetUsersCredits',['credits' => $credits]);
        else
            return APIError('GetUserCredits',['Entry not found' => 'The item you are trying to access cannot be found.']);
    }

    public function createUser(Request $request)
    {
        try {
            $this->validate($request, [
                'first_name' => 'required|string|min:3|max:50',
                'last_name' => 'required|string|min:3|max:50',
                'number' => 'required|numeric|min:0',
                'email' => 'required|email|unique:users',
                'country' => 'required|string',
                'device_id' => 'required|min:16|max:20',
            ]);


            $user = new User;
            $user->firstname = $request->input('first_name');
            $user->lastname = $request->input('last_name');
            $user->number = $request->input('number');
            $user->email = $request->input('email');
            $user->country = $request->input('country');
            $user->device_id = $request->input('device_id');
            $user->access_token = str_random(64);

            if ($user->saveOrFail())
                return APIResponse("CreateUser", ['user' => $user]);
            else
                return APIError("CreateUser", ['error' => 'Failed for some reason']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return APIError('CreateUser', json_decode($e->getResponse()->getContent(), true));
        }
    }

    public function offerInstallLogs(Request $request)
    {

        if (!$request->has('package'))
            return APIError('OfferLogs', ["Invalid id" => "The pre-requisite id is invalid or not found."]);

        $user = Auth::user();

        $package = $request->input('package');

        if (InstallLog::where('user_id', $user->id)->where('package', $package)->count())
            return APIError('OfferLogs', ["Already availed" => "The offer is already availed."]);

        $offer = Offer::where('package_id', $package)->first();

        $credits = $offer->credits;

        $log = new InstallLog;
        $log->package = $package;
        $log->credits = $credits;
        $log->user_id = $user->id;
        $log->device_id = $user->device_id;

        if ($log->saveOrFail() && $user->addCredits($credits))
            return APIResponse("OfferLogs", ['user' => $user]);
        else
            return APIError("OfferLogs", ['error' => 'Failed for some reason']);

    }

    //TODO Request Recharge

    public function requestRecharge(Request $request)
    {

        try {
            $this->validate($request, [
                'recharge' => 'required|integer|min:10',
                'number' => 'required|string|min:10',
            ]);


            $user = Auth::user();
            $recharge = $request->input('recharge');
            $number = $request->input('number');

            if ($user->credits < $recharge)
                return APIError('RequestRecharge', ["Invalid id" => "Insufficient Credits."]);

            $temp = new RechargeRequest;
            $temp->user_id = $user->id;
            $temp->recharge = $recharge;
            $temp->number = $number;
            $temp->ip = $request->ip();

            if ($temp->saveOrFail() && $user->deductCredits($recharge))
                return APIResponse("RequestRecharge", ['user' => $user]);
            else
                return APIError("RequestRecharge", ['error' => 'Failed for some reason']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return APIError('CreateUser', json_decode($e->getResponse()->getContent(), true));
        }
    }

}
