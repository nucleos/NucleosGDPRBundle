<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\GDPRBundle\Tests\Block\Service;

use Core23\GDPRBundle\Block\Service\GDPRInformationBlockService;
use PHPUnit\Framework\MockObject\MockObject;
use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Form\Mapper\FormMapper;
use Sonata\BlockBundle\Model\Block;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Test\BlockServiceTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class GDPRInformationBlockServiceTest extends BlockServiceTestCase
{
    /**
     * @var MockObject|RequestStack
     */
    private $requestStack;

    /**
     * @var Request
     */
    private $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new Request();

        $this->requestStack = $this->createMock(RequestStack::class);
        $this->requestStack->method('getMasterRequest')
            ->willReturn($this->request)
        ;
    }

    public function testDefaultSettings(): void
    {
        $blockService = new GDPRInformationBlockService('block.service', $this->templating, $this->requestStack);
        $blockContext = $this->getBlockContext($blockService);

        $this->assertSettings([
            'text'            => null,
            'url'             => 'https://gdpr-info.eu/',
            'template'        => '@Core23GDPR/Block/block_gdpr.html.twig',
            'position'        => 'block',
        ], $blockContext);
    }

    public function testExecute(): void
    {
        $block = new Block();

        $blockContext = new BlockContext($block, [
            'text'            => null,
            'url'             => 'https://gdpr-info.eu/',
            'template'        => '@Core23GDPR/Block/block_gdpr.html.twig',
            'position'        => 'block',
        ]);

        $blockService = new GDPRInformationBlockService('block.service', $this->templating, $this->requestStack);
        $blockService->execute($blockContext);

        static::assertSame('@Core23GDPR/Block/block_gdpr.html.twig', $this->templating->view);

        static::assertSame($blockContext, $this->templating->parameters['context']);
        static::assertIsArray($this->templating->parameters['settings']);
        static::assertInstanceOf(BlockInterface::class, $this->templating->parameters['block']);
    }

    public function testExecuteWithExistingCookie(): void
    {
        $this->request->cookies->set(GDPRInformationBlockService::COOKIE_NAME, true);

        $block = new Block();

        $blockContext = new BlockContext($block, [
            'text'            => null,
            'url'             => 'https://gdpr-info.eu/',
            'template'        => '@Core23GDPR/Block/block_gdpr.html.twig',
            'position'        => 'block',
        ]);

        $blockService = new GDPRInformationBlockService('block.service', $this->templating, $this->requestStack);
        $response     = $blockService->execute($blockContext);

        static::assertTrue($response->isEmpty());
    }

    public function testGetMetadata(): void
    {
        $blockService = new GDPRInformationBlockService('block.service', $this->templating, $this->requestStack);

        $metadata = $blockService->getMetadata();

        static::assertSame('block.service', $metadata->getTitle());
        static::assertNotNull($metadata->getImage());
        static::assertStringStartsWith('data:image/png;base64,', $metadata->getImage() ?? '');
        static::assertSame('Core23GDPRBundle', $metadata->getDomain());
        static::assertSame([
            'class' => 'fa fa-balance-scale',
        ], $metadata->getOptions());
    }

    public function testConfigureEditForm(): void
    {
        $blockService = new GDPRInformationBlockService('block.service', $this->templating, $this->requestStack);

        $block = new Block();

        $formMapper = $this->createMock(FormMapper::class);
        $formMapper->expects(static::once())->method('add');

        $blockService->configureEditForm($formMapper, $block);
    }
}
