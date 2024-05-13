<?php

namespace App\Repositories\Interfaces;

interface UserLocationRepositoryInterface
{
    public function get($id);
    public function getByUser($userId);
    public function save($data);
    public function saveWeb($data);
    public function update($id, $data);
    public function delete();
}
