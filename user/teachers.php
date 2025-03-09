<?php 
 $title= "Teachers";
 $page_name="table.form";
 $table=array(
    "first_name"=>"First Name",
    "last_name"=>"Last Name",
    "phone"=>"Phone",
    "bcc"=>"BackgroundCheck",
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
            require "./common/table.php"
        ?>
        <!-- form section for insert section start -->

        <form action="" method="POST" id="management" class="container">
            <div class="form-title">
                <span>Add New Teachers</span>
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
                    <label for="phone">Phone Number</label>
                    <div class="input">
                        <input type="text" class="form-allitem" name="phone" placeholder="e.g., +44(07) 7xxxxx xxxx" id="phone">
                    </div>
                </div>
                <div class="form-item">
                    <sapn>Background Check</sapn>
                        <div class="input for_radio">
                            <div class="radio-item">
                                <label for="bcc1">Not Check</label>
                                <input name="bcc" id="bcc1" type="radio" value="no">
                            </div>
                            <div class="radio-item">
                                <label for="bcc2">Checked</label>
                                <input name="bcc" id="bcc2" type="radio" value="yes">
                            </div>
                        </div>
                </div>
                <div class="button">
                    <button type="button" id="insertbtn">Insert</button>
                </div>
        </form>
    </main>
    <?php   
        require "./common/footer.php"
    ?>
    
    <script>
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
            isEnough(document.getElementById("first_name"),1,50,"First Name Length");
            isEnough(document.getElementById("last_name"),1,50,"First Name Length");
            if (hasEmptyField) {
                return; 
            }
            // fetch request accepte
            async function getInsert(){
                let res=await fetch("../api/teacherV.php",{
                    method:"POST",
                    body: formDatas
                });
                let data=await res.json();
                console.log(data);
                if(data.code !=0){
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
    </script>
</body>
</html>