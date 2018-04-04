<?php

namespace Eleanorsoft\OrderReturn\Controller\Index;

use \Exception;
use \Magento\Framework\App\Action\Action;

class Save extends Action
{
    protected $orderRepository;
    protected $resultJsonFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        $this->orderRepository = $orderRepository;
        $this->resultJsonFactory = $resultJsonFactory;

        return parent::__construct($context);
    }

    public function execute()
    {
        $order = null;
        $post = $this->getRequest()->getPostValue();

        if (!$post) {
            $this->_redirect('*/*/');

            return;
        }

        if (
            !array_key_exists('order_id', $post) ||
            !array_key_exists('order_return', $post)
        ) {
            $this->_redirect('*/*/');

            return;
        }

        try {
            $order = $this->orderRepository->get($post['order_id']);
        } catch (Exception $ex) {
            return $this->resultJsonFactory->create()->setData([
                'success' => false,
                'messages' => [__('Order does not exist')]
            ]);
        }

        $order->setReturn($post['order_return']);
        $order->save();

        return $this->resultJsonFactory->create()->setData([
            'success' => true,
            'messages' => [__('Order Return Placed Successfully')]
        ]);
    }
}
