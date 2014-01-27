<?php 

Class Blog
{

 public function __construct($app)
 {
 	$this->app = $app;
 }

 public function loadArticles()
 {
   
   $path = $this->app->config('article.path');

   $dir = new DirectoryIterator($path);
   
   $articles = array();
   foreach($dir as $file){
      if($file->isFile()){
         $handle  = fopen($path . '/' . $file->getFilename(), 'r');
         $content = stream_get_contents($handle);
         $content = explode("\n\n", $content);
         $rawMeta = array_shift($content);
         $meta    = json_decode($rawMeta,true);
         $content = implode("\n\n", $content);
         $content = Michelf\Markdown::defaultTransform($content);
         $articles[$file->getFilename()] = array('meta' => $meta, 'content' => $content);
      }
	}
	
	return $articles;

	}

}

?>