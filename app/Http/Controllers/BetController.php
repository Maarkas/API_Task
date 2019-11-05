<?php

namespace App\Http\Controllers;

use App\Interfaces\BetInterface;
use App\Rules\SelectionIsUnique;
use App\Rules\SelectionMaxOdds;
use App\Rules\SelectionMinOdds;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BetController extends Controller
{
    /**
     * @var BetInterface
     */
    protected $betRepository;

    /**
     * BetController constructor.
     * @param BetInterface $betRepository
     */
    public function __construct(BetInterface $betRepository)
    {
        $this->betRepository = $betRepository;
    }

    /**
     * Route: /api/bet
     * Method: POST
     *
     * Description: Making bet method
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function bet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => 'required|numeric|min:1',
            'stake_amount' => 'required|json|between:0.3,10000',
            'selections' => ['required', 'array', 'between:1,20'],
        ]);

        $payload = $request->all();
        $payload['errors'] = [];

        $payload['selections'] = (new SelectionMaxOdds())->validate($payload['selections']);
        $payload['selections'] = (new SelectionMinOdds())->validate($payload['selections']);
        $error = (new SelectionIsUnique())->validate($payload['selections']);

        if ($error) {
            array_push($payload['errors'], $error);
        }

        if ($validator->fails()) {
            return Response::json($validator->getMessageBag(), 400);
        }

        $bet = $this->betRepository->makeBet($payload);
        return Response::json($bet, 201);
    }
}
