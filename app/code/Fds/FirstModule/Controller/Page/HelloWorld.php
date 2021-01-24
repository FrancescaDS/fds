<?php


namespace Fds\FirstModule\Controller\Page;


use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Fds\FirstModule\Api\PencilInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Fds\FirstModule\Model\PencilFactory;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\App\Request\Http;
use Fds\FirstModule\Model\HeavyService;

class HelloWorld extends \Magento\Framework\App\Action\Action
{

    protected $pencilInterface;
    protected $productRepository;
    protected $pencilFactory;
    protected $productFactory;
    protected $_eventManager;
    protected $http;
    protected $heavyService;

    public function __construct(Context $context,
                                HeavyService $heavyService,
                                Http $http,
                                ManagerInterface $_eventManager,
                                ProductFactory $productFactory,
                                PencilInterface $pencilInterface,
                                ProductRepositoryInterface $productRepository,
                                PencilFactory $pencilFactory)
    {
        //Assegno i valori
        $this->pencilInterface = $pencilInterface;
        $this->productRepository = $productRepository;
        $this->pencilFactory = $pencilFactory;
        $this->productFactory = $productFactory;
        $this->_eventManager = $_eventManager;
        $this->heavyService = $heavyService;
        $this->http = $http;

        parent::__construct($context);
    }

    public function execute()
    {

        echo "<br><br>-------------------INIZIO EXECUTE-----------------------<br><br>";
        echo "Hello World";

        echo "<br><br>";
        echo $this->pencilInterface->getPencilType();

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        echo "<br><br>BOOK<br>";
        $book = $objectManager->create('Fds\FirstModule\Model\Book');
        var_dump($book);

        echo "<br><br>STUDENT<br>";
        $student = $objectManager->create('Fds\FirstModule\Model\Student');
        var_dump($student);

        echo "<br><br>PENCIL<br>";
        $pencil = $objectManager->create('Fds\FirstModule\Model\Pencil');
        var_dump($pencil);

        echo "<br><br>PENCIL WITH FACTORY<br>";
        $pencilFromFa = $this->pencilFactory->create(array("name"=>"Alex", "school"=>"Cambridge"));
        var_dump($pencilFromFa);

        echo "<br><br>PRODUCT WITH FACTORY<br>PLUGIN BEFORE + PLUGIN AFTER + PLUGIN AROUND<br>";
        $product = $this->productFactory->create()->load(1);
        $product->setName("Nome Prodotto qualsiasi");
        $productName = $product->getName();
        echo "<br>" . $productName;

        echo "<br><br>PLUGIN AROUND<br>";
        $productName = $product->getIdBySku("Chianti_3");


        echo "<br><br>EVENT<br>";
        /*Event I want to create*/
        $message = new \Magento\Framework\DataObject(array("greeting"=>"Good afternoon"));

        /* In order dispatch an event (per poi fare un Observer) bisogna inject the event manager
        Magento\Framework\Event\ManagerInterface
        Dispatch the event in questo controller
        'custom_event' e' il nome dell'evento, poi chiamato in events se si vuole mettere il controller*/
        $this->_eventManager->dispatch('custom_event',['greeting'=>$message]);
        echo $message->getGreeting();


        /*Voglio instanziare la classe HeavyService solo quando ID=1
                per non appesantire inutilmente
                use Request\Http
        vedi settaggi in di.xml
        nell'argomento c'e' nel nome della classe = \Proxy
        http://fds.local/tutorial/page/helloworld/id/1  >>> instanzia il service
        http://fds.local/tutorial/page/helloworld       >>>  NON instanzia il service  */
        echo "<br><br>PROXY - Voglio instanziare la classe HeavyService solo quando ID=1<br>";
        $id = $this->http->getParam('id',0);
        if ($id == 1){
            $this->heavyService->printHeavyServiceMessage();
        } else {
            echo "HeavyService not used" . "</br>";
        }


        echo "<br><br>-------------------FINE EXECUTE-----------------------<br><br>";




    }
}
