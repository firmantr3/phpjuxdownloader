<?php
    require "mycurl.php";
    
    $tsnow = time();
    $get_ = $tsnow++;
    $sid = urlencode(strip_tags($_GET['id']));
    $fname = urlencode(strip_tags($_GET['fname']));
    $ref = "http://www.joox.com";
    $u_agent = "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36";
    $callback = "MusicInfoCallback";
    $curlnya = new mycurl("https://api.joox.co.th/openjoox/v1/track/{$sid}?country=id&lang=id&lyric=1");
    $curlnya->createCurl();
    $response = $curlnya->__tostring();
    $data = json_decode($response, true);
    
    $files = [
        'mp3' => [
            'quality' => 0,
            'url' => null,
        ],
        'm4a' => [
            'quality' => 0,
            'url' => null,
        ],
    ];

    if(isset($data['play_url_v2'])) {
        foreach ($data['play_url_v2'] as $key => $value) {
            // file ext check
            // m4a
            if(strpos($value['url'], '.m4a') !== false) {
                if($value['quality'] > $files['m4a']['quality']) {
                    $files['m4a']['quality'] = $value['quality'];
                    $files['m4a']['url'] = $value['url'];
                }
            }
            // mp3
            else {
                if($value['quality'] > $files['mp3']['quality']) {
                    $files['mp3']['quality'] = $value['quality'];
                    $files['mp3']['url'] = $value['url'];
                }
            }
        }
    }
    elseif(isset($data['play_url'])) {
        // file ext check
        // m4a
        if(strpos($value['standard_play_url'], '.m4a') !== false) {
            $files['m4a']['url'] = $value['standard_play_url'];
        }
        // mp3
        else {
            $files['mp3']['url'] = $value['standard_play_url'];
        }
    }
    else {
        throw new Exception('failed to get data!', 422);
    }

    $file_url = $files['m4a']['url'];

    if(isset($_GET['ajax'])) {
        $data['fname'] = $fname;
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    else {
        if(isset($_GET['mp3'])) {
            $file_url = $files['mp3']['url'];
            
            header("Pragma: public");
            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary"); 
            header("Content-Disposition: attachment; filename=\"" . urldecode($fname) . ".mp3\"");
            readfile($file_url);
        }
        else {
            header("Pragma: public");
            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary"); 
            header("Content-Disposition: attachment; filename=\"" . urldecode($fname) . ".m4a\"");
            readfile($file_url);
        }
    }
?>
