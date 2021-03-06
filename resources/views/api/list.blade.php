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
                <th class="col-md-3 col-sm-2">Resource URL</th>
                <th class="col-md-5 col-sm-5">Options || Parameters</th>
                <th class="col-md-5 col-sm-1">Headers</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Get All Offers</td>
                <td>POST</td>
                <td>/api/v1/offers</td>
                <td></td>
                <td class="bg-success">TRUE</td>
            </tr>
            <tr>
                <td>Get Offer With Specific ID</td>
                <td>POST</td>
                <td>/api/v1/offers/{offer}</td>
                <td>{offer} = Offer ID</td>
                <td class="bg-success">TRUE</td>
            </tr>
            <tr>
                <td>Get Authenticated Users</td>
                <td>POST</td>
                <td>/api/v1/user</td>
                <td></td>
                <td class="bg-success">TRUE</td>
            </tr>
            <tr>
                <td>Register User</td>
                <td>POST</td>
                <td>/api/v1/user/create</td>
                <td>{"name", "password", "number", "email", "device_id", "country"}</td>
                <td class="bg-danger">FALSE</td>
            </tr>
            <tr>
                <td>Toggle User verification state</td>
                <td>PATCH</td>
                <td>/api/v1/user/verified</td>
                <td></td>
                <td class="bg-success">TRUE</td>
            </tr>
            <tr>
                <td>Change User Password</td>
                <td>PATCH</td>
                <td>/api/v1/user/password</td>
                <td>{"password"}</td>
                <td class="bg-danger">FALSE</td>
            </tr>
            <tr>
                <td>Authenticate user</td>
                <td>POST</td>
                <td>/api/v1/user/login</td>
                <td>{"email", "password", "device_id" }</td>
                <td class="bg-danger">FALSE</td>
            </tr>
            <tr>
                <td>Get Credits of Authenticated user</td>
                <td>POST</td>
                <td>/api/v1/user/credits</td>
                <td></td>
                <td class="bg-success">TRUE</td>
            </tr>
            <tr>
                <td>Request to recharge</td>
                <td>POST</td>
                <td>/api/v1/request/recharge</td>
                <td>{recharge, provider}</td>
                <td class="bg-success">TRUE</td>
            </tr>
            <tr>
                <td>Get User With Specific ID</td>
                <td>POST</td>
                <td>/api/v1/user/{user}</td>
                <td>{user} = User ID</td>
                <td class="bg-success">TRUE</td>
            </tr>
            <tr>
                <td>Get User Credit Logs</td>
                <td>POST</td>
                <td>/api/v1/user/credit/log</td>
                <td></td>
                <td class="bg-success">TRUE</td>
            </tr>
            <tr>
                <td>Get Credits of a Specific user</td>
                <td>POST</td>
                <td>/api/v1/user/{user}/credits</td>
                <td>{user} = User ID</td>
                <td class="bg-success">TRUE</td>
            </tr>
            <tr>
                <td>Get availed offers</td>
                <td>POST</td>
                <td>/api/v1/app/installed</td>
                <td></td>
                <td class="bg-success">TRUE</td>
            </tr>
            <tr>
                <td>Confirm Installation</td>
                <td>POST</td>
                <td>/api/v1/app/install/success</td>
                <td>{package} = package of the installed app</td>
                <td class="bg-success">TRUE</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection