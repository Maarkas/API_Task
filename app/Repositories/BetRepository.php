<?php

namespace App\Repositories;

use App\BalanceTransactions;
use App\Bet;
use App\Exceptions\BetException;
use App\Interfaces\BetInterface;
use App\Player;
use App\Selection;

/**
 * Class BetRepository
 * @package App\Repositories
 * @property array $errors
 */
class BetRepository implements BetInterface
{
    /**
     * @var array
     */
    protected $errors;

    /**
     * BetRepository constructor.
     */
    public function __construct()
    {
        $this->errors = [];
    }

    /**
     * Description: Validates input and returns result. If errors exist - returns result with errors.
     *
     * @param $payload
     * @return array
     */
    public function makeBet($payload)
    {
        $this->validateMaxStake($payload['stake_amount']);

        $this->validateMaxWin($payload['stake_amount'], $payload['selections']);

        if ($this->errors) {
            $payload['errors'] = array_merge($payload['errors'], $this->errors);
            return $payload;
        }

        $player = Player::firstOrCreate([
            'id' => $payload['player_id']
        ]);

        if ($player->balance < $payload['stake_amount']) {
            $payload['errors'] = (new BetException("Insufficient balance", 11))->getException();
            return $payload;
        }

        $this->processBet($payload, $player);
        return [];
    }

    /**
     * Description: Validating maximum staking amount
     *
     * @param $stake_amount
     * @return int|null
     */
    private function validateMaxStake($stake_amount)
    {
        if ($stake_amount > Bet::MAX_STAKE) {
            $exception = (new BetException("Maximum stake amount is " . Bet::MAX_STAKE, 3))->getException();
            return array_push($this->errors, $exception);
        }
        return null;
    }

    /**
     * Description: Validating if not maxing out win pool size
     *
     * @param $stake_amount
     * @param $selections
     * @return int|null
     */
    private function validateMaxWin($stake_amount, $selections)
    {
        $overallOdds = 1;
        foreach ($selections as $selection) {
            $overallOdds *= $selection['odds'];
        }

        if ($stake_amount > Bet::MAX_WIN) {
            $exception = (new BetException("Maximum win amount is " . Bet::MAX_WIN, 9))->getException();
            return array_push($this->errors, $exception);
        }
        return null;
    }

    /**
     * Description: Processing the bet with validated data
     *
     * @param $payload
     * @param Player $player
     */
    public function processBet($payload, Player $player) : void
    {
        /* Creates a bet and saves it in the database */
        $bet = new Bet();
        $bet->stake_amount = $payload['stake_amount'];
        $bet->save();

        /* Saves all selections into the database */
        foreach ($payload['selections'] as $selection) {
             $newSelection = new Selection();
             $newSelection->bet_id = $bet->id;
             $newSelection->selection_id = $selection['id'];
             $newSelection->odds = $selection['odds'];
             $newSelection->save();
        }

        /* Removes stake amount from players balance and saves them for transaction generation */
        $oldBalance = $player->balance;
        $newBalance = $player->makeTransaction($payload['stake_amount']);

        /* Creates a transaction in the database */
        $transaction = new BalanceTransactions();
        $transaction->player_id = $player->id;
        $transaction->amount = $newBalance;
        $transaction->amount_before = $oldBalance;
        $transaction->save();
    }
}
