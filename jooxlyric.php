<?php
    require "mycurl.php";
    
    $tsnow = time();
    $get_ = $tsnow++;
    $sid = urlencode(strip_tags($_GET['id']));
    $fname = urlencode(strip_tags($_GET['fname']));
    $ref = "http://www.joox.com";
    $u_agent = "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36";
    $callback = "MusicJsonCallback";
    $apiurl = "http://api.joox.com/web-fcgi-bin/web_lyric?musicid=$sid&lang=en&country=id&_=$tsnow";
    $curlnya = new mycurl($apiurl);
    $curlnya->createCurl();
    $response = $curlnya->__tostring();
    $data = json_decode(str_replace(")","",(str_replace("$callback(","",$curlnya->__tostring()))),true);
    //print_r($data);exit;
    if(isset($_GET['ajax'])) {
        $data['fname'] = $fname;
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    else {
        header("Pragma: public");
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-Disposition: attachment; filename=\"" . urldecode($fname) . ".lrc\"");
        echo base64_decode($data['lyric']);
    }
?>