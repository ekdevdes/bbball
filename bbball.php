<?php

/**
  * bbball
  * A Simple, Yet Powerful Dribbble PHP Client
  *
  * @author Ethan Kramer <contact@ethankr.com>
  * @package A Dribbble PHP Client
  * @copyright Ethan Kramer 2012
  * @see http://github.com/ekdevdes/bbball
  * @link http://dribbble.com/api
  * 
  */
class BBBall {
	
	/**
	  * Dribbbble api base url 
	  *
	  * @var string
      */
	var $api_base = "http://api.dribbble.com/";
	
	/**
	  * Page of results to request from dribbbble api
	  *
	  * @var int
      */
	var $page = 1;
	
	/**
	  * Number of results to retrieve per page
	  *
	  * @var int
      */
	var $per_page = 15;

	
	/**
	  * Gets a single shot from dribbbble
	  * @access public
	  *
	  * @param int $id The shots id. [Required] [Default: none]
	  * @param bool $show_rebounds If true will include the given shot's (the shot is specified by the $id param) rebounds [Optional][Default: false]
	  * @param bool $show_comments If true will include the given shot's (the shot is specified by the $id param) comments [Optional][Default: false] 
	  *
	  * @return array the parsed form of the resulting JSON
	  */
	public function get_shot($id,$show_rebounds=false,$show_comments=false){
		
		$url_shot = $this->api_base."shots/".(string)$id;
		$url_rebounds = "";
		$url_comments = "";
		
		if ($show_rebounds) {
			$url_rebounds .= $this->api_base."shots/".(string)$id."/rebounds";
		}
		
		if($show_comments){
			$url_comments .= $this->api_base."shots/".(string)$id."/comments";
		}
		
		if (!$show_rebounds && !$show_comments) {
			
			/**
			  * Default, both $show_comments and $show_rebounds are false
			  */
			 $result = objectToArray(json_decode($this->get_contents($url_shot)));
			
			return $result;
			
			
		}else if(!$show_rebounds && $show_comments){
			
			/**
			  * Don't $show_rebounds but $show_comments
			  */
			
			$result_shot = objectToArray(json_decode($this->get_contents($url_shot)));
			$result_comments = objectToArray(json_decode($this->get_contents($url_comments)));
			
			$result_shot['comments'] = $result_comments['comments'];
			
			return $result_shot;
			
		}else if($show_rebounds && $show_comments){
			
			/**
			  * $show_rebounds and $show_comments
			  */
			
				$result_shot = objectToArray(json_decode($this->get_contents($url_shot)));
				$result_comments = objectToArray(json_decode($this->get_contents($url_comments)));
				$result_rebounds = objectToArray(json_decode($this->get_contents($url_rebounds)));

				$result_shot['comments'] = $result_comments['comments'];
				$result_shot['rebounds'] = $result_rebounds;
				
				return $result_shot;
			
		}else if($show_rebounds && !$show_comments){
			
			/**
			  * $show_rebounds but not $show_comments
			  */
			
			$result_shot = objectToArray(json_decode($this->get_contents($url_shot)));
			$result_rebounds = objectToArray(json_decode($this->get_contents($url_rebounds)));

			$result_shot['rebounds'] = $result_rebounds;
			
			return $result_shot;
		}
	
	}
	
	/**
	  * Gets shots from dribbble with optionally, a few filters
	  * @access public
	  *
	  * @param string $list The list to fetch the shots from. Either "debuts","everyone","popular","following" or "likes" [Optional][Default: "everyone"]. For "following" or "likes"
	  * 	   the $player_id must be not NULL 
	  * @param int $player_id A given player's id. If not present then will it will be ignored. If present $list will be ignored. [Optional][Default: none]
	  *		   NOTE: In order to specify the "following" or "likes" options the $player_id must not be NULL
	  *  	   NOTE: $player_id can either the players actual id or their userame without the '@' in the begining
	  *
	  * @return array the parsed form of the resulting JSON
	  */
	public function get_shots($list="everyone",$player_id=NULL){
		if (is_null($player_id) && $list == "following" || is_null($player_id) && $list == "likes") {
			 throw new Exception(" Player id can't be null when requesting shots from the \"$list\" filter.");
		}
		
		if ($list != "following" && $list != "likes") {
			
			switch ($list) {
				case 'everyone':
					
					return objectToArray(json_decode($this->get_contents($this->api_base."shots/".$list."?page=".$this->page."&per_page=".$this->per_page)));
					
					break;
				
				case 'debuts':
					
					return objectToArray(json_decode($this->get_contents($this->api_base."shots/".$list."?page=".$this->page."&per_page=".$this->per_page)));
					
					break;
				
				case 'popular':
					
					return objectToArray(json_decode($this->get_contents($this->api_base."shots/".$list."?page=".$this->page."&per_page=".$this->per_page)));
					
					break;
			}			
			
		}else if($list == "following" || $list == "likes"){
			
			switch ($list){
				case "following":
					return objectToArray(json_decode($this->get_contents($this->api_base."players/".$player_id."/shots/following?page=".$this->page."&per_page=".$this->per_page)));
					break;
				case "likes":
					return objectToArray(json_decode($this->get_contents($this->api_base."players/".$player_id."/shots/likes?page=".$this->page."&per_page=".$this->per_page)));
					break;	
			}
			
		}
	}
	
