<?php

use App\Repositories\BetRepository;
use Laravel\Lumen\Application;
use Laravel\Lumen\Console\Kernel;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * @var BetRepository
     */
    private $betRepository;

    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->betRepository = app(BetRepository::class);
    }
}
