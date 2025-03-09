<?php 
 $title= "Login Page";
 $page_name="login";
 require "../config/db.php";
?>

<!DOCTYPE html>
<html lang="en">
    <!-- import head section -->
<?php 
    require "./common/head.php"
?>
<body>
    <!-- import header part -->
    <?php
        require "./common/header.php";
    ?>
    <main class="main">
        <div class="create" id="sign-page">
            <div class="left">
                <h1>Welcome Back!</h1>
                <span>If you already had an account </span>
                <span>please login there ↓</span>
                <button id="btn01">SIGN IN</button>
            </div>
            <div class="right">
                <p>Creat Account</p>
                <form action="" id="regist" method="$_POST">
                    <div class="input">
                        <input type="text" name="username" id="username_r" placeholder="User Name:" required>
                    </div>
                    <div class="input">
                        <input type="email" name="email" placeholder="Email:" id="email_r" required>
                    </div>
                    <div class="input">
                        <input type="password" name="password" placeholder="Password:" required>
                    </div>
                    <div class="input">
                        <input type="password" name="re_password" placeholder="Confirm:" required>
                    </div>
                    <div class="radio">
                        <div class="radio-item">
                            <label for="student_r">Student</label>
                            <input class="radios" type="radio" name="role" value="student" id="student_r">
                        </div>
                        <div class="radio-item">
                            <label for="teacher_r">Teacher</label>
                            <input class="radios" type="radio" name="role" value="teacher" id="teacher_r">
                        </div>
                        <div class="radio-item">
                            <label for="parents_r">Parents</label>
                            <input class="radios" type="radio" name="role" value="parent" id="parents_r">
                        </div>                       
                    </div>
                    <button type="submit" name="submit" id="btn02">SIGN UP</button>
                    <input type="hidden" name="action" value="registration">
                </form>
            </div>
        </div>

        <div class="login" id="login-page">            
            <div class="right">
                <p>Login to School</p>
                <form action="./index.php" id="login" method="$_POST">
                    <div class="input">
                        <input type="email" name="login_email" placeholder="Email:" id="login_email" required>
                    </div>
                    <div class="input">
                        <input type="password" name="login_password" id="login_password" placeholder="Password:" required>
                    </div>
                    <div class="forgot">
                        <a href="javascript:;">Forgot your password?</a>
                    </div>
                    <button type="submit" id="btn03">LOGIN</button>
                    <input type="hidden" name="action" value="login">
                </form>
            </div>
            <div class="left" id="sl">
                <h1>Hello, Mate!</h1>
                <span>To keep connection with us,</span>
                <span>please regist here ↓</span>
                <button id="btn04">SIGN UP</button>
            </div>
        </div>
    </main>
    <!-- import footer part -->
    <?php   
        require "./common/footer.php"
    ?>
    <script>
            const regist=document.getElementById("sign-page");
            const login=document.getElementById("login-page");
            const btn01=document.getElementById("btn01");
            const btn04=document.getElementById("btn04");

            // bind a function for change between register and login page
            function show(btn,a,b){
                btn.onclick=function(){
                    a.style.animation="changeToSignUp1 .5s ease-in-out forwards";
                    b.style.animation="changeToSignUp2 .5s ease-in-out forwards";
                    // as the page disappear fully, this would not display
                    setTimeout(() => {
                        a.style.display="none";
                        b.style.display="flex";
                }, 500);
                }
            }
            // call the function
            show(btn04,login,regist);
            show(btn01,regist,login);

// ===================================registration validation start ============================
            document.getElementById("btn02").addEventListener("click",function(e){
                e.preventDefault(); //avoid accident submit
                let form=document.getElementById("regist");
                let formDatas=new FormData(form);
                let indentities=document.querySelectorAll(".radios");
                let checkNum=0;
                let formStatus=true;

                //fetch request
                async function getRegist(){
                    let res = await fetch('../api/registerV.php',{
                        method:"POST",
                        body:formDatas
                    })
                    let data=await res.json();
                    console.log(data)
                    
                    if(data.code !==0){
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: data.msg,
                        });
                    }
                }


                //region front-end validation start
                let register_username=document.getElementById("username_r").value;
                let register_email=document.getElementById("email_r").value;
                if(register_username.trim()=="" || register_email.trim()==""){
                    Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Username or Email is Empty!",
                        });
                    return false;
                }


                indentities.forEach(identity => {
                    if(!identity.checked){
                        checkNum++
                    }
                });
                //if user doesn't choose identity, alert the notification
                if(checkNum===3){
                    Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Please choose your identity",
                        });
                        return false; //change the validation status
                }
                //front validation end


                getRegist(); //call the back end validation


                // if pass the back-end validation alert success
               
                Swal.fire({
                  title: "Sign Up Successed!",
                  icon: "success",
                  draggable: false,
                });

                // change to login page
                    regist.style.animation="changeToSignUp1 .5s ease-in-out forwards";
                    login.style.animation="changeToSignUp2 .5s ease-in-out forwards";
                    setTimeout(() => {
                    regist.style.display="none";
                    login.style.display="flex";
                }, 500);
                
            })
// =================================registration validation end =============================


//  ================================login validation start ========================================

    document.getElementById("btn03").addEventListener("click",function(e){
        e.preventDefault();
        let form_login=document.getElementById("login");
        let login_email=document.getElementById("login_email");
        let login_pdw=document.getElementById("login_password");
        let formDatas=new FormData(form_login);
        let login_status=true;


        // front-end validation
        
        if(login_email.value.trim()=="" || login_pdw.value.trim()==""){
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Email Or Password can't be Empty!",
            });
            return false;
        }

        // fetch request
        async function Login(){
            let res= await fetch("../api/loginV.php",{
                method:"POST",
                body: formDatas
            })
            let data= await res.json();
            console.log(data)
            if(data.code!=0){
                Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: data.msg,
                        });
                        return;
            }
            if(login_status){
            Swal.fire({
                  title: "Login Successed!",
                  icon: "success",
                  draggable: false,
            });

             }
         
             setTimeout(()=>{
                 window.location.href="./index.php"
             },1000)
            }

        Login();
       

    })
//  ================================login validation end ===========================================
    </script>
</body>
</html>