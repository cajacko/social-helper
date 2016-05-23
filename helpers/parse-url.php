<?php

class Parse_url {
    private $resolver;

    public function __construct() {
        require_once('lib/URLResolver.php/URLResolver.php');
        $this->resolver = new URLResolver();
    }

    public function strip_query_string($url) {
        $url = preg_replace('/\?.*/', '', $url);
        return $url;
    }

    public function canonical($url) {
        $contents = file_get_contents('');
        return $url;
    }

    public function location($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $a = curl_exec($ch);

        if(preg_match('#Location: (.*)#', $a, $r)) {
         $l = trim($r[1]);
         $url = $l;
        }

        return $url;
    }

    public function google($url) {
        // print_r(parse_url($url)); exit;
        $url_parts = parse_url($url);

        // If it is a google redirect then get the url from the query
        if(
            isset($url_parts['host']) && 
            'www.google.com' == $url_parts['host'] &&
            isset($url_parts['path']) && 
            '/url' == $url_parts['path'] &&
            isset($url_parts['query'])
            ) {

            parse_str($url_parts['query'], $query_parts);

            if(isset($query_parts['url'])) {
                $url = $query_parts['url'];
            }
        }

        return $url;
    }

    public function strip_hashtag($url) {
        $url = preg_replace('/#.*/', '', $url);
        return $url;
    }


    public function resolve($link) {
        $i = 0;
        $last_url = '';
        $url = $link;

        while($last_url != $url && $i < 5) {
            if($i > 0) {
                $last_url = $url;
            }

            // $url = $this->location($url);
            $url = $this->resolver->resolveURL($url)->getURL();
            $url = $this->google($url);            
            $i++;
        }

        $url = $this->strip_hashtag($url);
        $url = $this->strip_query_string($url);

        return $url;
    }
}