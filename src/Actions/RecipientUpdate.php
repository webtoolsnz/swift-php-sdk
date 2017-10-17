<?php

namespace webtoolsnz\Swift\Actions;


/**
 * Class RecipientCreate
 * @package webtoolsnz\Swift\Actions
 */
class RecipientUpdate extends RecipientCreate
{

    /**
     * @return string
     */
    public function getRequestPath()
    {
        return 'recipient/update';
    }

}
