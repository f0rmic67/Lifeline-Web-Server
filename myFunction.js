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

var x = document.getElementById("login");
var y = document.getElementById("register");
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
