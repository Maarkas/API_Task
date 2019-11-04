<?php


namespace App\Repositories;


use App\Bet;
use App\Interfaces\BetInterface;

class BetRepository implements BetInterface
{
    public function bet($params)
    {
        $bet = Bet::get($params);
        return $bet;
    }
}
