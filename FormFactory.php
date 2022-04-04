<?php
declare(strict_types=1);

namespace IAmPedroPiedade\Concrete5\Symfony\Form;

use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\FormExtensionInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use Symfony\Component\Security\Csrf\TokenStorage\SessionTokenStorage;
use Symfony\Component\Validator\Validation;

/**
 * Class Form
 * @package IAmPedroPiedade\Concrete5\Symfony\Form
 */
class FormFactory
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * FormFactory constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @var FormExtensionInterface[]
     */
    private $formExtensions = [];

    /**
     * Add form extensions used within the createFormFactoryBuilder
     *
     * @param FormExtensionInterface $formExtension
     * @return FormFactory
     */
    public function addFormExtension(FormExtensionInterface $formExtension): FormFactory
    {
        $this->formExtensions[] = $formExtension;

        return $this;
    }

    public function createFormFactory(): FormFactoryInterface
    {
        $csrfGenerator = new UriSafeTokenGenerator();
        $csrfStorage = new SessionTokenStorage($this->session);
        $csrfManager = new CsrfTokenManager($csrfGenerator, $csrfStorage);

        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();

        // need to update the below to use C5 translations
        $translator = new \Symfony\Component\Translation\Translator('en_US');
        $translatorHelper = new TranslatorHelper($translator);

        $forms = Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->addExtension(new CsrfExtension($csrfManager))
            ->addExtension(new ValidatorExtension($validator));

        foreach ($this->formExtensions as $formExtension) {
            $forms->addExtension($formExtension);
        }

        return $forms->getFormFactory();
    }
}
