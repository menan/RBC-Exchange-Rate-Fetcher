<?php
function do_post_request($url, $data, $optional_headers = null)
  {
     $params = array('http' => array(
                  'method' => 'GET',
                  'content' => $data
               ));
     if ($optional_headers !== null) {
        $params['http']['header'] = $optional_headers;
     }
     $ctx = stream_context_create($params);
     $fp = @fopen($url, 'rb', false, $ctx);
     if (!$fp) {
        throw new Exception("Problem with $url, $php_errormsg");
        //echo "2Please enter a valid zshare id to watch the video";
     }
     $response = @stream_get_contents($fp);
     if ($response === false) {
        echo "Vazhga Vazhamudan";
     }
     return $response;
  }
?>