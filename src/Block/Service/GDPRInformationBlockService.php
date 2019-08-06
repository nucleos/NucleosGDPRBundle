<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\GDPRBundle\Block\Service;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Block\Service\EditableBlockService;
use Sonata\BlockBundle\Form\Mapper\FormMapper;
use Sonata\BlockBundle\Meta\Metadata;
use Sonata\BlockBundle\Meta\MetadataInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\Form\Type\ImmutableArrayType;
use Sonata\Form\Validator\ErrorElement;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class GDPRInformationBlockService extends AbstractBlockService implements EditableBlockService
{
    public const COOKIE_NAME = 'GDPR_COOKIE_LAW_CONSENT';

    /**
     * @var RequestStack
     */
    private $request;

    public function __construct(string $name, EngineInterface $templating, RequestStack $request)
    {
        parent::__construct($name, $templating);

        $this->request = $request;
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        if ($this->hasGdprCookie()) {
            return new Response('', Response::HTTP_NO_CONTENT);
        }

        $parameters = [
            'context'  => $blockContext,
            'settings' => $blockContext->getSettings(),
            'block'    => $blockContext->getBlock(),
        ];

        return $this->renderPrivateResponse($blockContext->getTemplate(), $parameters, $response);
    }

    public function configureCreateForm(FormMapper $form, BlockInterface $block): void
    {
        $this->configureEditForm($form, $block);
    }

    public function configureEditForm(FormMapper $formMapper, BlockInterface $block): void
    {
        $formMapper->add('settings', ImmutableArrayType::class, [
            'keys' => [
                ['text', TextType::class, [
                    'label'    => 'form.label_text',
                    'required' => false,
                ]],
                ['url', UrlType::class, [
                    'label'    => 'form.label_url',
                    'required' => false,
                ]],
                ['position', ChoiceType::class, [
                    'label'   => 'form.label_position',
                    'choices' => [
                        'form.choice_top'      => 'top',
                        'form.choice_fixedtop' => 'fixedtop',
                        'form.choice_bottom'   => 'bottom',
                        'form.choice_block'    => 'block',
                    ],
                ]],
            ],
            'translation_domain' => 'Core23GDPRBundle',
        ]);
    }

    public function configureSettings(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'text'            => null,
            'url'             => 'https://gdpr-info.eu/',
            'template'        => '@Core23GDPR/Block/block_gdpr.html.twig',
            'position'        => 'block',
        ]);
    }

    public function validate(ErrorElement $errorElement, BlockInterface $block): void
    {
    }

    public function getMetadata(): MetadataInterface
    {
        return new Metadata($this->getName(), null, null, 'Core23GDPRBundle', [
            'class' => 'fa fa-balance-scale',
        ]);
    }

    private function hasGdprCookie(): bool
    {
        $request = $this->request->getMasterRequest();

        return null !== $request && $request->cookies->getBoolean(self::COOKIE_NAME);
    }
}
