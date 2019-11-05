<?php

namespace tests\Unit;

use App\Bet;
use App\Repositories\BetRepository;
use TestCase;

class BetRepositoryTest extends TestCase
{
    /**
     * @var BetRepository
     */
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new BetRepository();
    }

    public function testMaxStakeValidationReturnsNull()
    {
        $stake = Bet::MAX_STAKE - 1;
        $result = $this->repository->validateMaxStake($stake);
        $this->assertNull($result);
    }
}
