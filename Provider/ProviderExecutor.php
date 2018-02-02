<?php
/**
 * Created by PhpStorm.
 * User: wangyibo
 * Date: 30/11/2017
 * Time: 11:31
 */

namespace PhpCloud\Framework\Provider;


use DI\ContainerBuilder;
use DI\Definition\Helper\DefinitionHelper;

class ProviderExecutor implements ProviderExecutorInterface
{
    private $container;
    private $input;
    private $entrance;
    private $entranceParameters;

    function __construct(array $containerDefinitions = null)
    {
        $containerBuilder = new ContainerBuilder;
        if (empty($this->container) && !empty($containerDefinitions)) {
            $containerBuilder->addDefinitions($containerDefinitions);
        }
        $this->container = $containerBuilder->build();
    }

    public function addDependencies(array $containerDefinitions)
    {
        foreach ($containerDefinitions as $containerDefinition) {
            $this->addDefinition($containerDefinition);
        }
    }

    /**
     * Define an object or a value in the container.
     *
     * @param string $containerKey Entry name
     * @param mixed|DefinitionHelper $containerValue Value, use definition helpers to define objects
     */
    public function addDefinition($containerKey, $containerValue)
    {
        $this->container->set($containerKey, $containerValue);
    }

    public function setInput(ProviderInput $input)
    {
        $this->input = $input;
        $this->addDefinition(ProviderInput::class, $this->input);
    }

    public function setEntrance($entrance, $parameters = null)
    {
        $this->entrance = $entrance;
        if (!empty($data)) {
            $this->entranceParameters = $parameters;
        }
    }

    public function run($entrance, array $parameters)
    {
        $this->entrance = $entrance;
        if (!empty($data)) {
            $this->entranceParameters = $parameters;
        }

        if (!empty($entrance)) {
            return $this->container->call($entrance, $parameters);
        }
    }
}