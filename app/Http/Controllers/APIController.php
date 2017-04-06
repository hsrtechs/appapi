<?php

namespace App\Http\Controllers;

use function APIError;
use App\Helpers\APIResponse;
use App\Offer;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use function integerValue;
use function is_integer;
use function is_numeric;
use function response;

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


}
