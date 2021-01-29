<?php

namespace Alxt\PHPStan\ErrorFormatter;

use PHPStan\Command\AnalysisResult;
use PHPStan\Command\ErrorFormatter\ErrorFormatter;
use PHPStan\Command\Output;
use PHPStan\File\ParentDirectoryRelativePathHelper;

class BitbucketErrorFormatter implements ErrorFormatter
{
    private $relativePathHelper;
    private $apiClient;

    public function __construct()
    {
        RequirementsValidator::validate();

        $this->relativePathHelper = new ParentDirectoryRelativePathHelper(getenv('BITBUCKET_CLONE_DIR'));
        $this->apiClient = new BitbucketApiClient();
    }

    public function formatErrors(AnalysisResult $analysisResult, Output $output): int
    {
        $reportUuid = $this->apiClient->createReport($analysisResult->getTotalErrorsCount());

        foreach ($analysisResult->getFileSpecificErrors() as $error) {
            $this->apiClient->addAnnotation(
                $reportUuid,
                $error->getMessage(),
                $this->relativePathHelper->getRelativePath($error->getFile()),
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