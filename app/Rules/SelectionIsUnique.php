<?php

namespace App\Rules;

class SelectionIsUnique
{
    /**
     * Description: Validate selections minimum odds
     *
     * @param $selections
     * @return mixed
     */
    public function validate($selections)
    {
        $error = null;
        if (count($selections) !== count(array_unique($selections, SORT_REGULAR))) {
            $error = ['code' => 8, 'message' => 'Selections must be unique'];
        }
        return $error;
    }
}
