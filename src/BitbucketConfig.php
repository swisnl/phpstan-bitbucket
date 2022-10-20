<?php

namespace Alxt\PHPStan\ErrorFormatter;

class BitbucketConfig
{
    public static function repoOwner(): string
    {
        return self::getVariable('BITBUCKET_REPO_OWNER');
    }

    public static function repoSlug(): string
    {
        return self::getVariable('BITBUCKET_REPO_SLUG');
    }

    public static function commit(): string
    {
        return self::getVariable('BITBUCKET_COMMIT');
    }

    public static function cloneDir(): string
    {
        return self::getVariable('BITBUCKET_CLONE_DIR');
    }

    private static function getVariable(string $variable): string
    {
        if (getenv($variable) === false) {
            throw new \RuntimeException('This extension can only be used within a Bitbucket Pipeline.');
        }

        return getenv($variable);
    }
}
