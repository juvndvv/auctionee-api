<?php

namespace App\Auction\Application\Commands\UpdateAuctionAvatar;

use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Shared\Domain\Ports\Inbound\ImageRepositoryPort;
use App\Shared\Infrastructure\Bus\EventBus;

final class UpdateAuctionAvatarCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly ImageRepositoryPort $imageRepository,
        private readonly AuctionRepositoryPort $auctionRepository,
        private readonly EventBus $eventBus
    )
    {}

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdateAuctionAvatarCommand $command): void
    {
        $uuid = $command->uuid();
        $avatar = $command->avatar();

        $auction = $this->auctionRepository->findByUuid($uuid);             // Query auction
        $old = $auction->avatar();                                          // Delete previous
        $this->imageRepository->delete($old);
        $new = $this->imageRepository->store('auctions', $avatar);   // Save new
        $auction->updateAvatar($new);                                       // Update URL
        $this->auctionRepository->updateAvatar($uuid, $new);                // Persist
        $this->eventBus->dispatch(...$auction->pullDomainEvents());         // Publish events
    }
}
