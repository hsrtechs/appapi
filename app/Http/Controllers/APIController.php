<?php

namespace App\Http\Controllers;

use App\Offer;
use Illuminate\Support\Facades\Auth;
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
//        $this->middleware('auth');
    }

    public function getOffers()
    {
        return response()->json(Offer::active()->get()->toArray());
    }

    public function getUserData()
    {
        if(Auth::check())
            return response()->json(Auth::user());
        else return response('Failed',401);
    }


}
