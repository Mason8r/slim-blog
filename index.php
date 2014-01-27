<?php 

require 'Controllers/Blog.php';

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

$archives = array();
// check count($args) for optional route params
if(count($args)>0) {
   switch(count($args)){
      case 1 :    //only year is present
         $format = 'Y';
         $date = $dateFormat($args,$format);
         break;
      case 2 :    //year and month are present
         $format = 'Y-m';
         $date = $dateFormat($args,$format);
         break;
      case 3 : //year, month and date are present
         $format = 'Y-m-d';
         $date = $dateFormat($args,$format);
         break;
   }
   // filter articles
   foreach($articles as $article){
      if($dateFormat($article['meta']['date'], $format) == $date){
         $archives[] = $article;
      }
   }
}
else {

   $archives = $articles;
   
}

// render archives
$app->render('archives.php',array('archives' => $archives));

$dateFormat = function($args,$format){
   $temp_date = is_array($args) ? implode('-', $args) : $args;
   $date   = new DateTime($temp_date);
   return $date->format($format);

};

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