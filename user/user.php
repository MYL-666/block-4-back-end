<?php 
session_start();
 $title= "User";
 $page_name="user";
 $userLastName = "";
 $userFirstName = "";
 $userEmail = "";
 $userGender = "";
 $userBirth = "";
 $userId='';
 require "../config/db.php";
 $sql="SELECT *  from user where username=:username";
 $stmt=$conn->prepare($sql);
 $stmt->bindParam(":username",$_SESSION["username"]);
 $stmt->execute();
 $resultUser=$stmt->fetch(PDO::FETCH_ASSOC);
 if($resultUser){
    $userId=$resultUser['id'] ?? "";
    $userLastName=$resultUser["Last_Name"] ?? "";
    $userFirstName=$resultUser["First_Name"] ?? "";
    $userEmail=$resultUser["email"] ?? "";
    $userGender=$resultUser["Gender"] ?? "";
    $userBirth = date('Y-m-d', strtotime($resultUser["birthday"]));
 }
 function checkNull($str){
    if(!$str==null){
        echo $str;
    }
 }
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
        <div class="container usercontainer">
        <div class="progress-container">
            <div class="progress-circle">
                <span id="progress-text">75%</span>
            </div>
        </div>

            <div class="left">
                <div class="img">
                    <img <?php 
                        if($_SESSION["role"]==="admin"){
                            echo 'src="../public/img/admin.svg"';
                        }
                        if($_SESSION["role"]==="student"){
                            echo 'src="../public/img/student.svg"';
                        }
                        if($_SESSION["role"]==="teacher"){
                            echo 'src="../public/img/teacher.svg"';
                        }
                        if($_SESSION["role"]==="parent"){
                            echo 'src="../public/img/parent.svg"';
                        }
                    ?>
                     alt="profile photo">
                </div>
                <div class="names">
                    <span><?php echo $_SESSION["role"]; ?></span>
                    <p><?php echo $_SESSION["username"]; ?></p>
                </div>
                <div class="settings">
                    <div class="setting-item">Profile</div>
                    <div class="setting-item setting-items">Account Settings</div>
                    <div class="setting-item setting-items">Privacy & Security</div>
                    <div class="setting-item setting-items">Notifications</div>
                </div>
            </div>
            <div class="right">
                <div class="setting-title">
                    <span>Profile</span>
                </div>
                <form id="userForm" method="POST">
                    <div class="input-item">
                        <label for="username">UserName</label>
                        <div class="input">
                            <input class="count" type="text" id="username" name="username" value=<?php 
                                checkNull($_SESSION['username']);
                            ?> placeholder="Enter:"> 
                        </div>
                    </div>

                    <div class="input-item">
                        <label for="firstName">First Name</label>
                        <div class="input">
                            <input class="count" type="text" id="firstName" name="firstName" placeholder="Enter :" value="<?php 
                                checkNull($userFirstName);
                            ?>">
                        </div>
                    </div>

                    <div class="input-item">
                        <label for="lastName">Last Name</label>
                        <div class="input">
                            <input class="count" type="text" id="lastName" placeholder="Enter :" name="lastName" value="<?php 
                                checkNull($userLastName);
                            ?>">
                        </div>
                    </div>

                    <div class="input-item">
                        <label for="email">Email</label>
                        <div class="input">
                            <input class="count" type="text" id="email" placeholder="Enter :" name="email" value="<?php 
                                checkNull($userEmail);
                            ?>" >
                        </div>
                    </div>

                    <div class="input-item radio">
                        <span>Gender</span>
                        <div class="input">
                            <div class="radio-item">
                                <label for="male">Male</label>
                                <input type="radio" id="male" name="gender" value="Male" <?php if($userGender==='Male') echo "checked";  ?>>
                            </div>
                            <div class="radio-item">
                                <label for="female">Female</label>
                                <input type="radio" id="female" name="gender" value="Female" <?php if($userGender==='Female') echo "checked";?>>
                            </div>
                        </div>
                    </div>

                    <div class="input-item">
                        <label for="birth">Birthday</label>
                        <div class="input">
                            <input type="date" class="count" id="birth" name="birth" value="<?php echo htmlspecialchars($userBirth); ?>">
                        </div>
                    </div>
                    <button id="save">Save</button>
                </form>
            </div>
        </div>
    </main>
    <?php   
        require "./common/footer.php";
    ?>
    <script>
        document.querySelectorAll(".setting-items").forEach(element => {
            element.addEventListener("click",function(){
                Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "This function not avalibale yet!",
                        });
            })
        });

        document.getElementById("save").addEventListener("click",function(e){
            e.preventDefault();
            const formData = new FormData(document.getElementById("userForm"));
            async function updateUser(){
                let res =await fetch("../api/userV.php",{
                    method:"POST",
                    body: formData
                })
                let data=await res.json();
                console.log(data);
                if(data.code!==0){
                    Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: data.msg,
                        });
                }else{
                    Swal.fire({
                          title: "Update Successed!",
                          icon: "success"
                    });
                    updateProgress(); 
                }
            }
            updateUser();
           
        })


            function updateProgress() {
                 const progressCircle = document.querySelector(".progress-circle");
                 const progressText = document.getElementById("progress-text");
                 let fildesCount=0;

                 document.querySelectorAll(".count").forEach(element => {
                    if(element.value.trim()!=='' || element.value.trim()==="null"){
                        fildesCount++;
                    }
                 });
                 if(document.getElementById("male").checked || document.getElementById("female").checked){
                    fildesCount++;
                 }

                const percentage = Math.round((fildesCount / 6) * 100);
                progressCircle.style.background = `conic-gradient(#5B9591 ${percentage}%, #ddd 0%)`;
                progressText.innerText = `${percentage}%`;
             }


        updateProgress();  


    </script>
</body>
</html>