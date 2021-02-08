<?php
class podcast_tracker
{  
    private $podcast_id = '';
    public $name = '';
    
    public function __construct($id){
        //iTunes Podcast ID. 
        $this->podcast_id = $id;
        $this->name = $this->getPodcastName();
    }

    public function getVotes(){
        $curl = curl_init();
        //Runs request against podcast URL. Mimics iTunes User agent so that it will return HTML to parse.
        //Uses the US X-Apple-Store-Front so only will pull the total number of reviews in the US. 
        //This can be modfied to pull from other contries. 

        //Code modified from 
        //https://gist.github.com/sgmurphy/1878352    
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://itunes.apple.com/WebObjects/MZStore.woa/wa/customerReviews?displayable-kind=4&id='.$this->podcast_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
            'User-Agent: iTunes/10.3.1 (Macintosh; Intel Mac OS X 10.6.8) AppleWebKit/533.21.1',
            'X-Apple-Store-Front: 143441-1,12',
            'X-Apple-Tz: -18000',
            'Accept-Language: en-us, en;q=0.50'
            ),
        ));
        $ratings = array();
        $response = curl_exec($curl);
        $dom = new DOMDocument();
        @$dom->loadHTML($response);
        //Parses HTML to find the raiting count of 5 star reviews.  
        $xpath = new DOMXPath($dom);
        $nodes = $xpath->query("//span[@class='rating-count']");
        if ($nodes->item(0)) {            
            array_push($ratings,(int)preg_replace('/([\d]+)/', '$1', $nodes->item(0)->nodeValue));
        } else {
            $ratings[] = 0;
        }
    
        curl_close($curl);
        return $ratings;
        
    }

    private function getPodcastName(){
        //Gets the name of the podcast based on the rss feed. 
        $lookupURL = "https://itunes.apple.com/lookup?id=".$this->podcast_id."&entity=podcast";
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://itunes.apple.com/lookup?id=1105760780&entity=podcast',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = $this->object_to_array(json_decode(curl_exec($curl)));
        curl_close($curl);        
        return $response['results'][0]['collectionName'];
    }

    public function getRandomReview(){
        $curl = curl_init();
        //Get RSS of Podcast Comments
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://itunes.apple.com/us/rss/customerreviews/id='.$this->podcast_id.'/json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $rss = $this->object_to_array(json_decode(curl_exec($curl)));
        curl_close($curl);
        //If Podcast doesn't have any comments or error display title
        if(count($rss['feed']) < 1){
            return array("comment"=>'You have no comments',"name"=>'Anonymous', "title"=>'Sorry');
        }
        //get total number of reviews to make sure we don't pick a random number that doesn't exist
        $reviews = count($rss['feed']['entry']);
        //Choose a random review to parse data from the RRS feed with
        $rand = mt_rand(0,$reviews);     
        //Get name, comment, title, and rating       
        $name = $rss["feed"]["entry"][$rand]["author"]["name"]["label"];
        $comment = $rss["feed"]["entry"][$rand]["content"]["label"];
        $title = $rss["feed"]["entry"][$rand]["title"]["label"];
        //you could use rating to filter an re-run if the number does not = 5
        $rating = $rss["feed"]["entry"][$rand]["im:rating"]["label"];
        return array("comment"=>$comment,"name"=>$name, "title"=>$title);        
    }

    public function getArtwork(){        
        //Gets largest podcast artwork and returns the URL
        $lookupURL = "https://itunes.apple.com/lookup?id=".$this->podcast_id."&entity=podcast";
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://itunes.apple.com/lookup?id=1105760780&entity=podcast',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = $this->object_to_array(json_decode(curl_exec($curl)));

        curl_close($curl);
        
        //Get the largest size image that iTunes will allow here
        $artworkURL = $response['results'][0]['artworkUrl600'];
        //return artwork url;
        return $artworkURL;
          
    }

    private function html_to_obj($html) {
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        return $dom;
    }

    private function object_to_array($data){
        if (is_array($data) || is_object($data))
        {
            $result = array();
            foreach ($data as $key => $value)
            {
                $result[$key] = $this->object_to_array($value);
            }
            return $result;
        }
        return $data;
    }

    
}

?>