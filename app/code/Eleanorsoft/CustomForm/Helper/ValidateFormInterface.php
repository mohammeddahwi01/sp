<?php

namespace Eleanorsoft\CustomForm\Helper;


/**
 * Interface ValidateFormInterface
 *
 * @package Eleanorsoft\CustomForm\Helper
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

interface ValidateFormInterface
{

    const MESSAGE_SUCCESS = 'Thanks for contacting us with your comments and questions. We\'ll respond to you very soon.';
    const MESSAGE_ERROR = 'We can\'t process your request right now. Sorry, that\'s all we know.';
    const HANDLE_ERROR_STATUS_CODE = 20180117;
    /**
     * Validating form data
     *
     * @param $data
     * @return mixed
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    public function validate($data);
}