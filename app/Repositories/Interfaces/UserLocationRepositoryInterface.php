<?php

namespace App\Repositories\Interfaces;

interface UserLocationRepositoryInterface
{
    public function get($id);
    public function save($data);
    public function update($id, $data);
    public function delete();
}
