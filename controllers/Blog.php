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




 public function createArchives($args,$articles)
 {
 	

  	$archives = array();
	// check count($args) for optional route params
	if(count($args)>0) {


	  $dateFormat = function($args,$format){
      	$temp_date = is_array($args) ? implode('-', $args) : $args;
      	$date   = new DateTime($temp_date);
      	return $date->format($format);
   		};
   

   		switch(count($args)){
      		case 1 :    //only year is present
         		$format = 'Y';
         		$date = $dateFormat($args,$format);
         	break;
      		case 2 :    //year and month are present
         		$format = 'Y-m';
         		$date	= $dateFormat($args,$format);
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

	} else {

	$archives = $articles;

	}

	return $archives;
 }

}
?>