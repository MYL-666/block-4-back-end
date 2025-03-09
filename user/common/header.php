
<header>

    <div class="container">
        <div class="left">
            <span>St Alphonsus Primary School</span>
            <nav class="breadcrumb">
                <span id="breadcrumb">Extra</span>
                <ul id="breadcrumb-itmes">
                    <li><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a  href="classes.php">Classes</a></li>
                    <li class="breadcrumb-item"><a  href="students.php">Students</a></li>
                    <li class="breadcrumb-item"><a  href="parents.php">Parents</a></li>
                    <li class="breadcrumb-item"><a  href="teachers.php">Teachers</a></li>
                    <li class="breadcrumb-item"><a  href="salaries.php">Salaries</a></li>
                    <li class="breadcrumb-item"><a  href="library.php">Library</a></li>
                </ul>
            </nav>
        </div>
        <div class="right">
            <ul>
                <li><span id="userInfroRole">You are not login</span>
                    <a href="user.php" id="userInfroName"></a>
                </li>
                <li><a href="javascript:;" id="logout">Quit</a></li>
            </ul>
        </div>
    </div>
</header>
<!-- import get user fetch and some variables that would be used-->
<script>
    getUser();
    const breadcrumb=document.getElementById("breadcrumb");
    const breadcrumbItem=document.getElementById("breadcrumb-itmes");
    let breadItem=document.querySelectorAll(".breadcrumb-item");
    let a=document.querySelectorAll("a");
    breadcrumb.addEventListener("click",function(){
        breadcrumb.classList.toggle("toggle");
        breadcrumbItem.classList.toggle("active");

// make sure different user have different navigation relate to their role
    if(userRole==="admin"){
        breadItem.forEach((item,index) => {
            if (item.innerText.toLowerCase()===links1[index]){
                item.classList.add("active")
            }
        });
    }
    // student role nav
    if(userRole==="student"){
        breadItem.forEach((item,index) => {
            if (item.innerText.toLowerCase()===links2[index]){
                item.classList.add("active")
            }
        });
    }
    // parent role nav
    breadItem.forEach(item => {
    if (links3.includes(item.innerText.trim().toLowerCase())) {
        item.classList.add("active");
    }
    });

    // teacher role nav
    if(userRole==="teacher"){
        breadItem.forEach((item,index) => {
            if (item.innerText.toLowerCase()===links4[index]){
                item.classList.add("active")
            }
        });
    }
    })
    
    // when click "quit" destory the session and back to login page
    document.getElementById("logout").addEventListener("click",function(){
        window.location.href = "../api/logout.php";
    })


</script>