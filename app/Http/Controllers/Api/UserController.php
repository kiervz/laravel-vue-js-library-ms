<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $users = User::all();
        return response()->json([
            "status" => true,
            "message" => "success",
            "data" => $users
        ], response::HTTP_OK);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $status = "error";
        $message = "User failed to create.";
        $code = Response::HTTP_CONFLICT;
        $data = $request->all();

        $user = User::create($request->all());

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

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'User successfully updated!',
            'data' => $user
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {

    }
}
