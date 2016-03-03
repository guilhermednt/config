<?php

namespace Donato\Configuration;

class ArrayConfig implements ConfigurationInterface
{
    /** @var array */
    private $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function get($id)
    {
        return $this->getRecursive($this->sanitizeId($id), $this->config);
    }

    public function set($id, $value)
    {
        $this->setRecursive($this->sanitizeId($id), $value, $this->config);
    }

    private function getRecursive($id, array $config)
    {
        $ids  = explode('.', $id, 2);
        $head = $ids[0];
        $tail = isset($ids[1]) ? $ids[1] : null;

        if (array_key_exists($head, $config)) {
            $current = $config[$head];
            if (!$tail) {
                return $current;
            }
            if (is_array($current)) {
                return $this->getRecursive($tail, $current);
            }
        }

        return null;
    }

    private function setRecursive($id, $value, array &$config)
    {
        $ids  = explode('.', $id, 2);
        $head = $ids[0];
        $tail = isset($ids[1]) ? $ids[1] : null;

        if (array_key_exists($head, $config)) {
            $current = &$config[$head];
            if (!$tail) {
                return $config[$head] = $value;
            }
            if (is_array($current)) {
                return $this->setRecursive($tail, $value, $current);
            }
        } elseif ($tail) {
            return $config[$head] = $this->setRecursive($tail, $value, $config);
        } else {
            return $config[$head] = $value;
        }
    }

    private function sanitizeId($id)
    {
        return trim($id, " .\t\n\r\0\x0B");
    }
}
