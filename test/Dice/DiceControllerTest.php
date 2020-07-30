<?php
namespace Ylvan\Game;

// use Ylvan\Game\DiceController;
use Anax\DI\DIMagic;
use PHPUnit\Framework\TestCase;
use Anax\Response\ResponseUtility;

// use Anax\Session\Session;

// use Anax\Request\Request;


// use Anax\Controller\SampleAppController;

// namespace Anax\Route;

/**
 * Test the controller like it would be used from the router,
 * simulating the actual router paths and calling it directly.
 */
class DiceControllerTest extends TestCase
{
    private $controller;
    // private $app;


    /**
     * Setup the controller, before each testcase, just like the router
     * would set it up.
     */
    protected function setUp(): void
    {
        global $di;
        // Init service container $di to contain $app as a service
        $di = new DIMagic();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $app = $di;
        $di->set("app", $app);

        // Create and initiate the controller
        $this->controller = new DiceController();
        $this->controller->setApp($app);
        // $this->controller->initialize();
    }


    /**
     * Call the controller index action.
     */
    public function testIndexAction()
    {
        // $controller = new DiceController();

        $res = $this->controller->indexAction();
        $this->assertIsString($res);
        $this->assertContains("Index page!!", $res);
    }


    /**
     * Call the controller debug action.
     */
    public function testdebugAction()
    {
        // $controller = new DiceController();

        $res = $this->controller->debugAction();
        $this->assertIsString($res);
        $this->assertContains("debug me", $res);
    }


    /**
     * Call the controller init action.
     */
    public function testinitAction()
    {
        $res = $this->controller->initAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }


    /**
     * Call the controller play action. POST
     */
    public function testplayAction()
    {
        $res = $this->controller->playAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }


    /**
     * Call the controller restart action.
     */
    public function testrestartAction()
    {
        $res = $this->controller->restartAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }


    /**
     * Call the controller getPlay action.
     */
    // public function testgetPlayAction()
    // {
    //     $res = $this->controller->getPlayAction();
    //     $this->assertInstanceOf(Session::class, $res);
    // }


    // /**
    //  * Call the controller getPlay Action.
    //  */
    // public function testgetPlayAction()
    // {
    //     $controller = new DiceController();
    //
    //     $res = $controller->getPlayAction();
    //     $this->assertIsString($res);
    //     $this->assertContains("debug me", $res);
    // }



    // /**
    //  * Call the controller info action GET.
    //  */
    // public function testInfoActionGet()
    // {
    //     $res = $this->controller->infoActionGet();
    //     $this->assertIsString($res);
    //     $this->assertStringEndsWith("active", $res);
    // }


    //
    // /**
    //  * Call the controller create action GET.
    //  */
    // public function testCreateActionGet()
    // {
    //     $res = $this->controller->createActionGet();
    //     $this->assertIsString($res);
    //     $this->assertStringEndsWith("active", $res);
    // }


    //
    // /**
    //  * Call the controller create action POST.
    //  */
    // public function testCreateActionPost()
    // {
    //     $res = $this->controller->createActionPost();
    //     $this->assertIsString($res);
    //     $this->assertStringEndsWith("active", $res);
    // }
}
