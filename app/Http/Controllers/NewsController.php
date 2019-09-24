<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class NewsController extends Controller {

	public function getNews() {
		$news = array();
		// get cached version, how old is it?
		$config = DB::table('mtffl_config')
			->select('config_value')
			->where('config_name', 'news_feed')
			->first();
		$news = json_decode( $config->config_value );

		if ( NULL === $news || ( time() - $news->update_time ) > 60 ) {
			// get new news
			$xml = $this->GetXML('http://rss.footballguys.com/bloggerrss.xml');
			$news = array();
			$news['update_time'] = time();
			$news['stories'] = array();
			if ( FALSE !== $xml ) {
				foreach( $xml->channel->item as $item ) {
					$story = array();
					$story['link'] = strval( $item->link );
					$story['title'] = strval( $item->title );
					$story['story'] = strval( $item->description );
					$story['date'] = strtotime( $item->pubDate );
					$news['stories'][] = $story;
				}

				$news = json_encode( $news );
				// save the news!
				DB::table('mtffl_config')->where('config_name', 'news_feed')->update( [ 'config_value' => $news ] );
				$news = json_decode( $news );
			}
		}

		return $news;

	}

	private function GetXML( $xml_url, $username_password = "", $xml_encoding = "" ) {
	//	global $show_messages, $download_timeout;
	    $show_messages=false;
	    $download_timeout=10;
		$script_start_time = microtime(true);
		// #1
		// use curl to download the file.  we can control timeout with curl
		$code = "0";
		$xmlstr = "";
		$xml = "";
		$info = "";
		$ch = curl_init();
		// initialize curl handle
		curl_setopt($ch, CURLOPT_URL, $xml_url); 	// set url to post to
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 	// return into a variable
		curl_setopt($ch, CURLOPT_TIMEOUT, $download_timeout); 	// times out after Xs
		curl_setopt($ch, CURLOPT_HTTPGET, 1);	// set GET method
	    curl_setopt($ch, CURLOPT_USERAGENT, "My Useragent");

	    if ( $username_password!="" ) {
	        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	        curl_setopt($ch, CURLOPT_USERPWD, $username_password);
	    }
		try {
			$xmlstr = curl_exec($ch);
			// run the whole process
			$info = curl_getinfo($ch);
			$code = $info['http_code'];
		}
		catch (Exception $e) {
			if ($show_messages)
				echo $e->getMessage()."\n\r";
		}

		curl_close($ch);
		if ($ch === FALSE) {
			if ($show_messages)
				echo "Could not download (".$code."): ".$xml_url." ".(microtime(true) - $script_start_time)."s<br>\n\r";
			return FALSE;
		}
		if ($xmlstr == "") {
			if ($show_messages)
				echo "File is empty (".$code."): ".$xml_url." ".(microtime(true) - $script_start_time)."s<br>\n\r";
			return FALSE;
		}

	    if ( $xml_encoding == "" ) {
	        // check the first few characters to see if encoding is specified
	        $check_encoding = strlen($xmlstr)<50 ? substr($xmlstr,0,strlen($xmlstr)-1) : substr($xmlstr,0,50);
	        if ( strpos($check_encoding,"ISO-8859-1") > 0 ) { $xml_encoding="ISO-8859-1"; }
	        elseif ( strpos($check_encoding,"UTF-8") > 0 ) { $xml_encoding="UTF-8"; }
	    }
	    if ( $xml_encoding=="UTF-8" ) { $xmlstr=utf8_encode($xmlstr); }

		// #2
		// check it with xml_parse first to see if the file is formed correctly
		$xml_parser = xml_parser_create($xml_encoding);
		if (!xml_parse($xml_parser, $xmlstr, TRUE)) {
			if ($show_messages)
				echo date("Y-m-d H:i:s")." There is a problem with the XML file at ".$xml_url." Line: ".xml_get_current_line_number($xml_parser).", Column: ".xml_get_current_column_number($xml_parser)."<br>\n\r";
			xml_parser_free($xml_parser);
			$url_parts = parse_url($xml_url);
			$xml_part = str_replace("/", "", $url_parts['path']);
			$xname = date("Ymdhi").$xml_part;
			// save the xml for examination
			/*
			$fx=fopen($xname,"w");
			fwrite($fx,$xmlstr);
			fclose($fx);
			*/
			return FALSE;
		}
		xml_parser_free($xml_parser);

		$xml = new \SimpleXMLElement($xmlstr);
		if ($show_messages) {
			echo "(".mb_detect_encoding($xmlstr)."/".$xml_encoding.") ".$xml_url." ".(microtime(true) - $script_start_time)."s<br>\n\r";
	        /*  log the time it took to download this file
	        $fh=fopen("xml.log","a");
	        fwrite($fh,$xml_url.",".(microtime(true) - $script_start_time)."\n");
	        fclose($fh);
	        */
	    }

		return $xml;

	}

}
