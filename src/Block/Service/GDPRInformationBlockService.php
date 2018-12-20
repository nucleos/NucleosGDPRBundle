<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\GDPRBundle\Block\Service;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractAdminBlockService;
use Sonata\BlockBundle\Meta\Metadata;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\Form\Type\ImmutableArrayType;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class GDPRInformationBlockService extends AbstractAdminBlockService
{
    /**
     * @var RequestStack
     */
    private $request;

    /**
     * @param string          $name
     * @param EngineInterface $templating
     * @param RequestStack    $request
     */
    public function __construct(string $name, EngineInterface $templating, RequestStack $request)
    {
        parent::__construct($name, $templating);

        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        if ($this->hasGdprCookie()) {
            return new Response();
        }

        $parameters = [
            'context'  => $blockContext,
            'settings' => $blockContext->getSettings(),
            'block'    => $blockContext->getBlock(),
        ];

        return $this->renderPrivateResponse($blockContext->getTemplate(), $parameters, $response);
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block): void
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

    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'text'            => null,
            'url'             => 'https://gdpr-info.eu/',
            'template'        => '@Core23GDPR/Block/block_gdpr.html.twig',
            'position'        => 'block',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockMetadata($code = null)
    {
        return new Metadata($this->getName(), $code ?? $this->getName(), null, 'Core23GDPRBundle', [
            'class' => 'fa fa-balance-scale',
        ]);
    }

    /**
     * @return bool
     */
    private function hasGdprCookie(): bool
    {
        $request = $this->request->getMasterRequest();

        return $request && $request->cookies->getBoolean('GDPR_COOKIE_LAW_CONSENT', false);
    }
}
