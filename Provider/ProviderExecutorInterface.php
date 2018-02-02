<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 30/11/2017
 * Time: 11:11
 *
 *
 * an Executor must have interface for passing dependency by a common Provider
 */

namespace PhpCloud\Framework\Provider;


interface ProviderExecutorInterface
{
    public function setInput(ProviderInput $input);

    public function addDefinition($containerKey, $containerValue);

    public function run($entrance, array $parameters);
}