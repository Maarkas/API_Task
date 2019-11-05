<?php


namespace App\Http\Controllers;

use App\Interfaces\BetInterface;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BetController extends Controller
{
    /**
     * @var BetInterface
     */
    protected $betRepository;

    public function __construct(BetInterface $betRepository)
    {
        $this->betRepository = $betRepository;
    }

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @return void
     */
    public function bet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => 'required|numeric',
            'stake_amount' => 'required|json|between:0.3,10000',
            'selections' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->getMessageBag());
        }

        $bet = $this->betRepository->makeBet($request->all());
        return response()->json($bet);
    }
}
