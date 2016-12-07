<?php

/*
 +------------------------------------------------------------------------+
 | Phosphorum                                                             |
 +------------------------------------------------------------------------+
 | Copyright (c) 2013-2016 Phalcon Team and contributors                  |
 +------------------------------------------------------------------------+
 | This source file is subject to the New BSD License that is bundled     |
 | with this package in the file LICENSE.txt.                             |
 |                                                                        |
 | If you did not receive a copy of the license and are unable to         |
 | obtain it through the world-wide-web, please send an email             |
 | to license@phalconphp.com so we can send you a copy immediately.       |
 +------------------------------------------------------------------------+
*/

namespace Phosphorum\Task;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Phosphorum\Console\AbstractTask;

/**
 * Phosphorum\Task\Cache
 *
 * @package Phosphorum\Task
 */
class Cache extends AbstractTask
{
    protected $excludeFileNames = [
        '.',
        '..',
        '.gitkeep',
        '.gitignore',
    ];

    /**
     * Clearing the Application Cache
     */
    public function clear()
    {
        $this->info('Start');
        $this->info('Clear file cache...');

        $this->clearFileCache();

        $this->info('Done');
    }

    protected function clearFileCache()
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(cache_path()),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $entry) {
            if ($entry->isDir() || in_array($entry->getBasename(), $this->excludeFileNames)) {
                continue;
            }

            unlink($entry->getPathname());
        }
    }
}
