<?php

namespace App\Http\Controllers\Api;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\UserRequest;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $users = User::where('status', '1')->with('roles')->get();
        $roles = Role::all();

        return response()->json([
            "status" => true,
            "message" => "success",
            "data" => [
                'users' => $users,
                'roles' => $roles
            ]
        ], response::HTTP_OK);
    }

    public function create()
    {

    }

    public function store(UserRequest $request)
    {
        $status = "error";
        $message = "User failed to create.";
        $code = Response::HTTP_CONFLICT;
        $data = $request->all();

        $user = User::create([
            'firstname' => $request['firstname'],
            'middlename' => $request['middlename'],
            'lastname' => $request['lastname'],
            'user_type_id' => $request['user_type_id'],
            'contact_no' => $request['contact_no'],
            'username' => $request['username'],
            'gender' => $request['gender'],
            'birthday' => $request['birthday'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $user->roles()->attach($request['user_type_id']);

        if ($user) {
            $status = "success";
            $message = "User successfully created";
            $code = Response::HTTP_CREATED;
            $data = $user;
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $user
        ], $code);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->roles()->sync($request['user_type_id']);
        $user->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'User successfully updated!',
            'data' => $user
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $status = "error";
        $message = "User failed to delete.";
        $code = Response::HTTP_CONFLICT;

        if ($id == Auth::user()->id) {
            $message = "Can't to delete your account.";
        } elseif ($id == "1") {
            $message = "Can't delete administrator account.";
        } else {
            $user = User::findOrFail($id);
            $user->status = '0';
            $user->save();
            $status = "success";
            $message = "User successfully deleted!";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ], Response::HTTP_OK);
    }
}
