<?php

namespace App\Http\Controllers;

use function APIError;
use App\InstallLog;
use App\Offer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function is_integer;


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
        $this->middleware('auth');
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

}