	/**
	  * Get's a players info given a player id.
	  * @access public 
	  *
	  * @param int|string $id The player's id [Required][Default: none]. $id can either be the users actual id or their username
	  *
	  * @return array the parsed form of the resulting JSON
	  */
	public function get_player_info($id){
		if (is_null($id)) {
			 throw new Exception("Can't get player info without a player id");
		}else{
			$base_url = $this->api_base."/players/".$id;
			$following_url = $this->api_base."/players/".$id."/following?page=".$this->page."&per_page=".$this->per_page;
			$followers_url = $this->api_base."/players/".$id."/followers?page=".$this->page."&per_page=".$this->per_page;
			$draftees_url = $this->api_base."/players/".$id."/draftees?page=".$this->page."&per_page=".$this->per_page;
			
			$base_info = objectToArray(json_decode($this->get_contents($base_url)));
			$following_info = objectToArray(json_decode($this->get_contents($following_url)));
			$followers_info = objectToArray(json_decode($this->get_contents($followers_url)));
			$draftees_info = objectToArray(json_decode($this->get_contents($draftees_url)));
			
			$base_info['followers'] = $followers_info['players'];
			$base_info['following'] = $following_info['players'];
			$base_info['draftees'] = $draftees_info['players'];
			
			return $base_info;
			
		}
	}
	
	/**
	  * Returns only a given shot's rebounds
	  * @access public
	  * 
	  * @param int $id the given shot's id
	  *
	  * @return array the given shot's (specified by the $id) rebounds
	  *
	  */
	public function get_shot_rebounds($id){
		
		if (is_null($id)) {
		  throw new Exception("Can't get shot rebounds without a shot id");
		}else{
		  return objectToArray(json_decode($this->get_contents($this->api_base."/shots/$id/rebounds?page=".$this->page."&per_page=".$this->per_page)));
		}
		
	}
	
	
	/**
	  * Returns a given players shots 
	  * @access public
	  * 
	  * @param int|string $id the given players id
	  * 
	  * @return array the of the given player's (specified by $id) shots 
	  * 
	  */
	public function get_player_shots($id){
		if(is_null($id)){
			throw new Exception("Can't get shots without aa shot id");
		}else{
			return objectToArray(json_decode($this->get_contents($this->api_base."/players/$id/shots?page=".$this->page."&per_page=".$this->per_page)));
		}
	}
	
	/**
	  * Returns only a given shot's comments
	  * @access public
	  * 
	  * @param int $id the given shot's id
	  *
	  * @return array the given shot's (specified by the $id) comments
	  *
	  */
	public function get_shot_comments($id){
		if (is_null($id)) {
		  throw new Exception("Can't get shot comments without a shot id");
		}else{
		  return objectToArray(json_decode($this->get_contents($this->api_base."/shots/$id/comments?page=".$this->page."&per_page=".$this->per_page)));
		}
	}
	
	/**
	  * Return the content of a url using curl 
	  * @access private
	  *
	  * @param string $url the url which the get the contents from
	  *
	  * @return string a string representation the contents of the url
	  * 
	  */
	 private function get_contents($url){
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}

/**
   *
   * Convert an object to an array
   * @access public
   *
   * @param    Object  $object The object to convert
   *
   * @return   Array   an array representation of $object
   *
   */
function objectToArray( $object )
{
   if( !is_object( $object ) && !is_array( $object ) )
   {
       return $object;
   }
   if( is_object( $object ) )
   {
       $object = get_object_vars( $object );
   }
   return array_map( 'objectToArray', $object );
}