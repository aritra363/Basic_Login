function change() {
    let changeValue = document.querySelector("#binValue");
    let heading = document.querySelector("#heading");
    let toggleBtn = document.querySelector("#toggleBtn");
    let submitBtn = document.querySelector("#submitBtn");
    let form = document.querySelector("#form");
    //console.log(changeValue.value);
    if (changeValue.value == 1) {
        let addElement = `<div class="input-group mb-3" id="switch">
                                    <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Confirm Password</span>
                            </div>
                            <input type="password" class="form-control" onkeyup="check_password(this.value)" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                        </div>
                        <div class="alert alert-danger cnfPassword" role="alert">
                                Confirm Password does not matches!
                            </div>`;
        toggleBtn.value = "Already Registered,Please Login!";
        submitBtn.innerHTML = "Signup";
        heading.innerHTML = "Register";
        changeValue.value = 0;
        form.innerHTML += addElement;
    } else {
        let cnfPassword = document.querySelector("#switch");
        toggleBtn.value = "Not Registered yet,Please Register!";
        submitBtn.innerHTML = "Signin";
        heading.innerHTML = "Login";
        cnfPassword.remove();
        changeValue.value = 1;
    }
    
}
function check_password(val) {
    let alert = document.querySelector('.cnfPassword');
    let pass = document.querySelector('#pass').value;
    let cnf_pass = val;
    if (pass !== cnf_pass) {
        alert.style.display = 'block';
    } else {
        alert.style.display = 'none';
    }
}
function check_name(name) {
    let changeValue = document.querySelector("#binValue");
    console.log(changeValue.value);
    if (changeValue.value == 0) {
        let alert = document.querySelector('.username');
        let url = 'backend/getName.php?name='+name;
        fetch (url).then (res => res.json())
        .then (data => {
        if (data.length) {
            alert.style.display = 'block';
        } else {
            alert.style.display = 'none';
        }
        })
        .catch (error => {
            console.log(error);
        })
    }
}

let form = document.querySelector('#main-form');
form.addEventListener('submit',(event) => {
let changeValue = document.querySelector("#binValue");
let pass_field = document.querySelector('#pass').value;
let uname_field = document.querySelector('#uname').value;
    if (changeValue.value == 0) {
        //Register 
        
        let cnfPassword_alert = document.querySelector('.cnfPassword');
        let username_alert = document.querySelector('.username');
        let count = 0;
        if (uname_field.trim() !== '' && pass_field.trim() !== '') {
            count ++;
        }
        if (cnfPassword_alert.style.display === 'none' && username_alert.style.display === 'none') {
            count ++;
        }
        if (count === 2) {
            return true;
            //console.log("true");
        } else {
            //return false;
            event.preventDefault();
            //console.log("false");
        }
    }
    if (changeValue.value == 1) {
        //Login 
        let username_alert = document.querySelector('.username');
        let count = 0;
        if (uname_field.trim() !== '' && pass_field.trim() !== '') {
            count ++;
        }
        // if (cnfPassword_alert.style.display === 'none' && username_alert.style.display === 'none') {
        //     count ++;
        // }
        if (count === 1) {
            return true;
            //console.log("true");
        } else {
            //return false;
            event.preventDefault();
            //console.log("false");
        }
    }
});