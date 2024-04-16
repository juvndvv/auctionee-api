<?php

namespace App\Repositories;

interface AuctionRepository
{
    public function findAll();
    public function find($id);
    public function create($attributes);
    public function deleteById($id);
}
