<?php

namespace App\Services;

interface NewsletterInterface
{
    public function subscribe(string $email, string $list = null): mixed;
    public function unsubscribe(string $email, string $list = null): void;
    public function getAllSubscribers(): \stdClass;
}
