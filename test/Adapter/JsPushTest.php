<?php

/**
 * @see       https://github.com/laminas/laminas-progressbar for the canonical source repository
 * @copyright https://github.com/laminas/laminas-progressbar/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-progressbar/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ProgressBar\Adapter;

use LaminasTest\ProgressBar\TestAsset\JsPushStub;
use PHPUnit\Framework\TestCase;

/**
 * @group      Laminas_ProgressBar
 */
class JsPushTest extends TestCase
{
    public function testJson()
    {
        $result = [];

        $adapter = new JsPushStub(['finishMethodName' => 'Laminas\ProgressBar\ProgressBar\Finish']);
        $adapter->notify(0, 2, 0.5, 1, 1, 'status');
        $output = $adapter->getLastOutput();

        $matches = preg_match('#<script type="text/javascript">parent.'
            . preg_quote('Laminas\\ProgressBar\\ProgressBar\\Update') . '\((.*?)\);</script>#', $output, $result);
        $this->assertEquals(1, $matches);

        $data = json_decode($result[1], true);

        $this->assertEquals(0, $data['current']);
        $this->assertEquals(2, $data['max']);
        $this->assertEquals(50, $data['percent']);
        $this->assertEquals(1, $data['timeTaken']);
        $this->assertEquals(1, $data['timeRemaining']);
        $this->assertEquals('status', $data['text']);

        $adapter->finish();
        $output = $adapter->getLastOutput();

        $matches = preg_match('#<script type="text/javascript">parent.'
            . preg_quote('Laminas\ProgressBar\ProgressBar\Finish') . '\(\);</script>#', $output, $result);
        $this->assertEquals(1, $matches);
    }
}
