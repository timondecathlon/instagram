<?
namespace Bitkit\Social;
class Instagram
{

	public function __construct($link)
	{		
		$this->link = $link;
		//$ch = curl_init($this->link);
		//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //$data = curl_exec($ch);
        $data = file_get_contents($this->link);
		//get json string
		$left = explode('<script type="text/javascript">window._sharedData = ', $data);//explode the part we dont use from the left
		$right = explode(";</script>", $left[1]); //explode the part we dont use from the right
		$jsonData = $right[0];  //get json string between characters
        $this->data = json_decode($jsonData); //decoding and get the array
	}


	//get the link you passed
    public function getLink()
    {
        return  $this->link;
    }

    /**
     * Getting link as Post
     */

    //get all info bout post provided by link
    public function getPost()
    {
        return $this->data->entry_data->PostPage[0]->graphql->shortcode_media;
    }

    //get text bout post provided by link
    public function getPostText()
    {
        return $this->getPost()->edge_media_to_caption->edges[0]->node->text;
    }

    //get photo bout post provided by link
    public function getPostPhoto()
    {
        return $this->getPost()->display_resources[0]->src;
    }

    //get comments bout post provided by link
    public function getPostComments()
    {
        return $this->getPost()->edge_media_to_comment;
    }

    public function getPostCommentsCount()
    {
        return $this->getPostComments()->count;
    }

    public function getPostLikesCount()
    {
        return $this->getPost()->edge_media_preview_like->count;
    }


    /**
     * Getting link as Profile
     */

    //get all info bout profile
    public function getProfileInfo()
    {
        return  $this->data->entry_data->ProfilePage[0]->graphql->user;
    }

    //get name profile
    public function getProfileName()
    {
        return $this->getProfileInfo()->username;
    }

    //get full name profile
    public function getProfileFullName()
    {
        return $this->getProfileInfo()->full_name;
    }

    //get description of profile
    public function getProfileDescription()
    {
        return $this->getProfileInfo()->biography;
    }


    public function getProfileUrl()
    {
        return  $this->getProfileInfo()->external_url;
    }

    public function getProfilePhoto()
    {
        return $this->getProfileInfo()->profile_pic_url_hd;
    }

    public function getProfilePhotoThumb()
    {
        return  $this->getProfileInfo()->profile_pic_url;
    }

    public function getProfileFollowers()
    {
        return  $this->getProfileInfo()->edge_followed_by->count;
    }

    public function getProfileFollows()
    {
        return  $this->getProfileInfo()->edge_follow->count;
    }


    /**
     * Getting Profile's Post by count
     */
    public function getAllPosts()
    {
        return $this->data->entry_data->ProfilePage[0]->graphql->user->edge_owner_to_timeline_media;
    }

    public function getAllPostsPhoto()
    {
        $arr = [];
        $posts = $this->getAllPosts()->edges;

        foreach ($posts as $post){
            $arr[] = $post->node->thumbnail_src;
        }
        return $arr;
    }

    public function getAllPostsText()
    {
        $arr = [];
        $posts = $this->getAllPosts()->edges;

        foreach ($posts as $post){
            $arr[] = $post->node->edge_media_to_caption->edges[0]->node->text;
        }
        return $arr;
    }

    public function getProfilePost($num)
    {
        return $this->getAllPosts()->edges[$num]->node;
    }

    public function getProfilePostText($num)
    {
        return $this->getProfilePost($num)->edge_media_to_caption->edges[0]->node->text;
    }

    public function getProfilePostImage($num)
    {
        return $this->getProfilePost($num)->thumbnail_src;
    }
	


	public function getProfilePublications()
	{
		return  $this->data->entry_data->ProfilePage[0]->graphql->user;
	}
	

	

}