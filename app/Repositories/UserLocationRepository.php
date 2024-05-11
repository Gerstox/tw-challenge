<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserLocation;
use App\Repositories\Interfaces\UserLocationRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class UserLocationRepository implements UserLocationRepositoryInterface
{
    public function get($id)
    {
        try {
            $location = UserLocation::where('id', $id)->firstOrFail();
        } catch(Exception $e) {
            return ['error' => 'Ubicación no encontrada'];
        }
        return [
            'location' => $location
        ];
    }
    public function save($data)
    {
        try {
            $user = User::where('id', $data["user_id"])->firstOrFail();
            if(!$user->location) {
                $location = $user->location()->create([
                    'latitude' => $data["latitude"],
                    'longitude' => $data["longitude"]
                ]);
            } else {
            return ['error' => 'Ya se ha guardado una ubicación para este usuario, solo se permiten actualziaciones.'];
            }
        } catch(Exception $e) {
            return ['error' => 'Usuario no encontrado'];
        }
        return [
            'message' => '¡Ubicación guardada exitosamente!',
            'location' => $location
        ];
    }
    public function update($id, $data)
    {
        try {
            $location = UserLocation::where('id', $id)->firstOrFail();
            $newLocation = $location->update([
                'latitude' => $data["latitude"],
                'longitude' => $data["longitude"]
            ]);

        } catch(Exception $e) {
            return ['error' => 'Ubicacion no encontrada'];
        }
        return [
            'message' => '¡Ubicación actualizada exitosamente!',
            'location'=> $data
        ];
            
    }
    public function delete()
    {
        return null;
    }
}
