<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * Class Player
 * @package App
 * @property integer    $id
 * @property integer    $player_id
 * @property float      $balance
 * @property Carbon     $created_at
 * @property Carbon     $updated_at
 */
class Player extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'players';

    public $timestamps;

    /**
     * @param $stake
     * @return bool
     */
    public function makeTransaction($stake)
    {
        $this->update(['balance' => $this->balance -= $stake]);
        return $this->balance;
    }
}
