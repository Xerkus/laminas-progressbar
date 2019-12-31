<?php

/**
 * @see       https://github.com/laminas/laminas-progressbar for the canonical source repository
 * @copyright https://github.com/laminas/laminas-progressbar/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-progressbar/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ProgressBar\Adapter;

use LaminasTest\ProgressBar\TestAsset\JsPullStub;
use PHPUnit\Framework\TestCase;

/**
 * @group      Laminas_ProgressBar
 */
class JsPullTest extends TestCase
{
    public function testJson()
    {
        $adapter = new JsPullStub();
        $adapter->notify(0, 2, 0.5, 1, 1, 'status');
        $output = $adapter->getLastOutput();

        $data = json_decode($output, true);

        $this->assertEquals(0, $data['current']);
        $this->assertEquals(2, $data['max']);
        $this->assertEquals(50, $data['percent']);
        $this->assertEquals(1, $data['timeTaken']);
        $this->assertEquals(1, $data['timeRemaining']);
        $this->assertEquals('status', $data['text']);
        $this->assertFalse($data['finished']);

        $adapter->finish();
        $output = $adapter->getLastOutput();

        $data = json_decode($output, true);

        $this->assertTrue($data['finished']);
    }
}
