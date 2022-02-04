window.onload = function(e) {

    const togglePasswordBtn = document.querySelector("#toggle-password-visibility");
    const email             = document.querySelector("#email");
    const password          = document.querySelector("#password");

    // Sign In password visibility button
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

    email.addEventListener("input", function(event){
        // Remove error content
        if(this.value !== "") {
            if(this.classList.contains("is-invalid")) {
                this.classList.remove("is-invalid");
            }
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
        } else {
            // Hide password reveal button
            if(!togglePasswordBtn.classList.contains("hidden")) {
                togglePasswordBtn.classList.add("hidden");
            }
        }

    });

}

