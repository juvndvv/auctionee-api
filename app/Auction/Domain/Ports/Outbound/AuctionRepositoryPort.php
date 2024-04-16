<?php

namespace App\Auction\Domain\Ports\Outbound;

interface AuctionRepositoryPort
{
    public function findAll();
    public function find($id);
    public function create($attributes);
    public function deleteById($id);
}
