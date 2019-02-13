<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 13/02/2019
 * Time: 13:28
 */

namespace App\AliceBundleMethod;

use Nelmio\Alice\Fixtures;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Loader\AbstractLoader;

class UserFixtures extends AbstractLoader
{
    /**
     * {@inheritDoc}
     */
    public function getFixtures()
    {
        return array(
            __DIR__.'/user.yml',
        );
    }

    /**
     * Loads validation metadata into a {@link ClassMetadata} instance.
     *
     * @return bool Whether the loader succeeded
     */
    public function loadClassMetadata(ClassMetadata $metadata)
    {
        // TODO: Implement loadClassMetadata() method.
    }
}