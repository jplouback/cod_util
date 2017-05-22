<?php 
function getFeed(){
            
    # Url do RSS / Feed
    $feed_url = 'http://blogsantailha.com.br/feed/';
	
	// $data = file_get_contents($feed_url); 
	
    $xml = simplexml_load_file( $feed_url, 'SimpleXMLElement', LIBXML_NOCDATA );

	$channel = (array)$xml->channel; 
    $return = array(); 

	$channel = (array)$xml->channel;

	foreach ($channel['item'] as $key => $value) {
		
		$img = $xml->channel->item[$key]->children( 'media', True )->content->attributes()['url'];

		$value = (array) $value; 
		$return[$key] = array(
			'title' => $value['title'],
			'link' => $value['link'],
			'data' => $value['pubDate'],
			'description' =>$value['description'],
			'category' =>$value['category'],
			'img' =>  current($img)
		); 
	}

    return $return;
}


getInstagram(){
            
    $return 	= array(); 

    $feed_url = 'https://www.instagram.com/#cliente#/media/';

    $json 		= file_get_contents($feed_url); 
    $api 		= json_decode($json); 
    $data 		= $api->items;

	foreach ($data as $key => $insta_post) {
		
		$return[$key] = array(
			'link' 			=> $insta_post->link,
			'imagem' 		=> $insta_post->images->low_resolution->url,
			'tipo'			=> $insta_post->type,
			'descricao'		=> $insta_post->caption->text,
			'likes'			=> $insta_post->likes->count
		); 
	}

    return $return ;
}