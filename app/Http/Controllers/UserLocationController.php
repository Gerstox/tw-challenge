<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\UserLocationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserLocationController extends Controller
{

    private $locationRepository;


    public function __construct(UserLocationRepositoryInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
        $this->middleware('auth');
    }

    public function save(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'latitude' => 'required|decimal:1,4',
            'longitude' => 'required|decimal:1,4',
        ]);

        if($validator->fails()) {
            return to_route('home');
        }

        $location = $this->locationRepository->saveWeb($validator->validate());

        return to_route('home');
    }
}
