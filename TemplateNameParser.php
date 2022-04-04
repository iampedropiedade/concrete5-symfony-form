<?php
namespace IAmPedroPiedade\Concrete5\Symfony\Form;

use Symfony\Component\Templating\TemplateNameParser as BaseTemplateNameParser;
use Symfony\Component\Templating\TemplateReferenceInterface;

/**
 * Class TemplateNameParser
 * @package IAmPedroPiedade\Concrete5\Symfony\Form
 */
class TemplateNameParser extends BaseTemplateNameParser
{
    /**
     * {@inheritdoc}
     */
    public function parse($name): TemplateReferenceInterface
    {
        if ($name instanceof TemplateReferenceInterface) {
            return $name;
        }

        $location = null;
        if (false !== $pos = strrpos($name, ':')) {
            $location = substr($name, 0, $pos);
            $name = substr($name, $pos + 1);
        }

        $engine = null;
        if (false !== $pos = strrpos($name, '.')) {
            $engine = substr($name, $pos + 1);
        }

        return new TemplateReference($location, $name, $engine);
    }
}
