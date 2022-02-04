document.querySelector("#page-checkbox").addEventListener("change", function(e){

    // Display light background
    if(this.checked) {

        document.querySelector("#main-body").style.backgroundColor = "white";
        document.querySelector("#main-heading").style.color = "#2D262E";
        document.querySelector("#top-hr").style.color = "#A3A3A3";
        document.querySelector("#bottom-hr").style.color = "#A3A3A3";

        document.querySelectorAll(".post").forEach(function(post){
            post.style.backgroundColor = "#2D262E";
        });
        document.querySelectorAll(".post-title").forEach(function(postTitle){
            postTitle.style.color = "white";
        });
        document.querySelectorAll(".post-created-at").forEach(function(postCreatedAt){
            postCreatedAt.style.color = "white";
        });
        

    // Display dark background
    } else {

         document.querySelector("#main-body").removeAttribute("style");
         document.querySelector("#main-heading").removeAttribute("style");
         document.querySelector("#bottom-hr").removeAttribute("style");

         document.querySelectorAll(".post").forEach(function(post){
            post.removeAttribute("style");
        });
         document.querySelectorAll(".post-title").forEach(function(postTitle){
            postTitle.removeAttribute("style");
        });
         document.querySelectorAll(".post-created-at").forEach(function(postCreatedAt){
            postCreatedAt.removeAttribute("style");
        });

    }

});