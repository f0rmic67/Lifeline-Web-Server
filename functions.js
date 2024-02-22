//functions to validate user input before sending to server
    function validateSearch(){
        
    }

    //validate user input before submitting login information
    function validateLogin(){
        var loginInfo = document.getElementById("loginPage");
            //this will need to be verified by the db
        if(loginInfo.logEmail.value == ""){
            alert("Email must be entered.");
            return false;
        }
        else if(loginInfo.logPass.value == ""){
            alert("Password must be entered.");
            return false;
        }

        return true;
    }

    //display proper form for chosen account type
    function accountType(){
        var accType = document.getElementById("accType");

        if(accType.value == "student"){
            document.getElementById("studentForm").style = "display:block";
            document.getElementById("emsForm").style = "display:none";
        }
        else{
            document.getElementById("studentForm").style = "display:none";
            document.getElementById("emsForm").style = "display:block";
        }
    }
    

    //validate user input before submitting form
    function validateStudent(){
        var studentForm = document.getElementById("studentForm");
        var re = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{10,30}$/;

        if(studentForm.sUser.value == "" ){
            alert("Username must be entered.");
            return false;
        }
       else if (studentForm.sUser.value.length < 8){
        alert("Username must be at least 8 chars long ")
        return false
       }
        else if(studentForm.sEmail.value == ""){
            alert("Email must be entered.");
            return false;
        }
        else if (!(studentForm.sEmail.value.includes("@pennwest.edu")) && !(studentForm.sEmail.value.length == 20))
        {
            alert('Must have a vaild pennwest email');
            return false;
        }
        else if(studentForm.sID.value == ""){
            alert("Student ID must be entered.");
            return false;
        }
        else if(!(studentForm.sID.value.length == 16)){
            alert("Student ID must be atlest 16 digits.");
            return false;
        }
        else if(studentForm.sPass1.value == "" || studentForm.sPass2.value == ""){
            alert("Password must be entered.");
            return false;
        }
        else if (re.test(studentForm.sPass1.value == false ))
        {
            alert("Passwords must have a upper and lower case letter along with a number and special char and be atleast 10 chars long ");
            return false;
        }
        else if(studentForm.sPass1.value != studentForm.sPass2.value){
            alert("Passwords entered do not match.");
            return false;
        }

        return true;
    }

    //validate user input before submitting form
    function validateEMS(){

    }

