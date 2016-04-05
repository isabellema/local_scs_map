<?php
require_once('script/db.php');
require_once('script/string.php');

 /**
  * Form that is displayed when user is adding a place
  */
if(isset($_GET['id']) && strlen(trim($_GET['id'])) > 0 ){
    db_connect();
    $id = intval($_GET['id']);
    $sql_query = "SELECT DISTINCT scs_places.id as id, scs_places.name as placeName, lat, lng, description, website, facebook, twitter, scs_categories.name as category, scs_categories.id as cat_id FROM scs_places, scs_categories WHERE scs_places.id_category=scs_categories.id AND scs_places.id=$id";
    $result= mysql_query($sql_query);
    
    if($result && mysql_numrows($result)>0){
        $row = mysql_fetch_assoc($result);    


?>
<form method='POST' action='ws/addPlace.php' onsubmit='return(sendFormData(this));'>
    <input type='hidden' name='id' value='<?=$id?>' />
    <input type='text' placeholder='Name' name='name' value="<?=utf8_encode($stripslashes($row['placeName']))?>" />
    <textarea rows=4 placeholder='Description' name='desc'><?=utf8_encode($stripslashes($row['description']))?></textarea>
    <input type='text' placeholder='http://' name='website' value='<?=$row['website']?>' />
    <input type='text' placeholder='URL Facebook' name='facebook' value='<?=$row['facebook']?>' />
    <input type='text' placeholder='URL twitter' name='twitter' value='<?=$row['twitter']?>' />
<!--    <span>Definitely Closed : <input type="checkbox" name="def_closed" <?=$row['def_closed']?'checked':''?> value="1"/></span>-->
    <?php
        $query="SELECT id, name FROM scs_categories";
        
        $result = mysql_query($query);
        if($result){
        ?>
        <select name='type'>
            <?php while($rowPlaces=mysql_fetch_assoc($result)) : ?>
                <option <?php if($rowPlaces['id'] === $row['cat_id']) echo "selected";?> value='<?=$rowPlaces['id']?>'><?=$rowPlaces['name']?></option>
            <?php endwhile; ?>
        </select>
        
        <?php
        }    
        ?>
    <input type='submit' value='SAVE' />
    
</form>
<?php
        mysql_close();
    }
}else{
?>
<p>An error occured. Please, try again later</p>
<?php
}
?>
