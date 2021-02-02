<?php

namespace Sivaschenko\LuckyOrder\Test\Unit\Block;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Sivaschenko\LuckyOrder\Block\OrderSuccess;
use Sivaschenko\LuckyOrder\Model\LuckInfo;
use Magento\Checkout\Model\Session;

class OrderSuccessTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var OrderSuccess
     */
    private $block;

    /**
     * @var LuckInfo|\PHPUnit\Framework\MockObject\MockObject
     */
    private $luckInfo;

    /**
     * @var Session|\PHPUnit\Framework\MockObject\MockObject
     */
    private $session;

    protected function setUp()
    {
        $objectManager = new ObjectManager($this);

        $this->luckInfo = $this->createMock('Sivaschenko\LuckyOrder\Model\LuckInfo');
        $this->session = $this->createMock('Magento\Checkout\Model\Session', [], [], '', false);

        $this->block = $objectManager->getObject(
            'Sivaschenko\LuckyOrder\Block\OrderSuccess',
            [
                'luckInfo' => $this->luckInfo,
                'session' => $this->session
            ]
        );
    }

    /**
     * @param $isLucky
     * @param $html
     * @dataProvider luckyProvider
     */
    public function testToHtml($isLucky, $html)
    {
        $amount = 1.24;

        $order = $this->createMock('Magento\Sales\Model\Order', [], [], '', false);
        $order->expects($this->once())
            ->method('getGrandTotal')
            ->willReturn($amount);

        $this->session->expects($this->once())
            ->method('getLastRealOrder')
            ->willReturn($order);

        $this->luckInfo->expects($this->once())
            ->method('isAmountLucky')
            ->with($amount)
            ->willReturn($isLucky);

        $this->assertEquals($html, $this->block->toHtml());
    }

    public function luckyProvider()
    {
        return [
            [true, __('Your order is lucky!')],
            [false, '']
        ];
    }
}
