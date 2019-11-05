<?php

namespace App\Rules;

use App\Selection;

class SelectionMaxOdds
{
    /**
     * Description: Validate selections maximum odds
     *
     * @param $selections
     * @return mixed
     */
    public function validate($selections)
    {
        foreach($selections as $selection) {
            if (!$selection['odds'] || $selection['odds'] <= Selection::MAX_ODDS) {
                $selection['errors'] = ['code' => 6, 'message' => 'This selection maximum odds are ' . Selection::MAX_ODDS];
            }
        }
        return $selections;
    }
}
