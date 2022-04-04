<?php
declare(strict_types=1);

namespace IAmPedroPiedade\Concrete5\Symfony\Form;

use Symfony\Component\Templating\Helper\HelperInterface;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Form\FormRenderer as SymfonyFormRenderer;

class FormRenderer
{
    /**
     * @var PhpEngine
     */
    private $engine;

    /**
     * @var FormHelper
     */
    private $formHelper;

    /**
     * @var SymfonyFormRenderer
     */
    private $renderer;

    /**
     * @var HelperInterface[]
     */
    private $helpers = [];


    private $templatePaths = [
        __DIR__ . '/src/Resources/views/Form'
    ];

    public function __construct()
    {
        $loader = new FilesystemLoader(array());
        $this->engine = new PhpEngine(new TemplateNameParser(), $loader);
    }

    /**
     * Add a template path where you form input template resides
     *
     * @param string $path
     *
     * @return FormRenderer
     */
    public function addTemplatePath(string $path): FormRenderer
    {
        $this->templatePaths[] = $path;

        return $this;
    }

    /**
     * Add helpers used within the PHP engine
     *
     * @param HelperInterface $helper
     * @return FormRenderer
     */
    public function addHelpers(HelperInterface $helper): FormRenderer
    {
        $this->helpers[] = $helper;

        return $this;
    }

    /**
     * @return $this
     */
    final public function build(): FormRenderer
    {
        $rendererEngine = new TemplatingRendererEngine($this->engine, $this->templatePaths);
        $this->renderer = new SymfonyFormRenderer($rendererEngine);
        $this->formHelper = new FormHelper($this->renderer);
        $translatorHelper = new TranslatorHelper();

        $helpers = array_merge($this->helpers, [$this->formHelper, $translatorHelper]);

        $this->engine->addHelpers($helpers);

        return $this;
    }

    /**
     * @return FormHelper
     */
    public function getFormHelper(): FormHelper
    {
        return $this->formHelper;
    }

    /**
     * @return SymfonyFormRenderer
     */
    public function getFormRenderer(): SymfonyFormRenderer
    {
        return $this->renderer;
    }
}
