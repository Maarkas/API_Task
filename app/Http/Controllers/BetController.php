<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\BetInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BetController extends Controller
{
    private $bet;

    public function __construct(BetInterface $bet)
    {
        $this->bet = $bet;
    }

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    public function bet(Request $request)
    {
        $this->validate($request, [
            'stake_amount' => 'between:0.3,10000',
            'selections' => 'min:1,max:20'
        ]);

        // max win = stake_amount * (selections length * odds)
        return response()->json('success');
    }
}
