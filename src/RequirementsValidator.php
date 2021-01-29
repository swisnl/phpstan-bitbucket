<?php

namespace Alxt\PHPStan\ErrorFormatter;

class RequirementsValidator
{
    public static function validate(): void
    {
        self::assertEnvVariable('BITBUCKET_REPO_OWNER');
        self::assertEnvVariable('BITBUCKET_REPO_SLUG');
        self::assertEnvVariable('BITBUCKET_COMMIT');
        self::assertEnvVariable('BITBUCKET_CLONE_DIR');
    }

    private static function raiseError(): void
    {
        throw new \RuntimeException('This extension can only be used within a Bitbucket Pipeline.');
    }

    private static function assertEnvVariable(string $variable): void
    {
        if (getenv($variable) === false) {
            self::raiseError();
        }
    }
}