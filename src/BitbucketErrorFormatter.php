<?php

declare(strict_types=1);

namespace Swis\PHPStan\ErrorFormatter;

use PHPStan\Command\AnalysisResult;
use PHPStan\Command\ErrorFormatter\ErrorFormatter;
use PHPStan\Command\ErrorFormatter\TableErrorFormatter;
use PHPStan\Command\Output;
use Swis\Bitbucket\Reports\BitbucketApiClient;

class BitbucketErrorFormatter implements ErrorFormatter
{
    private const REPORT_TITLE = 'PHPStan';

    private TableErrorFormatter $tableErrorFormatter;

    private BitbucketApiClient $apiClient;

    public function __construct(TableErrorFormatter $tableErrorFormatter)
    {
        $this->tableErrorFormatter = $tableErrorFormatter;
        $this->apiClient = new BitbucketApiClient();
    }

    public function formatErrors(AnalysisResult $analysisResult, Output $output): int
    {
        $this->tableErrorFormatter->formatErrors($analysisResult, $output);

        $reportUuid = $this->apiClient->createReport(self::REPORT_TITLE, $analysisResult->getTotalErrorsCount());

        foreach ($analysisResult->getFileSpecificErrors() as $error) {
            $this->apiClient->addAnnotation(
                $reportUuid,
                $error->getMessage(),
                $error->getFile(),
                $error->getLine()
            );
        }

        foreach ($analysisResult->getNotFileSpecificErrors() as $error) {
            $this->apiClient->addAnnotation(
                $reportUuid,
                $error,
                null,
                null
            );
        }

        return (int) $analysisResult->hasErrors();
    }
}
