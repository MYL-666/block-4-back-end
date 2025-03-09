<?php 
 $title= "Classes";
 $table_name="classes";
$page_name="table.form";
$table=array(
    "grade"=>"Grade",
    "name"=>"Name",
    "teacher"=>"Teacher",
    "capacity"=>"Capacity",
    "Delete"=>"Delete",
    "Update"=>"Update"
 );

 $form_item=array(
    "grade",
    "class_name",
    "teacher_name",
    "capacity"
 )

?>

<!DOCTYPE html>
<html lang="en">
<?php 
     // connect mysql
    //  require "../config/db.php";
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
         <!-- form section for insert section start -->

        <form action="" method="POST" id="management" class="container">
            <div class="form-title">
                <span>Add New Class</span>
            </div>
                <div class="form-item">
                    <label for="year">The Grade of Class</label>
                    <select name="grade" id="year" class="form-allitem">
                        <option value="none" selected> -select-year-</option>
                        <option value="reception_year">Reception Year</option>
                        <option value="year_one">Year One</option>
                        <option value="year_two">Year Two</option>
                        <option value="year_three">Year Three</option>
                        <option value="year_four">Year Four</option>
                        <option value="year_five">Year Five</option>
                        <option value="year_six">Year Six</option>
                    </select>
                </div>
                <div class="form-item">
                    <label for="class_name">Class Name</label>
                    <div class="input">
                        <input type="text" class="form-allitem" name="class_name" placeholder="class name" id="class_name">
                    </div>
                </div>

                <div class="form-item">
                    <label for="teacher_name">Teacher of this Class</label>
                    <div class="input">
                        <input type="text" class="form-allitem" name="teacher_name" placeholder="teacher name" id="teacher_name">
                    </div>
                </div>
                <div class="form-item">
                    <label for="capacity">Capacity of this Class</label>
                    <div class="input">
                        <input type="text" class="form-allitem" name="capacity" placeholder="capacity (e.g, 20~50)" id="capacity">
                    </div>
                </div>
                <div class="button">
                    <button type="button" id="insertbtn">Insert</button>
                </div>
        </form>
    </main>
    <?php   
        require "./common/footer.php";
        require "../user/common/management.php";
        
    ?>
<script>
    window.addEventListener("load", function() {

        document.getElementById("insertbtn").addEventListener("click",function(e){
            e.preventDefault();
            let hasEmptyField = false;
            let form=document.getElementById("management");
            let formDatas=new FormData(form);
            document.querySelectorAll(".form-allitem").forEach(item => {
                if (isEmpty(item)) {
                    hasEmptyField = true;
                }
            });
            isEnough(document.getElementById("capacity"),20,50,"Class capacity");   
            if (hasEmptyField) {
                return; 
            }
            // fetch request
            async function getInsert(){
                let res =await fetch("../api/classV.php",{
                    method:"POST",
                    body: formDatas
                })

                let data=await res.json();
                console.log(data);
                if(data.code !==0){
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: data.msg,
                        });
                    }else{
                        Swal.fire({
                          title: "Sign Up Successed!",
                          icon: "success",
                        }).then(()=>{
                            // clear the form if success
                            form.reset()
                        })
                    
                    }
                
            }
            getInsert();
            
        })
});
</script>
</body>
</html>