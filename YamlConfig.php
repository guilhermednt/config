<?php

namespace Donato\Configuration;

use Symfony\Component\Yaml\Yaml;

class YamlConfig extends ArrayConfig implements ConfigurationInterface
{

    public function __construct($yamlPath = null)
    {
        $config = $yamlPath ? $this->parse($yamlPath) : [];
        parent::__construct($config);
    }

    private function parse($yamlPath)
    {
        if (!file_exists($yamlPath)) {
            throw new \ErrorException("Config not found");
        }

        return Yaml::parse(file_get_contents($yamlPath));
    }
}
