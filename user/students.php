<?php 
 $title= "Students";
 $page_name="table.form";
 $table=array(
    "first_name"=>"First Name",
    "last_name"=>"Last Name",
    "address"=>"Address",
    "medical"=>"Medical_Information",
    "class_name"=>"Class_Name",
    "Delete"=>"Delete"
 );
?>

<!DOCTYPE html>
<html lang="en">
<?php 
    require "./common/head.php";
?>
<body>
    <?php
        require "./common/header.php";
    ?>
    <main>
        <?php 
            require "./common/table.php";
        ?>

<form action="" method="POST" id="management" class="container">
            <div class="form-title">
                <span>Add New Student</span>
            </div>

                <div class="form-item">
                    <label for="first_name">First Name</label>
                    <div class="input">
                        <input type="text" class="form-allitem" name="first_name" placeholder="Enter:" id="first_name">
                    </div>
                </div>
                <div class="form-item">
                    <label for="last_name">Last Name</label>
                    <div class="input">
                        <input type="text" class="form-allitem" name="last_name" placeholder="Enter:" id="last_name">
                    </div>
                </div>
                <div class="form-item">
                    <label for="class_name">Class Name</label>
                    <select name="class_name" id="class_name" class="form-allitem">
                        <option value="none" selected> -select-class-</option>
                        <?php 
                        require "../config/db.php";
                        $stmt=$conn->prepare("SELECT class_name,Grade FROM classes");
                        $stmt->execute();
                        $classes=$stmt->fetchAll(PDO::FETCH_ASSOC);
                        if($classes){
                            foreach($classes as $k=>$v){
                                $v = htmlspecialchars($v['Grade']).": ".htmlspecialchars($v['class_name']);
                                echo "<option value=".$v.">".$v."</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-item">
                    <label for="class_name">Address</label>
                    <div class="input">
                        <input type="text" class="form-allitem" name="class_name" placeholder="class name" id="class_name">
                    </div>
                </div>

                <div class="form-item textarea">
                    <label for="medicalInfro">Medical Information</label>
                    <textarea name="medicalInfro" id="medicalInfro"></textarea>
                </div>
                <div class="button">
                    <button type="button" id="insertbtn">Insert</button>
                </div>
        </form>

    </main>
    <?php   
        require "./common/footer.php";
    ?>

</body>
</html>