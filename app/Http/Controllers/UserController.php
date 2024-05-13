<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserLocationRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $userRepository;
    private $locationRepository;


    public function __construct(
        UserRepositoryInterface $userRepository,
        UserLocationRepositoryInterface $locationRepository
    )
    {
        $this->middleware('jwt.verify');
        $this->userRepository = $userRepository;
        $this->locationRepository = $locationRepository;
    }

    public function getAll(): JsonResponse
    {
        return response()->json((
            [
                'users' => $this->userRepository->getAll()
            ]
            ), Response::HTTP_OK);
    }

    public function getOne(string $id)
    {
        return response()->json((
            [
                'user' => $this->userRepository->getOne($id)
            ]
            ), Response::HTTP_OK);
    }

    public function getlocation(string $id)
    {
        $location = $this->locationRepository->get($id);
        return response()->json($location, 200);
    }

    public function getlocationByUser(string $userId)
    {
        $location = $this->locationRepository->getByUser($userId);
        return response()->json($location, 200);
    }

    public function savelocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'latitude' => 'required|decimal:1,4',
            'longitude' => 'required|decimal:1,4',
        ]);

        if($validator->fails()) {
            return response() ->json($validator->errors()->toJson(), 400);
        }

        $location = $this->locationRepository->save($validator->validate());

        return response()->json($location, 200);
    }

    public function updatelocation(string $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|decimal:1,4',
            'longitude' => 'required|decimal:1,4',
        ]);

        if($validator->fails()) {
            return response() ->json($validator->errors()->toJson(), 400);
        }

        $location = $this->locationRepository->update($id, $validator->validate());

        return response()->json($location, 201);
    }
}
