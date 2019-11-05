<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Selection
 * @package App
 * @property integer    $id
 * @property integer    $bet_id
 * @property integer    $selection_id
 * @property float      $odds
 * @property Carbon     $created_at
 * @property Carbon     $updated_at
 */
class Selection extends Model
{
    /**
     * Description: Minimum possible odds
     */
    public const MIN_ODDS = 1;

    /**
     * Description: Maximum possible odds
     */
    public const MAX_ODDS = 10000;

    /**
     * @var string
     */
    protected $table = 'bet_selections';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    public $timestamps;
}
