<?php
declare(strict_types=1);

namespace IAmPedroPiedade\Concrete5\Symfony\Form;

use Symfony\Component\Templating\Helper\Helper;

/**
 * Class TranslatorHelper
 * @package IAmPedroPiedade\Concrete5\Symfony\Form
 */
class TranslatorHelper extends Helper
{
    /**
     * @param $id
     * @param array $parameters
     * @param string $domain
     * @param null $locale
     * @return string
     */
    public function trans($id, array $parameters = [], $domain = 'messages', $locale = null): string
    {
        return t($id);
    }

    /**
     * @param $id
     * @param $number
     * @param array $parameters
     * @param string $domain
     * @param null $locale
     * @return string
     */
    public function transChoice($id, $number, array $parameters = [], $domain = 'messages', $locale = null): string
    {
        return t($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'translator';
    }
}
