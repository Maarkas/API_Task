<?php

namespace App\Rules;

use App\Selection;

class SelectionMinOdds
{
    /**
     * Description: Validate selections minimum odds
     *
     * @param $selections
     * @return mixed
     */
    public function validate($selections)
    {
        foreach($selections as $selection) {
            if (!$selection['odds'] || $selection['odds'] >= Selection::MIN_ODDS) {
                $selection['errors'] = ['code' => 6, 'message' => 'This selection minimum odds are ' . Selection::MIN_ODDS];
            }
        }
        return $selections;
    }
}
