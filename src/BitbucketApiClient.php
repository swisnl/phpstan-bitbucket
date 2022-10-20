<?php

namespace Alxt\PHPStan\ErrorFormatter;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class BitbucketApiClient
{
    /**
     * Please note this should be http instead of https because of the proxy.
     */
    private const BASE_URL = 'http://api.bitbucket.org/2.0/';
    private const PROXY_URL = 'http://localhost:29418';

    private const REPORT_TITLE = 'PHPStan Report';

    private Client $httpClient;

    public function __construct(string $baseUrl = self::BASE_URL, string $proxyUrl = self::PROXY_URL)
    {
        $this->httpClient = new Client([
            'base_uri' => $baseUrl,
            RequestOptions::PROXY => $proxyUrl,
        ]);
    }

    public function createReport(int $numberOfIssues = 0): UuidInterface
    {
        $payload = $numberOfIssues > 0
            ? [
                'title' => self::REPORT_TITLE,
                'details' => sprintf('This PR introduces %d new issue(s).', $numberOfIssues),
                'report_type' => 'BUG',
                'result' => 'FAILED',
            ]
            : [
                'title' => self::REPORT_TITLE,
                'details' => 'This PR introduces no new issues.',
                'report_type' => 'BUG',
                'result' => 'PASSED',
            ];

        $result = $this->httpClient->put($this->buildReportUrl(), [
            RequestOptions::JSON => $payload,
        ]);

        $resultBody = json_decode((string) $result->getBody(), true);

        return Uuid::fromString($resultBody['uuid']);
    }

    public function addAnnotation(
        UuidInterface $reportUuid,
        string $summary,
        ?string $filePath,
        ?int $line
    ): UuidInterface {
        $payload = [
            'annotation_type' => 'BUG',
            'summary' => $summary,
        ];

        if ($filePath !== null) {
            $payload['path'] = $filePath;
        }

        if ($line !== null) {
            $payload['line'] = $line;
        }

        $response = $this->httpClient->put($this->buildAnnotationUrl($reportUuid), [
            RequestOptions::JSON => $payload,
        ]);

        $responseBody = json_decode((string) $response->getBody(), true);

        return Uuid::fromString($responseBody['uuid']);
    }

    private function buildReportUrl(?UuidInterface $uuid = null): string
    {
        return sprintf(
            'repositories/%s/%s/commit/%s/reports/%s',
            BitbucketConfig::repoOwner(),
            BitbucketConfig::repoSlug(),
            BitbucketConfig::commit(),
            $uuid !== null ? '{'.$uuid->toString().'}' : $this->buildReportName()
        );
    }

    private function buildAnnotationUrl(UuidInterface $reportUuid): string
    {
        return sprintf(
            '%s/annotations/%s',
            $this->buildReportUrl($reportUuid),
            $this->buildAnnotationName()
        );
    }

    private function buildReportName(): string
    {
        return BitbucketConfig::repoSlug().'-'.Uuid::uuid4()->toString();
    }

    private function buildAnnotationName(): string
    {
        return BitbucketConfig::repoSlug().'-annotation-'.Uuid::uuid4()->toString();
    }
}
