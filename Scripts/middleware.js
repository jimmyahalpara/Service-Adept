/** Login form validation */
function doValidate() {
  console.log("Validating...");
  try {
    addr = document.getElementById("email").value;
    pw = document.getElementById("password").value;
    console.log("Validating addr=" + addr + " pw=" + pw);
    if (addr == null || addr == "" || pw == null || pw == "") {
      alert("Both fields must be filled out");
      return false;
    }
    if (addr.indexOf("@") == -1) {
      alert("Invalid email address");
      return false;
    }
    return true;
  } catch (e) {
    return false;
  }
}
