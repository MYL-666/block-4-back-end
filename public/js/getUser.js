let userName = "";
let userRole = "";

let links1=["classes","students","parents","teachers","salaries","library"];
let links2=["classes","students","parents","teachers","library"];
let links3=["students","parents"];
let links4=["classes","students","parents","salaries"];

// fetch request for get session of user "role"
async function getUser(){
    let res =await fetch("../api/getUser.php")
    let data=await res.json();

    if(data.code==0){
    userName=data.username;
    userRole=data.role;
    document.getElementById("userInfroRole").innerText="Welcome "+userRole;
    document.getElementById("userInfroName").innerText= " "+userName;
    }

};