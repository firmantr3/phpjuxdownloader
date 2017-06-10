<?php
    require "mycurl.php";
    
    $tsnow = time();
    $get_ = $tsnow++;
    $sid = urlencode(strip_tags($_GET['id']));
    $fname = urlencode(strip_tags($_GET['fname']));
    $ref = "http://www.joox.com";
    $u_agent = "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36";
    $callback = "MusicInfoCallback";
    $curlnya = new mycurl("http://api.joox.com/web-fcgi-bin/web_get_songinfo?songid=$sid&lang=id&country=id&from_type=1&channel_id=199&_=$tsnow");
    $curlnya->createCurl();
    $response = $curlnya->__tostring();
    $data = json_decode(str_replace(")","",(str_replace("$callback(","",$curlnya->__tostring()))),true);
    //print_r($data);exit;
    $file_url = $data['m4aUrl'];
    if(isset($_GET['ajax'])) {
        $data['fname'] = $fname;
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    else {
        if(isset($_GET['mp3'])) {
            /*
            $tmp_fname = md5($fname);
            
            if(!file_exists("tmp/".$tmp_fname."r.mp3")) {
                if(!file_exists("tmp/$tmp_fname" . "r.m4a")) {
                    file_put_contents("tmp/$tmp_fname.m4a",file_get_contents($file_url));
                    if(!file_exists("tmp/$tmp_fname" . "r.m4a")) {
                        rename("tmp/$tmp_fname.m4a","tmp/$tmp_fname" . "r.m4a");
                    }
                    echo exec("ffmpeg/ffmpeg -v 5 -y -i tmp/".$tmp_fname."r.m4a -acodec libmp3lame -ac 2 -ab 128k -id3v2_version 3 -write_id3v1 1 -map_metadata 0 -metadata title=\"$_GET[title]\" -metadata artist=\"$_GET[artist]\" -metadata album=\"$_GET[album]\" -metadata encoded_by=\"JOOXeCROT FFmpeg\" tmp/".$tmp_fname.".mp3");
                    rename("tmp/$tmp_fname.mp3","tmp/$tmp_fname" . "r.mp3");
                    unlink("tmp/$tmp_fname" . "r.m4a");
                }
                else {
                    while(!file_exists("tmp/".$tmp_fname."r.mp3")) {
                        sleep(10);
                    }
                }
            }
            
            if(file_exists("tmp/".$tmp_fname."r.mp3")) {
                header("Pragma: public");
                header('Content-Type: application/octet-stream');
                header("Content-Transfer-Encoding: Binary"); 
                header("Content-Disposition: attachment; filename=\"" . urldecode($fname) . ".mp3\""); 
                header('Content-Length: ' . filesize("tmp/".$tmp_fname."r.mp3")); // Add this line
                readfile("tmp/".$tmp_fname."r.mp3");
                
                if(file_exists("tmp/$tmp_fname" . "r.m4a")) {
                    unlink("tmp/$tmp_fname" . "r.m4a");
                }
            }*/
            
            header("Pragma: public");
            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary"); 
            header("Content-Disposition: attachment; filename=\"" . urldecode($fname) . ".mp3\"");
            $file_url = $data['mp3Url'];
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