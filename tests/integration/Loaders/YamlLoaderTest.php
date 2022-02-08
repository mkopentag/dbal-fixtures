<?php
/**
 * PHP version 7.1
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace ComPHPPuebla\Fixtures\Loaders;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Parser;

class YamlLoaderTest extends TestCase
{
    /** @test */
    public function it_reads_and_parses_a_fixture_file()
    {
        $loader = new YamlLoader(new Parser());

        $loadedStates = $loader->load(__DIR__ . '/../../../data/states.yml');

        $this->assertEquals('states', $loadedStates['table']);
        $this->assertEquals([
            'url' => 'puebla',
            'name' => 'Puebla',
        ] , $loadedStates['items']['state_1']);
    }
}
