<?php

require 'vendor/autoload.php';

$app = new \Slim\Slim(array(
    "debug" => true,
    'view' => new \Slim\Views\Twig()
));

$view = $app->view();
$view->parserOptions = array(
    'debug' => true,
    'cache' => false //dirname(__FILE__) . '/cache'
);

$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
);

session_cache_limiter(false);
session_start();

/*
* HTTP STATUS CODES
* 200 ok
* 400 Bad Request
* 401 Unauthorized
* 409 Conflict
*/


function response($code, $dataAry)
{
    if($code != 200)
    {
        $dataAry['status'] = 'error';        
    }
    else
    {
        $dataAry['status'] = 'success'; 
    }
    $response = $GLOBALS['app']->response();
    $response['Content-Type'] = 'application/json';
    $response->status($code);
    $response->body(json_encode($dataAry));
}

   // $globalWebUrl = Image::getRootPath(false);
    //$viewParameters = array('web_url' => $globalWebUrl) ;
    $viewParameters = array() ;

	$jsonParams = array();
	$formParams = $app->request->params();
    $data = $app->request->getBody();

	if(!empty($data))
	{
	    $decodeJsonParams = json_decode($data, TRUE);
        if(is_array($decodeJsonParams))
            $jsonParams = $decodeJsonParams;
	}

    $webUrl = Image::getRootPath(false);
   // $formParams['web_url'] = $webUrl;
	$app->requestdata = array_merge($jsonParams, $formParams);

    $app->get('/', function () use ($app, $viewParameters) {
   
        $app->render('index.html.twig', $viewParameters);
    })->name('index');

    $app->get('/about/', function () use ($app, $viewParameters) {
        

        $app->render('about.html.twig', $viewParameters);
    })->name('index');


    $app->get('/index', function () use ($app, $viewParameters) {
             
    })->name('index');

    $app->get('/contact-us/', function () use ($app, $viewParameters) {
        $viewParameters['title'] = 'Contact';
        $app->render('contact.html.twig', $viewParameters);
    });

    $app->get('/admin/' , function () use ($app, $viewParameters){
        echo "<script>window.location='login.php'</script>";
    });

    $app->notFound(function () use ($app, $viewParameters) {
        $viewParameters['title'] = 'Not Found';        
        $app->render('404.html.twig', $viewParameters);
    });


/*
* JSON middleware
* It Always make sure, response is in the form of JSON
* We also initiate database connection here
*/

$app->add(new JsonMiddleware('/api'));


/*
* Grouped routes
*/

$app->group('/api', function () use ($app) {

    // Login
    $app->post('/login' , function () use ($app){

        $new = new LoginRepo();
        $code = $new->login($app->requestdata);
        response($code, $code['data']);
    }); 
    

    $app->get('/admindata', function() use ($app){
        $new = new LoginRepo();
        $code = $new->getAdminData();
        response(200, array('data' => $code));
    });

    $app->post('/editadmindata', function() use ($app){
        $new = new LoginRepo();
        $code = $new->editAdminData($app->requestdata);
        response($code, array());
        
    });

    $app->post('/editadminpassword', function() use ($app){
        $new = new LoginRepo();
        $code = $new->editadminpassword($app->requestdata);
        response($code, array());
        
    });     

    $app->get('/logout' , function () use ($app){
        session_destroy();
        response(200, array());
    }); 

         // Get Menues    
     $app->get('/menues', function() use ($app){

        $menue = new MenueRepo();
        $code = $menue->getMenues($app->requestdata);
        response($code['code'], array('data' => $code['data']));
    });

    // Get Menue from id    
     $app->get('/menue', function() use ($app){

        $menue = new MenueRepo();
        $code = $menue->getMenue($app->requestdata);
        response($code['code'], array('data' => $code['data']));
    });     

    // Add Menue
     $app->post('/menue', function() use ($app){

        $menue = new MenueRepo();
        $code = $menue->addMenue($app->requestdata);
        response($code, array());
    }); 

     // Edit Menue
     $app->post('/editmenue', function() use ($app){

        $menue = new MenueRepo();
        $code = $menue->editMenue($app->requestdata);
        response($code, array());
    }); 

    // Delete Menue
     $app->post('/deletemenue', function() use ($app){

        $menue = new MenueRepo();
        $code = $menue->deleteMenue($app->requestdata);
        response($code, array());
    }); 

    // Get Contents    
     $app->get('/contents', function() use ($app){

        $content = new ContentRepo();
        $code = $content->getContents($app->requestdata);
        response($code['code'], array('data' => $code['data']));
    });

    // Get Menue from id    
     $app->get('/content', function() use ($app){

        $content = new ContentRepo();
        $code = $content->getContent($app->requestdata);
        response($code['code'], array('data' => $code['data']));
    });     

    // Add Menue
     $app->post('/content', function() use ($app){

        $content = new ContentRepo();
        $code = $content->addContent($app->requestdata);
        response($code, array());
    }); 

     // Edit Menue
     $app->post('/editcontent', function() use ($app){

        $content = new ContentRepo();
        $code = $content->editContent($app->requestdata);
        response($code, array());
    }); 

    // Delete Menue
     $app->post('/deletecontent', function() use ($app){

        $content = new ContentRepo();
        $code = $content->deleteContent($app->requestdata);
        response($code, array());
    });
     
});






$app->run();