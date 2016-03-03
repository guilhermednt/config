<?php

namespace Donato\Configuration;

interface ConfigurationInterface
{

    /**
     * @param string $id
     * @return mixed
     */
    public function get($id);

    /**
     *
     * @param string $id
     * @param mixed $value
     */
    public function set($id, $value);
}
