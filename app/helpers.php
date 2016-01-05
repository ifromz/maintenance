<?php

use App\Http\Active;
use App\Http\Flash;

/**
 * Generates a session flash message.
 *
 * @param null|string $title
 * @param null|string $message
 *
 * @return null|Flash
 */
function flash($title = null, $message = null)
{
    $flash = new Flash();

    if (func_num_args() === 0) {
        return $flash;
    }

    $flash->info($title, $message);
}

/**
 * Generates a new Active instance.
 *
 * @return Active
 */
function active()
{
    return new Active();
}
