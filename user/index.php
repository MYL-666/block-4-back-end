<?php 
 $title= "Home Page";
 $page_name="index";
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
        <div class="container">
            <div class="intro">
                <div class="left">
                    <div class="bcc"></div>
                    <img src="../public/img/teachers.jpg" alt="teacher & student">
                </div>
                <div class="right">
                    <div class="sentence">
                        <i class="iconfont icon-dagou-4"></i>
                        <p>Quality Education</p>
                        <span>Lorem ipsum dolor sit amet.</span>
                    </div>
                    <div class="sentence">
                        <i class="iconfont icon-dagou-4"></i>
                        <p>Personalized Learning</p>
                        <span>Lorem ipsum .</span>
                    </div>
                    <div class="sentence">
                        <i class="iconfont icon-dagou-4"></i>
                        <p>Positive Environment</p>
                        <span>Lorem ipsum dolor sit amet.</span>
                    </div>
                    <button>More Infromation &nbsp;&nbsp;&nbsp;→</button>
                </div>
            </div>
            <div class="boxes">
                <div class="title">Systems Management</div>
                <div class="shell">
                    <div class="box">
                        <i class="iconfont icon-banjiketang"></i>
                        <span id="myClass">Classes</span>
                    </div>
                    <div class="box ">
                        <i class="iconfont icon-Student"></i>
                        <span id="kids">Pupils</span>
                    </div>
                    <div class="box ">
                        <i class="iconfont icon-parents"></i>
                        <span id="myParents">Parents/Guardians</span>
                    </div>
                    <div class="box ">
                        <i class="iconfont icon-teacher_basic"></i>
                        <span id="myTeacher">Teachers</span>
                    </div>
                    <div class="box ">
                        <i class="iconfont icon-gongzi"></i>
                        <span id="mySalaries">Salaries</span>
                    </div>
                    <div class="box ">
                        <i class="iconfont icon-library"></i>
                        <span>Library Books</span>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <!-- import Footer section -->
    <?php   
        require "./common/footer.php"
    ?>

    <script>
        function accessAlert(){
            Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "You dont have access to this block",
                        });
        }
        window.onload=function(){
            let boxes=document.querySelectorAll(".box");

        
        // for admin users, they are allowed to check and manage all blocks
        boxes.forEach((box,index) => {
            if(userRole==="admin"){
                
                box.classList.add("admin");
                box.onclick=function(){
                window.location.href=links1[index]+".php";
                }
            }       
        });

        // for students, they are only allowed to check everything except slaries
        if(userRole==="student"){
                let student_box=[boxes[0],boxes[1],boxes[2],boxes[3],boxes[5]];
                let student_box2=[boxes[4]]

                document.getElementById("kids").innerText="Me";
                document.getElementById("myClass").innerText="My Class";
                document.getElementById("myTeacher").innerText="My Teacher";
                document.getElementById("myParents").innerText="My Parents";

                student_box.forEach((box,index)=>{
                    box.classList.add("student");
                    box.onclick=function(){                        
                        window.location.href=links2[index]+".php";
                    }
                })
                student_box2.forEach((box,index)=>{
                    box.onclick=function(){                        
                        accessAlert();
                    }
                })

            }


        // for parents, they are only allowed to check "kids(students)" and themselves
        if(userRole==="parent"){
                let parents_box=[boxes[1],boxes[2]];
                let parents_box2=[boxes[0],boxes[3],boxes[4],boxes[5]]
                // change the text in html to fit the identity
                document.getElementById("myParents").innerText="Me";
                document.getElementById("kids").innerText="My Kid(s)";

                parents_box.forEach((box,index)=>{
                    box.classList.add("parents");
                    box.onclick=function(){                        
                        window.location.href=links3[index]+".php";
                    }
                })
                parents_box2.forEach((box,index)=>{
                    box.onclick=function(){                        
                        accessAlert();
                    }
                })

            }

            // teachers are allowed to check class, students, own, and salaries
            if(userRole==="teacher"){
                let teachers_box=[boxes[0],boxes[1],boxes[3],boxes[4]];
                let teachers_box2=[boxes[2],boxes[5]]

                document.getElementById("myClass").innerText="My Class";
                document.getElementById("myTeacher").innerText="Me";
                document.getElementById("mySalaries").innerText="My Salaries";
                document.getElementById("kids").innerText="My Students";

                teachers_box.forEach((box,index)=>{
                    box.classList.add("teachers");
                    box.onclick=function(){                        
                        window.location.href=links4[index]+".php";
                    }
                })
                teachers_box2.forEach((box,index)=>{
                    box.onclick=function(){                        
                        accessAlert();
                    }
                })

            }
        }
    </script>
</body>
</html>