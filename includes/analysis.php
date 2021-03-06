<?php



class WP_Post_Emo_Analysis {



	/* 	Removes empty items from array and reassign keys.
		Input: (array)
	    Output: (array) */

	/**
	 * WP_Post_Emo_Analysis constructor.
	 */
	public function __construct( WP_Post_Emo_Plugin $plugin ) {

		$this->plugin = $plugin;

	}

	private function cleanArray($array) {
		return array_values(array_filter($array));
	}

	/* 	Splits text into paragraphs
		Input: article text (string)
	    Output: paragraphs (array) */

	private function splitParagraphs($article) {
		$paragraphs = explode("\n", $article);
		return self::cleanArray($paragraphs);
	}	


	/* 	Splits text into sentences preserving punctuation.
		Input: article text (string)
	    Output: sentences (array) */

	private function splitSentences($article) {
		$sentences = preg_split("/([^.:!?]+[.:!?]+)/", $article, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
		return self::cleanArray($sentences);
	}

	/* 	Gets JSON from sentiment analysis
		Input: text (string)
	    Output: json string (string) */

	private function getSentimentInfo($text) {

		$t = $this->plugin->includes_path .'vendor/autoload.php';

		if( file_exists( $this->plugin->includes_path .'vendor/autoload.php' )) {

			require $this->plugin->includes_path .'vendor/autoload.php';

		} else {

			throw new Exception('Please run composer');

		}


		try {
			$client = new GuzzleHttp\Client();
			$res = $client->post('http://text-processing.com/api/sentiment/', ['form_params' => ['text' => $text]]);
			return $res->getBody();

		}
		catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}

	/* 	Parses JSON from sentiment analysis and returns number 1-10
		Input: json (string)
	    Output: number (string) */


	private function parseSentimentInfo($input) {		
		$jsonObject = json_decode($input);
		$neg = $jsonObject->probability->neg;
		$neutral = $jsonObject->probability->neutral;
		$pos = $jsonObject->probability->pos;

		if ($neg > $pos) {
			$number = 5 - ($neg * 5);
		}
		else if  ($pos > $neg) {
			$number = 5 + ($pos * 5);
		}
		else {
			$number = 5;
		}

		if ($number < 4) {
			$number = floor($number);
		}
		else if ($number > 6) {
			$number = ceil($number);
		} 
		else {
			$number = round($number);
		}
		
		return round($number);
	}


	private function getTextLength($input) {
		return strlen($input);
	}


	public function feed($article) {
		$sentences = self::splitSentences($article);
		
		$result = [];
		foreach ($sentences as $sentence) {
			$json = self::getSentimentInfo($sentence);
			$number = self::parseSentimentInfo($json);
			$length = self::getTextLength($sentence);

			array_push($result, [$number, $length]);
		}


		return $result;
	}



}




?>