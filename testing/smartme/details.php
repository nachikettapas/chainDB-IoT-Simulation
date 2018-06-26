<html>
<?php
require 'function.php';
//require_once ('assets/jsonpath.php');
//require_once ('assets/JSON.php');

$name_dataset = $_REQUEST['pack_name'];
$id_dataset = $_REQUEST['pack_id'];
$id_resource = $_REQUEST['res_id'];
$url='http://smartme-data.unime.it/api/action/datastore_search?resource_id='.$id_resource;
//echo $url;
//$url = 'http://smartme-data.unime.it/api/3/action/package_show?id=' . $id_dataset;
$data = call_api($url);

$pack= call_api($url='http://smartme-data.unime.it/api/3/action/package_show?id='.$id_dataset);
//$parser = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
//$o = $parser-> decode($data);
?>

<div class="modal-header">
    <a href="#" class="pull-right" data-dismiss="modal" aria-label="Close">
        <span class="fa fa-close"></span>
    </a>
<h3 class="text-bold">
    Board Name: <span class="text-capitalize text-primary"><?=$pack->result->extras[1]->value ?></span>
    <span class="text-olive small text-bold">[<?=$pack->result->extras[4]->value ?> <?=$pack->result->extras[5]->value ?>]</span>
    <div class="small">
        <a target="_blank" class="" href="http://smartme-data.unime.it/dataset/<?= $id_dataset; ?>"><i class="fa fa-external-link"></i> OpenData</a> on SmartMe-Data
    </div>
</h3>
    <div class="row">
        <div class="col-md-12">
            <a href="#" id="click_adopt" class="btn btn-success btn-xs"><span class="fa fa-share-alt"></span> Embed in your website</a>
            <textarea readonly id="copy_paste" style="width:60%; height:60px" class="small hidden" ><iframe width="400" height="400" src="http://smartme.unime.it/embed.php?board_name=<?=preg_replace('/\s+/', '_',$pack->result->extras[1]->value)?>&pack_name=<?=$id_dataset ?>" frameborder="0"></iframe></textarea>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="modal-body">
    <!-- Info boxes -->
    <div class="row">
        <div class="box-body">
        <?php
            foreach ($data->result->records as $sensor) {
                switch ($sensor->Type) {
                    case 'sound_detect':
                        $color = 'bg-aqua';
                        $icon = 'fa fa-volume-up';
                        break;
                    case 'temperature':
                        $color = 'bg-yellow';
                        $icon = 'fa fa-sun-o';
                        break;
                    case 'brightness':
                        $color = 'bg-green';
                        $icon = 'fa fa-lightbulb-o';
                        break;
                    case 'humidity':
                        $color = 'bg-red';
                        $icon = 'fa fa-tint';
                        break;
                    case 'pressure':
                        $color = 'bg-purple';
                        $icon = 'fa fa-dot-circle-o';
                        break;
                    case 'gas':
                        $color = 'bg-maroon';
                        $icon = 'fa fa-industry';
                        break;
                    case 'coordinates':
                        $color = 'bg-teal';
                        $icon = 'fa fa-compass';
                        break;
                    case 'barometer':
                        $color = 'bg-purple';
                        $icon = 'fa fa-dot-circle-o';
                        break;
                } ?>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon <?=$color?>"><i style="margin-top: 20px" class="<?=$icon?>"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-number"><?= ucfirst($sensor->Type) ?></span>
                            <span class="label label-danger"><i class="fa fa-tag"></i> <?= $sensor->FabricName ?></span>
                            <span class="label label-success"><i class="fa fa-tag"></i> <?= $sensor->Model ?></span>
                            <span class="label label-info"><i class="fa fa-tag"></i> <?= $sensor->Unit ?></span>
                            <?php
                            if ($sensor->Type=="gas"){?>
                                <p><a class="btn btn-sm btn-primary disabled pull-right" href="#"><i class="fa fa-clock-o"></i> Coming Soon</a></p>
                            <?php } else {?>
                                <p><a class="btn btn-sm btn-primary pull-right" target="_blank" href="http://smartme-data.unime.it/dataset/<?= $name_dataset; ?>/resource/<?= $sensor->ResourceID ?>"><i class="fa fa-external-link"></i> OpenData</a></p>
                            <?php }?>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div>
            <?php }?>
        </div><!-- /.box-body -->
    </div>
</div>

<script>
    $('#click_adopt').on('click',function(e){
        e.preventDefault();

        $('#copy_paste').toggleClass('hidden').focus().select();


    })
</script>