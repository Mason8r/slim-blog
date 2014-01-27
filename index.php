<?php 

require 'controllers/Blog.php';

require 'vendor/autoload.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$blog = new Blog($app);

$app->config(array(
    'templages.path' => 'templates',
    'article.path' => 'articles'   
    ));

$app->get('/', function() use ($app, $blog){
   

   $articles = $blog->loadArticles();

   $app->render('index.php',array('articles' => $articles));

});


$app->get('/archives(/:yyyy(/:mm(/:dd)))', function() use ($app,$blog) {

   $args = func_get_args();
   //load all articles

   $articles = $blog->loadArticles();

   $archives = $blog->createArchives( $args , $articles );

   // render archives
   $app->render('archives.php',array('archives' => $archives));




$app->get('/archives(/:yyyy(/:mm(/:dd)))', function() use ($app) {
})->conditions(
      array(
          'yyyy' => '(19|20)\d\d'
         ,'mm'=>'(0[1-9]|1[0-2])'
         ,'dd'=>'(0[1-9]|[1-2][0-9]|3[0-1])'
      ));

});

// '/post-url' will load post-url.txt file.
$app->get('/:article',function($article) use ($app) {

   $path     = $app->config('article.path');
   //open text file and read it
   $handle  = fopen($path . '/' . $article . '.txt', 'r');
   $content = stream_get_contents($handle);

   // split the content to get metadata
   $content = explode("\n\n", $content);

   $rawMeta = array_shift($content);
   // metadata is json encoded. so decode it.
   $meta    = json_decode($rawMeta,true);
   $content = implode("\n\n", $content);
   $content = Michelf\Markdown::defaultTransform($content);
   $article = array('meta' => $meta , 'content' => $content);

   $app->render('article.php', $article);

});


$app->run();