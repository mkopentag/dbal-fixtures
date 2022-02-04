<?php

declare(strict_types=1);

namespace ComPHPPuebla\Fixtures\Loaders;

final class CachingYamlLoader implements Loader
{
    /** @var Loader */
    private $decorated;
    /** @var array */
    private static $cache = [];

    public function __construct(Loader $decorated)
    {
        $this->decorated = $decorated;
    }

    public function load(string $path): array
    {
        if (!isset(self::$cache[$path])) {
            self::$cache[$path] = $this->decorated->load($path);
        }

        return self::$cache[$path];
    }
}
