//functions to validate user input before sending to server
function validateSearch(){

}

//validate user input before submitting login information
function validateLogin(){

}

//display proper form for chosen account type
function accountType(){

}

//validate user input before submitting form
function validateStudent(){

}

//validate user input before submitting form
function validateEMS(){

}

var navLinks = document.getElementById("navLinks");
//JavaScript for Toggle Menu
function showMenu() {
	navLinks.style.right = "0";
}
function hideMenu() {
	navLinks.style.right = "-200px";
}
//JavaScript for Register/Login
var card = document.getElementById("card");
function openRegister(){
	card.style.transform = "rotateY(-180deg)";
}
function openLogin(){
	card.style.transform = "rotateY(0deg)";
}

var x = document.getElementById("loginPage");
var y = document.getElementById("registerPage");
var z = document.getElementById("btn");

function register(){
	x.style.left = "-400px";
	y.style.left = "50px";
	z.style.left = "110px";
}
function login(){
	x.style.left = "50px";
	y.style.left = "450px";
	z.style.left = "0px";
}

type="text/javascript"
$(function heartProblems() {
	$("#heartProblems").change(function () {
		if ($(this).val() == 2) {
			$("#heartProblem").removeAttr("disabled");
			$("#heartProblem").focus();
		} else {
			$("#heartProblem").attr("disabled", "disabled");
		}
	});
});

$(function pacemakers() {
	$("#pacemakers").change(function () {
		if ($(this).val() == 2) {
			$("#pacemaker").removeAttr("disabled");
			$("#pacemaker").focus();
		} else {
			$("#pacemaker").attr("disabled", "disabled");
		}
	});
});

$(function diabetes() {
	$("#diabetes").change(function () {
		if ($(this).val() == 2) {
			$("#diabete").removeAttr("disabled");
			$("#diabete").focus();
		} else {
			$("#diabete").attr("disabled", "disabled");
		}
	});
});

$(function highBloodPressure() {
	$("#highBloodPressure").change(function () {
		if ($(this).val() == 2) {
			$("#highBP").removeAttr("disabled");
			$("#highBP").focus();
		} else {
			$("#highBP").attr("disabled", "disabled");
		}
	});
});

$(function Strokes() {
	$("#Strokes").change(function () {
		if ($(this).val() == 2) {
			$("#stroke").removeAttr("disabled");
			$("#stroke").focus();
		} else {
			$("#stroke").attr("disabled", "disabled");
		}
	});
});

$(function asthma() {
	$("#Asthma").change(function () {
		if ($(this).val() == 2) {
			$("#asthma").removeAttr("disabled");
			$("#asthma").focus();
		} else {
			$("#asthma").attr("disabled", "disabled");
		}
	});
});

$(function Seizures() {
	$("#Seizures").change(function () {
		if ($(this).val() == 2) {
			$("#seizure").removeAttr("disabled");
			$("#seizure").focus();
		} else {
			$("#seizure").attr("disabled", "disabled");
		}
	});
});

$(function Cancer() {
	$("#Cancer").change(function () {
		if ($(this).val() == 2) {
			$("#cancer").removeAttr("disabled");
			$("#cancer").focus();
		} else {
			$("#cancer").attr("disabled", "disabled");
		}
	});
});

$(function Allergies() {
	$("#Allergies").change(function () {
		if ($(this).val() == 2) {
			$("#allergy").removeAttr("disabled");
			$("#allergy").focus();
		} else {
			$("#allergy").attr("disabled", "disabled");
		}
	});
});

$(function Other() {
	$("#Other").change(function () {
		if ($(this).val() == 2) {
			$("#other").removeAttr("disabled");
			$("#other").focus();
		} else {
			$("#other").attr("disabled", "disabled");
		}
	});
});