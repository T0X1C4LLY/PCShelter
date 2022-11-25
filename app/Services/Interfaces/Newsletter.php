<?php

namespace App\Services\Interfaces;

use stdClass;

interface Newsletter
{
    public function subscribe(string $email, string $list = null): mixed;

    public function unsubscribe(string $email, string $list = null): void;

    public function getAllSubscribers(): stdClass;
}
