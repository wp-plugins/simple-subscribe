<?php

/**
 * This file is part of the Simple Subscribe plugin.
 *
 * Copyright (c) 2013 Martin Pícha (http://latorante.name)
 *
 * For the full copyright and license information, please view
 * the SimpleSubscribe.php file in root directory of this plugin.
 */

namespace SimpleSubscribe;


class RepositoryLog extends Repository
{
    /**
     * Adds log message
     *
     * @param int $type
     * @param $message
     * @return mixed
     */

    public function add($type = 0, $message)
    {
        if($this->settings->getLogStatus()){
            return $this->insert(array('type' => $type, 'message' => $message));
        }
        return FALSE;
    }
}

class RepositaryLogException extends \Exception {}