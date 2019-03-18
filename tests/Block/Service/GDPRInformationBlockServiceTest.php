<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\GDPRBundle\Tests\Block\Service;

use Core23\GDPRBundle\Block\Service\GDPRInformationBlockService;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Model\Block;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Test\AbstractBlockServiceTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class GDPRInformationBlockServiceTest extends AbstractBlockServiceTestCase
{
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

        $this->assertSame('@Core23GDPR/Block/block_gdpr.html.twig', $this->templating->view);

        $this->assertSame($blockContext, $this->templating->parameters['context']);
        $this->assertInternalType('array', $this->templating->parameters['settings']);
        $this->assertInstanceOf(BlockInterface::class, $this->templating->parameters['block']);
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

        $this->assertTrue($response->isEmpty());
    }

    public function testGetBlockMetadata(): void
    {
        $blockService = new GDPRInformationBlockService('block.service', $this->templating, $this->requestStack);

        $metadata = $blockService->getBlockMetadata('description');

        $this->assertSame('block.service', $metadata->getTitle());
        $this->assertSame('description', $metadata->getDescription());
        $this->assertNotNull($metadata->getImage());
        $this->assertStringStartsWith('data:image/png;base64,', $metadata->getImage() ?? '');
        $this->assertSame('Core23GDPRBundle', $metadata->getDomain());
        $this->assertSame([
            'class' => 'fa fa-balance-scale',
        ], $metadata->getOptions());
    }

    public function testBuildEditForm(): void
    {
        $blockService = new GDPRInformationBlockService('block.service', $this->templating, $this->requestStack);

        $block = new Block();

        $formMapper = $this->createMock(FormMapper::class);
        $formMapper->expects($this->once())->method('add');

        $blockService->buildEditForm($formMapper, $block);
    }
}
