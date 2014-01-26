<?php 

require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->config(array(
    'templages.path' => 'templates',
    ));

$app->get('/', function() {
    
    echo "<h1>Hello World</h1>";

});

$app->get('/about',function() use ($app) {

    $data = array(
        'title' => 'Stu Mason!',
        'heading' => 'Word up motherfuckers!',
        'message' => "Oh wow. Sorry about that. Thats just plain vulgar. Look, lets start again, I'm Stu Mason, I make the internet do stuff that you want it to.",
        );

    $app->render('about.php' , $data);

});

$app->run();