<?php

declare(strict_types=1);

namespace Fever\Infrastructure\ProviderClient;

use DateTimeImmutable;
use Fever\Domain\ProviderClient;

class AcmeProviderClient extends XMLProviderClient implements ProviderClient
{
    const DATE_FORMAT = 'Y-m-d\TH:i:s';
    private const COMPANY_ID = '1';

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function events(): iterable
    {
        try {
            $elements = $this->fetchElements();
        } catch (ProviderClientException $e) {
            return [];
        }

        if (!isset($elements['output'])) {
            return [];
        }

        $baseEvents = $elements['output']['base_event'];
        $events = [];
        foreach ($baseEvents as $event) {
            if (isset($event['@attributes']['sell_mode']) && 'online' === $event['@attributes']['sell_mode']) {
                $events[] = $this->buildEventFromPayload($event);
            }
        }

        return $events;
    }

    private function buildEventFromPayload(array $payload): EventDTO
    {
        $minPrice = PHP_INT_MAX;
        $maxPrice = PHP_INT_MIN;

        $start = $payload['event']['@attributes']['event_start_date'];
        $end = $payload['event']['@attributes']['event_end_date'];

        foreach ($payload['event']['zone'] as $zone) {
            $price = isset($zone['@attributes']) ? $zone['@attributes']['price'] : $zone['price'];
            $minPrice = min($minPrice, floatval($price));
            $maxPrice = max($maxPrice, floatval($price));
        }

        return new EventDTO(
            $payload['@attributes']['title'],
            $payload['@attributes']['base_event_id'],
            self::COMPANY_ID,
            DateTimeImmutable::createFromFormat(self::DATE_FORMAT, $start),
            DateTimeImmutable::createFromFormat(self::DATE_FORMAT, $end),
            $minPrice,
            $maxPrice
        );
    }
}
