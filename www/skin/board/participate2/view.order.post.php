<div class="nextVideo_list list_asc">
    <?php
        $sql = "select
            *
        from
            g5_write_".$bo_table."
        order by
            wr_subject asc";

        $result = sql_query($sql, true);

        while($row=sql_fetch_array($result)) {
            $wr_href = $g5_bbs_url."?bo_table=".$board['bo_table']."&wr_id=".$row['wr_id'];
        
    ?>
        <li class="vdo_box box_<?php echo $row['wr_id'];?> <?php if($row['wr_id'] == $view['wr_id']){ echo "on"; } ?>">
            <a href="<?php echo $wr_href; ?>">
                <div class="img"> <div class="vimeo-img" id="vimeo-<?php echo $row['wr_3'] ?>"></div></div>
                <div class="txt">
                    <p class="t">#<?php echo $row['wr_subject']." ".$row['wr_1'] ?></p>
                    <p class="c">
                        <?php echo $row['wr_hit']?>명<br/>
                        <?php echo $row['wr_2']?>
                    </p>
                </div>
                <script>
                    $(function() {
                        vimeoLoadingThumb("<?php echo $row['wr_3'] ?>");
                    });
                </script>
            </a>
        </li>
    <?php } ?>
</div>

<script>
function vimeoLoadingThumb(id){ 
    var url = "http://vimeo.com/api/v2/video/" + id + ".json?callback=showThumb";
    var id_img = "#vimeo-" + id;
    var script = document.createElement( 'script' );
    script.type = 'text/javascript';
    script.src = url;
    $(id_img).before(script);
}


function showThumb(data){
    var id_img = "#vimeo-" + data[0].id;
    $(id_img).css('background-image',`url(${data[0].thumbnail_medium})`);
}

</script>