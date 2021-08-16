<?php

namespace Elective\CacheBundle\Utils;


/**
 * Elective\CacheBundle\Utils\CacheTag
 *
 * @author Chris Dixon <chris@electivegroup.com>
 */
class CacheTag
{
    /**
     * Gets Cache tag
     *
     * @param $modelName    string
     * @param $organisation     string
     * @param $id     string
     * @return array
     */
    public static function getCacheTags(string $organisation, string $modelName, string $id = ''): array
    {
        $organisationTag = $organisation . $modelName;

        $tags = [$organisationTag];

        if ($id !== ''){
            $tags[] = $organisationTag . $id;
        }

        return $tags;
    }
}
