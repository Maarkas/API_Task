<?php


namespace App\Repositories;


use App\Bet;
use App\Interfaces\BetInterface;
use App\Player;

class BetRepository implements BetInterface
{
    public const MAX_STAKE = 10000;
    public const MAX_WIN = 20000;

    public function makeBet($payload)
    {
        if ($payload['stake_amount'] > self::MAX_STAKE) {
            $payload['errors'] = ['code' => 3, 'message' => 'Maximum stake amount is ' . self::MAX_STAKE];
            return response()->json($payload);
        }

        try {
            $player = Player::find($payload['player_id']);
        } catch (\Exception $e) {
            $player = Player::create();
        }
        $bet = Bet::get($payload);
        return $bet;
    }

    private function validateMaxWin($stake_amount)
    {
        if ($stake_amount > self::MAX_WIN) {

        }
    }
}
