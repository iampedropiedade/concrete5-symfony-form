<?php
declare(strict_types=1);

namespace IAmPedroPiedade\Concrete5\Symfony\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FileManagerType
 * @package IAmPedroPiedade\Concrete5\Symfony\Form
 */
class FileManagerType extends AbstractType
{
    public const FILE_MANAGER_TYPE_APP = 'APP';
    public const FILE_MANAGER_TYPE_AUDIO = 'AUDIO';
    public const FILE_MANAGER_TYPE_DOC = 'DOC';
    public const FILE_MANAGER_TYPE_FILE = 'FILE';
    public const FILE_MANAGER_TYPE_IMAGE = 'IMAGE';
    public const FILE_MANAGER_TYPE_TEXT = 'TEXT';
    public const FILE_MANAGER_TYPE_VIDEO = 'VIDEO';

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'compound' => false,
            'file_manager_type' => self::FILE_MANAGER_TYPE_FILE,
            'file_manager_args' => [],
        ]);

        $resolver->setAllowedValues('file_manager_type', [
            self::FILE_MANAGER_TYPE_APP,
            self::FILE_MANAGER_TYPE_AUDIO,
            self::FILE_MANAGER_TYPE_DOC,
            self::FILE_MANAGER_TYPE_FILE,
            self::FILE_MANAGER_TYPE_IMAGE,
            self::FILE_MANAGER_TYPE_TEXT,
            self::FILE_MANAGER_TYPE_VIDEO
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['file_manager_type'] = $options['file_manager_type'];
        $view->vars['file_manager_args'] = $options['file_manager_args'];

        parent::buildView($view, $form, $options);
    }


    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'file_manager';
    }
}

