<html>
    <head>
        <title>JOOXeCROT</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>JOOXeCROT</h1>
                    <form method="get" action="index.php">
                        <div class="form-group">
                            <label>Golet:</label>
                            <?php
                                $s_val = isset($_GET['s']) ? $_GET['s'] : "";
                            ?>
                            <input type="text" class="form-control" name="s" value="<?php echo $s_val; ?>" autofocus />
                        </div>
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-search"></i> KAYA NGAPA? MAYUH TILIKI</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
            if(isset($_GET['s'])) {
                require "mycurl.php";
                
                $tsnow = time();
                $get_ = $tsnow++;
                $search = urlencode(strip_tags($_GET['s']));
                $ref = "http://www.joox.com/searchResult?q=$search&lang=id_id";
                $u_agent = "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36";
                $callback = "jQuery1100006428111118025859_$tsnow";
                $pn = isset($_GET['pn']) ? strip_tags($_GET['pn']) : 1;
                $sin = isset($_GET['sin']) ? strip_tags($_GET['sin']) : 0;
                $ein = isset($_GET['ein']) ? strip_tags($_GET['ein']) : 29;
                $curlnya = new mycurl("http://api.joox.com/web-fcgi-bin//web_search?callback=$callback&lang=id&country=id&type=0&search_input=$search&pn=$pn&sin=$sin&ein=$ein&_=$get_");
                $curlnya->createCurl();
                $response = $curlnya->__tostring();
                $data = json_decode(str_replace(")","",(str_replace("$callback(","",$curlnya->__tostring()))),true);
                $jml = $data['sum'];
                $pages = ceil($jml/30);
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><a href="index.php" class="btn btn-danger"><i class="fa fa-fw fa-arrow-left"></i> BALIK</a><span class="pull-right">DAFTAR GOLET JOOXeCROT</span></h1>
                    <div class="table-responsive">
                        <table class="table table-condensed table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">NO</th>
                                    <th class="text-center">JENENG</th>
                                    <th class="text-center">ALBUM</th>
                                    <th class="text-center">DAUNLOD</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                    foreach($data['itemlist'] as $rs) {
                                        $artist = base64_decode($rs['info2']);
                                        $title = base64_decode($rs['info1']);
                                        $album = base64_decode($rs['info3']);
                                        $sname = $artist . " - " . $title;
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td><?php echo $sname; ?></td>
                                    <td class="text-center"><?php echo $album; ?></td>
                                    <td class="text-center">
                                        <a onclick="window.open(this.href);return false;" href="jooxplay.php?id=<?php echo $rs['songid']; ?>&fname=<?php echo urlencode($sname); ?>&artist=<?php echo urlencode($artist); ?>&title=<?php echo urlencode($title); ?>&album=<?php echo urlencode($album); ?>" class="btn btn-primary btn-download"><i class="fa fa-fw fa-download"></i> M4A</a>
                                        <a onclick="window.open(this.href);return false;" href="jooxplay.php?id=<?php echo $rs['songid']; ?>&fname=<?php echo urlencode($sname); ?>&artist=<?php echo urlencode($artist); ?>&title=<?php echo urlencode($title); ?>&album=<?php echo urlencode($album); ?>&mp3" class="btn btn-primary btn-download"><i class="fa fa-fw fa-download"></i> MP3</a>
                                        <a onclick="window.open(this.href);return false;" href="jooxlyric.php?id=<?php echo $rs['songid']; ?>&fname=<?php echo urlencode($sname); ?>&artist=<?php echo urlencode($artist); ?>&title=<?php echo urlencode($title); ?>&album=<?php echo urlencode($album); ?>" class="btn btn-primary btn-download"><i class="fa fa-fw fa-download"></i> LIRIK</a>
                                        <a href="#" data-target="#myModal" data-toggle="modal" data-mp3="jooxplay.php?id=<?php echo $rs['songid']; ?>&fname=<?php echo urlencode($sname); ?>&artist=<?php echo urlencode($artist); ?>&title=<?php echo urlencode($title); ?>&album=<?php echo urlencode($album); ?>&mp3" data-m4a="jooxplay.php?id=<?php echo $rs['songid']; ?>&fname=<?php echo urlencode($sname); ?>&artist=<?php echo urlencode($artist); ?>&title=<?php echo urlencode($title); ?>&album=<?php echo urlencode($album); ?>" class="btn btn-primary btn-download"><i class="fa fa-fw fa-play"></i> JAJAL</a>
                                    </td>
                                </tr>
                                <?php
                                        $no++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <ul class="pagination">
                            <?php
                                for($i=1;$i<=$pages;$i++) {
                                    $sin = ($i - 1) * 30;
                                    $ein = $sin + 29;
                                    $active = $i == $pn ? "active" : "";
                                    echo "<li class=\"$active\"><a href=\"index.php?s=$search&pn=$i&sin=$sin&ein=$ein\">$i</a></li>";
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">JAJAL</h4>
                    </div>
                    <div class="modal-body text-center">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">WIS</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                $("#myModal").on("show.bs.modal",function(e) {
                    var btnPrev = $(e.relatedTarget);
                    var this_elem = $(this);
                    this_elem.find(".modal-body").append(
                        "<audio style=\"width:100%;\" controls autoplay>" +
                            "<source src=\"" + btnPrev.data("mp3") + "\" type=\"audio/mpeg\">" +
                            "<source src=\"" + btnPrev.data("m4a") + "\" type=\"audio/mpeg\">" +
                            "Your browser does not support the audio element." +
                        "</audio>"
                    );
                })
                .on("hide.bs.modal",function() {
                    var this_elem = $(this);
                    this_elem.find(".modal-body").empty();
                });
            });
        </script>
        <?php
            }
        ?>
    </body>
</html>