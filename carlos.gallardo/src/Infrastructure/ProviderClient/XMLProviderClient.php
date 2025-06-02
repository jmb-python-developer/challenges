<?php

declare(strict_types=1);

namespace Fever\Infrastructure\ProviderClient;

abstract class XMLProviderClient
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @throws ProviderClientException
     */
    protected function fetchElements(): iterable
    {
        $xmlContent = @file_get_contents($this->url);
        if (false === $xmlContent) {
            throw ProviderClientException::withUrlNotReachable();
        }

        $xml = @simplexml_load_string($xmlContent);
        if (false === $xml) {
            throw ProviderClientException::withInvalidContent();
        }

        $json = json_encode($xml);
        if (false === $json) {
            throw ProviderClientException::withEncodingError();
        }

        return json_decode($json, true);
    }
}
