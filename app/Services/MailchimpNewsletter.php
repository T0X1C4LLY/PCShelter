<?php

namespace App\Services;

use App\Services\Interfaces\Newsletter;
use MailchimpMarketing\ApiClient;

class MailchimpNewsletter implements Newsletter
{
    private readonly mixed $list;

    public function __construct(protected ApiClient $client)
    {
        $this->list = config('services.mailchimp.lists.subscribers');
    }

    public function subscribe(string $email, string $list = null): mixed
    {
        $list ??= $this->list;

        /** @phpstan-ignore-next-line */
        return $this->client->lists->addListMember($list, [
            'email_address' => $email,
            'status' => 'subscribed'
        ]);
    }

    public function unsubscribe(string $email, string $list = null): void
    {
        $list ??= $this->list;

        /** @phpstan-ignore-next-line */
        $this->client->lists->deleteListMember($list, $email);
    }

    public function getAllSubscribers(): \stdClass
    {
        /** @phpstan-ignore-next-line */
        return $this->client->lists->getListMembersInfo($this->list);
    }
}
