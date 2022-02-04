window.onload = function(e) {
    const toggleConfirmPasswordBtn = document.querySelector("#toggle-sign-up-confirm-password-visibility");
    const togglePasswordBtn = document.querySelector("#toggle-sign-up-password-visibility");

    const firstName         = document.querySelector("#first_name");
    const lastName          = document.querySelector("#last_name");
    const username          = document.querySelector("#username");
    const email             = document.querySelector("#email");
    const password          = document.querySelector("#password");
    const confirmPassword   = document.querySelector("#confirm-password");
    const country           = document.querySelector("#country");
    const city              = document.querySelector("#city");
    const addressLine       = document.querySelector("#address_line");
    const zipcode           = document.querySelector("#zipcode");
    
    const uploadFile        = document.querySelector("#file-upload");
    const personalAddress   = document.querySelector("#personal-address");

    function showAddressOnError() {
        if(country.selectedIndex != 0 || city.value !== "" || addressLine.value !== "" || zipcode.value !== "") {
            personalAddress.classList.remove("hidden");
        }
    }

    function showPersonalAddress() {
        if(firstName.value !== "" && lastName.value !== "" && email.value !== "" && username.value !== "" && password.value !== "" && confirmPassword.value !== "")
        // Show personal address bar
        if(personalAddress.classList.contains("hidden")) {
            personalAddress.classList.remove("hidden");
        }
    }

    function hidePersonalAddress() {
        if(!personalAddress.classList.contains("hidden")) {
            personalAddress.classList.add("hidden");
        }
    }

    function createImg(data) {
        const img = document.createElement("img");
              img.setAttribute("src", data);
              img.setAttribute("id", "upload-image");
              img.className = "upload-image";

        return img;
    }

    showAddressOnError();

    // Sign Up password visibility button
    togglePasswordBtn.addEventListener("click", function(event){
        const password = document.querySelector("#password");

        let passwordText = password.value;

        if(passwordText !== "") {

            if(this.classList.contains("bxs-show")) {
                // Show password text
                this.classList.remove("bxs-show");
                this.classList.add("bxs-hide");

                password.setAttribute("type", "text");
            } else {
                // Hide password text
                this.classList.remove("bxs-hide");
                this.classList.add("bxs-show");

                password.setAttribute("type", "password");
            }
        }
    });

    // Sign Up confirm password visibility button
    toggleConfirmPasswordBtn.addEventListener("click", function(event){
        const password = document.querySelector("#confirm-password");

        let passwordText = password.value;

        if(passwordText !== "") {

            if(this.classList.contains("bxs-show")) {
                // Show password text
                this.classList.remove("bxs-show");
                this.classList.add("bxs-hide");

                password.setAttribute("type", "text");
            } else {
                // Hide password text
                this.classList.remove("bxs-hide");
                this.classList.add("bxs-show");

                password.setAttribute("type", "password");
            }
        }
    });

    firstName.addEventListener("input", function(event){
        // Remove error content
        if(this.value !== "") {
            if(this.classList.contains("is-invalid")) {
                this.classList.remove("is-invalid");
            }

            showPersonalAddress();
        } else {
            hidePersonalAddress();
        }
    });

    lastName.addEventListener("input", function(event){
        // Remove error content
        if(this.value !== "") {
            if(this.classList.contains("is-invalid")) {
                this.classList.remove("is-invalid");
            }

            showPersonalAddress();
        } else {
            hidePersonalAddress();
        }
    });

    username.addEventListener("input", function(event){
        // Remove error content
        if(this.value !== "") {
            if(this.classList.contains("is-invalid")) {
                this.classList.remove("is-invalid");
            }

            showPersonalAddress();
        } else {
            hidePersonalAddress();
        }
    });

    email.addEventListener("input", function(event){
        // Remove error content
        if(this.value !== "") {
            if(this.classList.contains("is-invalid")) {
                this.classList.remove("is-invalid");
            }

            showPersonalAddress();
        } else {
            hidePersonalAddress();
        }
    });

    password.addEventListener("input", function(event){
        if(this.value !== "") {
            // Show password reveal button
            if(togglePasswordBtn.classList.contains("hidden")) {
                togglePasswordBtn.classList.remove("hidden");
            }
            // Remove error content
            if(this.classList.contains("is-invalid")) {
                this.classList.remove("is-invalid");
            }

            showPersonalAddress();
        } else {
            // Hide password reveal button
            if(!togglePasswordBtn.classList.contains("hidden")) {
                togglePasswordBtn.classList.add("hidden");
            }
            hidePersonalAddress();
        }
    });

    confirmPassword.addEventListener("input", function(event){
        if(this.value !== "") {
            // Show password reveal button
            if(toggleConfirmPasswordBtn.classList.contains("hidden")) {
                toggleConfirmPasswordBtn.classList.remove("hidden");
            }
            // Remove error content
            if(this.classList.contains("is-invalid")) {
                this.classList.remove("is-invalid");
            }

            showPersonalAddress();
        } else {
            // Hide password reveal button
            if(!toggleConfirmPasswordBtn.classList.contains("hidden")) {
                toggleConfirmPasswordBtn.classList.add("hidden");
            }
            hidePersonalAddress();
        }
    });

    city.addEventListener("input", function(event){
        // Remove error content
        if(this.value !== "") {
            if(this.classList.contains("is-invalid")) {
                this.classList.remove("is-invalid");
            }
        }
    });

    addressLine.addEventListener("input", function(event){
        // Remove error content
        if(this.value !== "") {
            if(this.classList.contains("is-invalid")) {
                this.classList.remove("is-invalid");
            }
        }
    });

    zipcode.addEventListener("input", function(event){
        // Remove error content
        if(this.value !== "") {
            if(this.classList.contains("is-invalid")) {
                this.classList.remove("is-invalid");
            }
        }
    });

}