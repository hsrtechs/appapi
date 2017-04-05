<?php

namespace App\Http\Controllers;

use App\Offer;
use Exception;
use Illuminate\Http\Request;
use function json_encode;
use function redirect;
use function session_abort;
use function session_status;
use function setInputs;
use function var_dump;
use function view;
use function with;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function addApp()
    {
        return view('addApp');
    }

    public function addAppHandel(Request $request)
    {
        try{
            $this->validate($request, [
                'name' => 'required',
                'url' => 'required|url',
                'package_id' => 'required|unique:offers',
                'credits' => 'required|numeric|min:0',
                'country' => 'required|string',
                'img' => 'required|url',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e)
        {
            setInputs($request->all());
            setErrors($e->getResponse()->getContent());
        }

        //TODO Complete Adding Offer

        return redirect($request->path());
    }

    public function listOffers()
    {
       if(!empty($_GET['status']))
           $status = $_GET['status'] === 'true' ? true : false;
       else
           $status = NULL;

        return view('listApp')->with(['offers' => Offer::get(), 'status' => $status]);
    }

    public function deleteOffer($id)
    {
        $response = Offer::findOrFail($id)->delete() ?  'true' : 'false';

        return redirect(url('/list-apps?status='.$response));
    }


    public function switchOfferVisibility($id)
    {
        $offer = Offer::findOrFail($id);

        if($offer)
        {
            $offer->hidden = !$offer->hidden;
            $response = $offer->saveOrFail() ? 'true' : 'false';
        }else
            $response = 'false';

        return redirect(url('/list-apps?status='.$response));
    }
}
