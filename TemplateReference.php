<?php
declare(strict_types=1);

namespace IAmPedroPiedade\Concrete5\Symfony\Form;

use Symfony\Component\Templating\TemplateReferenceInterface;

/**
 * Class TemplateReference
 * @package IAmPedroPiedade\Concrete5\Symfony\Form
 */

class TemplateReference implements TemplateReferenceInterface
{
    /**
     * @var []
     */
    protected $parameters;

    /**
     * TemplateReference constructor.
     * @param null $location
     * @param null $name
     * @param null $engine
     */
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
    public function __toString(): string
    {
        return $this->getLogicalName();
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value): self
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
    public function all(): array
    {
        return $this->parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return $this->parameters['location'] . '/' . $this->parameters['name'];
    }

    /**
     * {@inheritdoc}
     */
    public function getLogicalName(): string
    {
        return $this->parameters['location'] . ':' . $this->parameters['name'];
    }
}
