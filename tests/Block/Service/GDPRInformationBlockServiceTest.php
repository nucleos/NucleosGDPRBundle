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

namespace Nucleos\GDPRBundle\Tests\Block\Service;

use Nucleos\GDPRBundle\Block\Service\GDPRInformationBlockService;
use PHPUnit\Framework\MockObject\MockObject;
use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Form\Mapper\FormMapper;
use Sonata\BlockBundle\Model\Block;
use Sonata\BlockBundle\Test\BlockServiceTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

final class GDPRInformationBlockServiceTest extends BlockServiceTestCase
{
    /**
     * @var MockObject&RequestStack
     */
    private RequestStack $requestStack;

    private Request $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new Request();

        $this->requestStack = $this->createMock(RequestStack::class);
        $this->requestStack->method('getMainRequest')
            ->willReturn($this->request)
        ;
    }

    public function testDefaultSettings(): void
    {
        $blockService = new GDPRInformationBlockService($this->twig, $this->requestStack);
        $blockContext = $this->getBlockContext($blockService);

        $this->assertSettings([
            'text'            => null,
            'url'             => 'https://gdpr-info.eu/',
            'template'        => '@NucleosGDPR/Block/block_gdpr.html.twig',
            'position'        => 'block',
        ], $blockContext);
    }

    public function testExecute(): void
    {
        $block = new Block();

        $blockContext = new BlockContext($block, [
            'text'            => null,
            'url'             => 'https://gdpr-info.eu/',
            'template'        => '@NucleosGDPR/Block/block_gdpr.html.twig',
            'position'        => 'block',
        ]);

        $response = new Response();

        $this->twig->expects(self::once())->method('render')
            ->with(
                '@NucleosGDPR/Block/block_gdpr.html.twig',
                [
                    'context'    => $blockContext,
                    'settings'   => $blockContext->getSettings(),
                    'block'      => $blockContext->getBlock(),
                ]
            )
            ->willReturn('TWIG_CONTENT')
        ;

        $blockService = new GDPRInformationBlockService($this->twig, $this->requestStack);

        self::assertSame($response, $blockService->execute($blockContext, $response));
        self::assertSame('TWIG_CONTENT', $response->getContent());
    }

    public function testExecuteWithExistingCookie(): void
    {
        $this->request->cookies->set(GDPRInformationBlockService::COOKIE_NAME, 'true');

        $block = new Block();

        $blockContext = new BlockContext($block, [
            'text'            => null,
            'url'             => 'https://gdpr-info.eu/',
            'template'        => '@NucleosGDPR/Block/block_gdpr.html.twig',
            'position'        => 'block',
        ]);

        $blockService = new GDPRInformationBlockService($this->twig, $this->requestStack);
        $response     = $blockService->execute($blockContext);

        self::assertTrue($response->isEmpty());
    }

    public function testGetMetadata(): void
    {
        $blockService = new GDPRInformationBlockService($this->twig, $this->requestStack);

        $metadata = $blockService->getMetadata();

        self::assertSame('nucleos_gdpr.block.information', $metadata->getTitle());
        self::assertNull($metadata->getImage());
        self::assertSame('NucleosGDPRBundle', $metadata->getDomain());
        self::assertSame([
            'class' => 'fa fa-balance-scale',
        ], $metadata->getOptions());
    }

    public function testConfigureEditForm(): void
    {
        $blockService = new GDPRInformationBlockService($this->twig, $this->requestStack);

        $block = new Block();

        $formMapper = $this->createMock(FormMapper::class);
        $formMapper->expects(self::once())->method('add');

        $blockService->configureEditForm($formMapper, $block);
    }
}
