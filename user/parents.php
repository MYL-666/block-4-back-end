<?php 
 $title= "Parents";
 $page_name="form";
 $table=array(
    "id"=>"ID",
    "name"=>"Name",
    "phone"=>"Phone",
    "email"=>"Email",
    "Kid1"=>"Kids 1",
    "kid2"=>"Kids 2",
    "Delete"=>"Delete"
 );
?>

<!DOCTYPE html>
<html lang="en">
<?php 
    require "./common/head.php"
?>
<body>
    <?php
        require "./common/header.php";
    ?>
    <main>
    <?php
        require "./common/table.php";
    ?>
    </main>
    <?php   
        require "./common/footer.php"
    ?>

</body>
</html>