<?php
//print_r($res1);
?>
<div class='col-md-6'>
    <select class='form-control' name='basic_field[]' multiple>    
    <?php
    foreach($res1 as $key=>$value){
        ?>
        <option value="<?=$value['id']?>"><?=$value['title']?></option>
        <?php
    }
    ?>
    </select>
</div>

<div class='col-md-6'>
    <select class='form-control' name='dynamic_field[]' multiple>    
    <?php
    foreach($res as $key=>$value){
        ?>
        <option value="<?=$value['input_id']?>"><?=$value['input_label']?></option>
        <?php
    }
    ?>
    </select>
</div>