<?php

namespace App\Services;

use MailchimpMarketing\ApiClient;

class MailchimpNewsletter implements NewsletterInterface
{
    public function __construct(protected ApiClient $client)
    {
    }

    public function subscribe(string $email, string $list = null): mixed
    {
        $list ??= config('services.mailchimp.lists.subscribers');
        /** @phpstan-ignore-next-line */
        return $this->client->lists->addListMember($list, [
            'email_address' => $email,
            'status' => 'subscribed'
        ]);
    }

    public function getAllSubscribers(): \stdClass
    {
        $list = config('services.mailchimp.lists.subscribers');
        /** @phpstan-ignore-next-line */
        return $this->client->lists->getListMembersInfo($list);
    }
}
