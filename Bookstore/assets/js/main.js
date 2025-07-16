// Example form validation for register
function validateRegisterForm() {
  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;
  const errorDiv = document.getElementById('register-error');

  const emailRegex = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

  if (email === "" || password === "") {
    errorDiv.innerHTML = "All fields are required.";
    return false;
  }

  if (!email.match(emailRegex)) {
    errorDiv.innerHTML = "Enter a valid email address.";
    return false;
  }

  if (password.length < 6) {
    errorDiv.innerHTML = "Password must be at least 6 characters.";
    return false;
  }

  errorDiv.innerHTML = "";
  return true;
}
