<?php

namespace App\Auction\Domain\Ports\Inbound;

interface AuctionServicePort
{
    public function findAll();
    public function create(array $auction);
    public function findById(int $id);
    public function deleteById(int $id);
}
