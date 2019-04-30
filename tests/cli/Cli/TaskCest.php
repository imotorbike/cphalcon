<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Cli\Cli;

use CliTester;
use Phalcon\Registry;
use Phalcon\Test\Fixtures\Traits\DiTrait;

class TaskCest
{
    use DiTrait;

    public function _before(CliTester $I)
    {
        $this->setNewCliFactoryDefault();
    }

    public function testTasks(CliTester $I)
    {
        /**
         * @todo Check the loader
         */
        require_once dataDir('fixtures/tasks/EchoTask.php');
        require_once dataDir('fixtures/tasks/MainTask.php');
        
        $this->container["registry"] = function () {
            $registry = new Registry();

            $registry->data = "data";

            return $registry;
        };

        $task = new \MainTask();

        $task->setDI(
            $this->container
        );

        $I->assertEquals(
            "data",
            $task->requestRegistryAction()
        );

        $I->assertEquals(
            "Hello !",
            $task->helloAction()
        );

        $I->assertEquals(
            "Hello World!",
            $task->helloAction("World")
        );

        $task2 = new \EchoTask();

        $task2->setDI(
            $this->container
        );

        $I->assertEquals(
            "echoMainAction",
            $task2->mainAction()
        );
    }
}
