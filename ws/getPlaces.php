<?php
    require_once('../script/db.php');

    db_connect();

    $sql = "SELECT DISTINCT scs_places.id as id, scs_places.name as place, lat, lng, scs_categories.name as category, scs_categories.clustercolor as color FROM place, category WHERE scs_places.id_category=scs_categories.id";
    if(isset($_GET['q'])){
        $filter = mysql_real_escape_string($_GET['q']);
        $sql .= " AND scs_places.name like '%$filter%'";
    }
    $result = mysql_query($sql);
?>
[
<?php
    if($result && mysql_num_rows($result)>0){
        $cpt=1;
        $nb_places = mysql_num_rows($result);
        while($row = mysql_fetch_assoc($result)){
?>

    {
        "id" : <?=$row['id']?>,
        "name" : "<?=htmlspecialchars(addslashes((utf8_encode($row['place']))))?>",
        "lat" : <?=$row['lat']?>,
        "lng" : <?=$row['lng']?>,
        "type" : "<?=$row['category']?>",
        "color" : "<?=$row['color']?>"
    }
<?php
            if($cpt < $nb_places){
                echo ",";
            }
            $cpt++;
        }
    }

    mysql_close();
?>
]