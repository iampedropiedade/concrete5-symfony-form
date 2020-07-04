<?php

use Symfony\Component\Templating\TemplateReferenceInterface;


class TemplateReference implements TemplateReferenceInterface
{
    protected $parameters;

    public function __construct($location = null, $name = null, $engine = null)
    {
        $this->parameters = array(
            'location' => $location,
            'name' => $name,
            'engine' => $engine,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getLogicalName();
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value)
    {
        if (array_key_exists($name, $this->parameters)) {
            $this->parameters[$name] = $value;
        } else {
            throw new \InvalidArgumentException(sprintf('The template does not support the "%s" parameter.', $name));
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        if (array_key_exists($name, $this->parameters)) {
            return $this->parameters[$name];
        }

        throw new \InvalidArgumentException(sprintf('The template does not support the "%s" parameter.', $name));
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->parameters['location'] . '/' . $this->parameters['name'];
    }

    /**
     * {@inheritdoc}
     */
    public function getLogicalName()
    {
        return $this->parameters['location'] . ':' . $this->parameters['name'];
    }
}
