<?php
/**
 * Created by PhpStorm
 * User: francescadallaserra
 * Date: 27/01/2020
 * Time: 16:53
 */

namespace Fds\Customcatalog\Controller\Index;

use Magento\Checkout\Helper\Cart as CartHelper;


class Index extends \Magento\Framework\App\Action\Action
{

    private $productResource;
    private $productFactory;
    protected $cart;
    protected $cartHelper;
    protected $request;


    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Catalog\Model\ResourceModel\Product $productResource,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        CartHelper $cartHelper
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->cart = $cart;
        $this->cartHelper = $cartHelper;
        $this->request = $request;
        $this->productResource = $productResource;
        $this->productFactory = $productFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        try {

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
            $baseUrl = $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB, true);

            $redirectUrl = $baseUrl;

            $productExists = false;

            $params = $this->request->getParams();

            $paramsList = '';

            $couponCode = '';

            $productAdded = false;

            foreach($params as $key => $value) {
                if ($key == 'idproduct') {
                    $productModel = $this->productFactory->create();
                    $ids = filter_input(INPUT_GET, 'idproduct', FILTER_SANITIZE_URL);
                    $poductIds = explode(",",$ids);
                    foreach ($poductIds as $productId){
                        $this->productResource->load($productModel, $productId);
                        try{
                            //echo($productModel->getName());
                            $this->cart->addProduct($productModel, array( 'product_id' => $productId, 'qty' => 1));
                            $productAdded = true;
                        } catch(NoSuchEntityException $e){

                        }
                    }

                } elseif($key == 'code'){
                    $couponCode = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_URL);
                } else {
                    if ($paramsList <> ''){
                        $paramsList .= '&';
                    }
                    $paramsList .= $key . "=" . $value;
                }
            }

            if ($productAdded){
                $this->cart->save();
                $redirectUrl = $this->cartHelper->getCartUrl();
            }

            //If the URL contains a couponcode AND other parameters the code will not be consider
            if ($paramsList) {
                $redirectUrl .= "?" . $paramsList;
            }elseif ($couponCode and $productAdded){
                //http://sandboxm2.local/uk/checkout/cart/couponPost/coupon_code/freetotest
                $redirectUrl .= 'couponPost/coupon_code/' . $couponCode;
            }

            $this->messageManager->addSuccess(__('Add to cart successfully.'));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addException(
                $e,
                __('%1', $e->getMessage())
            );
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('error.'));
        }

        //echo $aaa;
        //exit;

        // Redirect to cart page
        $this->getResponse()->setRedirect($redirectUrl);

    }
}
