<?php declare(strict_types=1);

namespace App\Auction\Application\Commands\CreateAuction;

use App\Auction\Domain\Models\Auction\Auction;
use App\Auction\Domain\Ports\Outbound\AuctionRepositoryPort;
use App\Shared\Application\Commands\CommandHandler;
use App\Shared\Infrastructure\Bus\EventBus;

final class CreateAuctionCommandHandler extends CommandHandler
{
    public function __construct(
        private readonly EventBus $eventBus,
        private readonly AuctionRepositoryPort $auctionRepository
    )
    {}

    public function __invoke(CreateAuctionCommand $command): string
    {
        $categoryUuid = $command->categoryUuid();
        $userUuid = $command->userUuid();
        $name = $command->name();
        $description = $command->description();
        $status = $command->status();
        $startingPrice = $command->startingPrice();
        $startingDate = $command->startingDate();
        $duration = $command->duration();
        $avatar  = $command->avatar();

        $auction = Auction::create(
            $categoryUuid,
            $userUuid,
            $name,
            $description,
            $status,
            $startingPrice,
            $startingDate,
            $duration,
            $avatar
        );

        $this->auctionRepository->create($auction->toPrimitives());

        $this->eventBus->dispatch(...$auction->pullDomainEvents());

        return $auction->uuid();
    }
}
