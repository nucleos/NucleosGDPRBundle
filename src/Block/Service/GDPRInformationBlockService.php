<?php

declare(strict_types=1);

/*
 * This file is part of the NucleosGDPRBundle package.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\GDPRBundle\Block\Service;

use LogicException;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Block\Service\EditableBlockService;
use Sonata\BlockBundle\Form\Mapper\FormMapper;
use Sonata\BlockBundle\Meta\Metadata;
use Sonata\BlockBundle\Meta\MetadataInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\Form\Type\ImmutableArrayType;
use Sonata\Form\Validator\ErrorElement;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

final class GDPRInformationBlockService extends AbstractBlockService implements EditableBlockService
{
    public const COOKIE_NAME = 'GDPR_COOKIE_LAW_CONSENT';

    /**
     * @var RequestStack
     */
    private $request;

    public function __construct(Environment $twig, RequestStack $request)
    {
        parent::__construct($twig);

        $this->request = $request;
    }

    public function execute(BlockContextInterface $blockContext, ?Response $response = null): Response
    {
        if ($this->hasGdprCookie()) {
            return new Response('', Response::HTTP_NO_CONTENT);
        }

        $parameters = [
            'context'  => $blockContext,
            'settings' => $blockContext->getSettings(),
            'block'    => $blockContext->getBlock(),
        ];

        if (!\is_string($blockContext->getTemplate())) {
            throw new LogicException('Cannot render block without template');
        }

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
            'translation_domain' => 'NucleosGDPRBundle',
        ]);
    }

    public function configureSettings(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'text'            => null,
            'url'             => 'https://gdpr-info.eu/',
            'template'        => '@NucleosGDPR/Block/block_gdpr.html.twig',
            'position'        => 'block',
        ]);
    }

    public function validate(ErrorElement $errorElement, BlockInterface $block): void
    {
    }

    public function getMetadata(): MetadataInterface
    {
        return new Metadata('nucleos_gdpr.block.information', null, null, 'NucleosGDPRBundle', [
            'class' => 'fa fa-balance-scale',
        ]);
    }

    public function getName(): string
    {
        return $this->getMetadata()->getTitle();
    }

    private function hasGdprCookie(): bool
    {
        $request = $this->request->getMasterRequest();

        return null !== $request && $request->cookies->getBoolean(self::COOKIE_NAME);
    }
}
