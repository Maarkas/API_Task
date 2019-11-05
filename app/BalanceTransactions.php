<?php


namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BalanceTransactions
 * @package App
 * @property integer    $id
 * @property integer    $player_id
 * @property float      $amount
 * @property float      $amount_before
 * @property Carbon     $created_at
 * @property Carbon     $updated_at
 */
class BalanceTransactions extends Model
{
    /**
     * @var string
     */
    protected $table = 'balance_transactions';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    public $timestamps;
}
