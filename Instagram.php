<?
class Instagram
{
		
	public function __construct($link) 
	{		
		$this->link = $link;
		$ch = curl_init($this->link);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
		//get json string
		$left = explode('<script type="text/javascript">window._sharedData = ', $data);//explode the part we dont use from the left
		$right = explode(";</script>", $left[1]); //explode the part we dont use from the right
		$jsonData = $right[0];  //get json string between characters
        $this->data = json_decode($jsonData); //decoding and get the array
	}  
	
	public function getPost($num) 
	{
		return $this->data->entry_data->ProfilePage[0]->graphql->user->edge_owner_to_timeline_media->edges[$num]->node->thumbnail_src;
	}
	
	
	
	public function getLink() 
	{
		return  $this->link;
	} 
	
	public function getUserInfo() 
	{
		return  $this->data->entry_data->ProfilePage[0]->graphql->user;
	} 

	public function getUserName() 
	{
		return  $this->data->entry_data->ProfilePage[0]->graphql->user->username;
	}

    public function getUserPhoto()     
	{
		return  $this->data->entry_data->ProfilePage[0]->graphql->user->profile_pic_url_hd;
	}
	
	public function getUserPhotoThumb()     
	{
		return  $this->data->entry_data->ProfilePage[0]->graphql->user->profile_pic_url;
	}

	public function getUserFollowers() 
	{
		return  $this->data->entry_data->ProfilePage[0]->graphql->user->edge_followed_by->count;
	}

	public function getUserFollows() 
	{
		return  $this->data->entry_data->ProfilePage[0]->graphql->user->edge_follow->count;
	}
	
	public function getUserPublications() 
	{
		return  $this->data->entry_data->ProfilePage[0]->graphql->user;
	}
	
	public function getUserDescription() 
	{
		return  $this->data->entry_data->ProfilePage[0]->graphql->user->biography;
	}
	
	public function getUserSite() 
	{
		return  $this->data->entry_data->ProfilePage[0]->graphql->user->external_url;
	}
}