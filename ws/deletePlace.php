<?php
    require_once('../script/db.php');
    require_once('../script/classes/Settings.php');
    
    db_connect();
    $settings = new CBMPSettings();

    if(isset($_POST['id'])){
        //we verify if editing is enable
        if($settings->getSettingValue('cbmp_application_EditLocation')=='enabled' && $settings->getSettingValue('cbmp_application_DeleteLocation')=='enabled'){
            $id = intval($_POST['id']);
        
            $sql = "DELETE FROM scs_places WHERE id=$id";
        
            $result = mysql_query($sql);
        }
    }
    else{
        error_log('No Id supplied to delete place');   
    }
?>