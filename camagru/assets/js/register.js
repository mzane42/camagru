document.addEventListener("DOMContentLoaded", function ()  {
	var password = document.getElementById("password");
	var confirm_password = document.getElementById("confirm_password");

	console.log(password, confirm_password);
	confirm_password.addEventListener("keyup", validatePassword);

	function validatePassword(){
	  if(password.value != confirm_password.value) {
	    confirm_password.setCustomValidity("Passwords Don't Match");
	  } else {
	    confirm_password.setCustomValidity('');
	  }
	}
});