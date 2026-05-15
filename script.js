function validateRegister() {
    var fullName = document.getElementById("full_name").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var message = document.getElementById("errorMessage");

    if (fullName == "" || email == "" || password == "") {
        message.innerHTML = "Please fill all fields.";
        message.style.color = "red";
        return false;
    }

    if (email.indexOf("@") == -1) {
        message.innerHTML = "Please enter a valid email.";
        message.style.color = "red";
        return false;
    }

    if (password.length < 5) {
        message.innerHTML = "Password must be at least 5 characters.";
        message.style.color = "red";
        return false;
    }

    return true;
}

function validateLogin() {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var message = document.getElementById("errorMessage");

    if (email == "" || password == "") {
        message.innerHTML = "Please fill all fields.";
        message.style.color = "red";
        return false;
    }

    if (email.indexOf("@") == -1) {
        message.innerHTML = "Please enter a valid email.";
        message.style.color = "red";
        return false;
    }

    return true;
}

function validateTask() {
    var title = document.getElementById("title").value;
    var taskDate = document.getElementById("task_date").value;
    var status = document.getElementById("status").value;
    var message = document.getElementById("errorMessage");

    if (title == "" || taskDate == "" || status == "") {
        message.innerHTML = "Please fill all fields.";
        message.style.color = "red";
        return false;
    }

    return true;
}

function confirmDelete() {
    return confirm("Are you sure you want to delete this task?");
}