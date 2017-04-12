@extends('layouts.default')
@section('container')
    <div class="col-md-6">
        <table class="table table-bordered">
            <thead>
            <caption><h2>Admin Info</h2></caption>
            <tr class="bg-primary">
                <th class="col-md-3"></th>
                <th class="col-md-8"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-right"><strong>Name</strong></td>
                <td>{{ loggedAdmin()->name }}</td>
            </tr>
            <tr>
                <td class="text-right"><strong>Username</strong></td>
                <td>{{ loggedAdmin()->username }}</td>
            </tr>
            <tr>
                <td class="text-right"><strong>Email</strong></td>
                <td>{{ loggedAdmin()->email }}</td>
            </tr>
            <tr>
                <td class="text-right"><strong>Last Login</strong></td>
                <td>{{ (\App\Helpers\Session::get('login')) }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-bordered">
            <thead>
            <caption><h2>Headers required for all APIs</h2></caption>
            <tr class="bg-primary">
                <th>Header Titles</th>
                <th>Header Value</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Accept</td>
                <td>application/json</td>
            </tr>
            <tr>
                <td>Content-Type</td>
                <td>application/json</td>
            </tr>
            <tr>
                <td>Device-ID</td>
                <td>{Device ID of android device}</td>
            </tr>
            <tr>
                <td>Access-Token</td>
                <td>{User Access Token}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
            <tr class="bg-primary">
                <th class="col-md-3 col-sm-3">API Name</th>
                <th class="col-md-1 col-sm-1">Method</th>
                <th class="col-md-3 col-sm-3">Resource URL</th>
                <th class="col-md-5 col-sm-5">Options || Parameters</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Get All Offers</td>
                <td>POST</td>
                <td>/api/v1/offers</td>
                <td></td>
            </tr>
            <tr>
                <td>Get Offer With Specific ID</td>
                <td>POST</td>
                <td>/api/v1/offers/{offer}</td>
                <td>{offer} = Offer ID</td>
            </tr>
            <tr>
                <td>Get Authenticated Users</td>
                <td>POST</td>
                <td>/api/v1/user</td>
                <td></td>
            </tr>
            <tr>
                <td>Register User</td>
                <td>POST</td>
                <td>/api/v1/user/create</td>
                <td>{"name", "password", "number", "email", "device_id", "country"}</td>
            </tr>
            <tr>
                <td>Get Credits of Authenticated user</td>
                <td>POST</td>
                <td>/api/v1/user/login</td>
                <td>{"email", "password", "device_id" }</td>
            </tr>
            <tr>
                <td>Get Credits of Authenticated user</td>
                <td>POST</td>
                <td>/api/v1/user/credits</td>
                <td></td>
            </tr>
            <tr>
                <td>Request to recharge</td>
                <td>POST</td>
                <td>request/recharge</td>
                <td>{recharge} = amount</td>
            </tr>
            <tr>
                <td>Get User With Specific ID</td>
                <td>POST</td>
                <td>/api/v1/user/{user}</td>
                <td>{user} = User ID</td>
            </tr>
            <tr>
                <td>Get Credits of a Specific user</td>
                <td>POST</td>
                <td>/api/v1/user/{user}/credits</td>
                <td>{user} = User ID</td>
            </tr>
            <tr>
                <td>Confirm Installation</td>
                <td>POST</td>
                <td>/api/v1/install/success</td>
                <td>{package} = package of the installed app</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection