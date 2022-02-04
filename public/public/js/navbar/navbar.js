// ============================================================ //
// MAIN SHOW USER POSTS HELPERS
// ============================================================ //
function showMyPosts(data) {
    if(data.response === 'unauthorized') return false;

    const myPostsContainer = document.querySelector(".my-posts-container");

    appendDefaultBehaviour(myPostsContainer);
    appendTopContent(myPostsContainer, data.total);

    if(data.posts.length > 0) {
        data.posts.forEach((post) => {
            appendPost(myPostsContainer, post);
        });
    } else {
        let noPosts = createNoPostsContent("You currently have no posts", "alert alert-warning mb-3 p-3 text-center text-secondary");

        myPostsContainer.className += " text-center";
        myPostsContainer.appendChild(noPosts);
        myPostsContainer.appendChild(createPost);
    }

    appendCreatePostLink(myPostsContainer);
}

function confirmRemovePostForm(e) {
    e.preventDefault();

    if(confirm("Do you want to remove this post?")) {
        e.target.submit();
    }
}

// ============================================================ //
// SUBMIT DELETE POST FORM HELPER
// ============================================================ //

// ============================================================ //
// APPEND DOM ELEMENTS HELPERS
// ============================================================ //
function appendPost(container, post) {
    let postLink = createLink(post.post_url);
    let postDiv  = createPostDiv();

    if(post.is_approved != 1) {
        let warning = createPostWarning("This post is not approved yet", "myPostsWarning");
        postDiv.appendChild(warning);
    }

    let title         = createPostTitle(post.title, "myPostsContainerTitle");
    let description   = createPostDescription(post.description, "myPostsContainerDescription");
    let bottomContent = createPostBottomContent("d-flex-between mt-3");
    let views         = createPostViews("Views: ", "myPostsViews");
    let viewsNumber   = createViewsNumber("<strong>"+post.views+"</strong>");
    let date          = createPostDate(post.created_at, "myPostsCreatedAt");
    let bottomHr      = createHr();
    let actionContent = createActionContent("d-flex-between mt-3");
    let editPost      = createEditPost(post.post_id, 'btn btn-outline-success btn-sm');
    let removePost    = createRemovePost(post.post_id);

    views.appendChild(viewsNumber);
    postDiv.appendChild(title);
    postDiv.appendChild(description);
    if(post.image_src != null) {
        let img = createPostImage(post.image_src);
        postDiv.appendChild(img);
    }
    bottomContent.appendChild(views);
    bottomContent.appendChild(date);

    actionContent.appendChild(editPost);
    actionContent.appendChild(removePost);

    postLink.appendChild(postDiv);

    postDiv.appendChild(bottomContent);
    postDiv.appendChild(bottomHr);

    if(post.is_approved != 1) {
        container.appendChild(postDiv);
    } else {
        postDiv.appendChild(actionContent);
        container.appendChild(postLink);
    }
}

function appendTopContent(container, total) {
    let closeBtn   = createCloseMyPostsBtn();
    let totalPosts = createTotalPosts(total);
    let topHr      = createHr();

    container.appendChild(closeBtn);
    container.appendChild(totalPosts);
    container.appendChild(topHr);
}

function appendCreatePostLink(container) {
    let createPostContainer = createPostsContainer();
    let createPostLink      = createPostsLink();
    
    createPostContainer.appendChild(createPostLink);
    container.appendChild(createPostContainer);
}

function appendDefaultBehaviour(container) {
    container.innerHTML     = "";
    container.style.display = "block";
}

// ============================================================ //
// FETCH API HELPERS
// ============================================================ //

function get_user_posts(id) {
    fetchMyPosts(`${APP_URL}posts/show/${id}`)
    .then(data => { 
        showMyPosts(data);
    });
}

async function fetchMyPosts(url) {
    const response = await fetch(url, {
        method: 'GET',
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        }
    });

    const posts = await response.json();

    return posts;
}

// ================================================================= //
// CREATE ELEMENTS HELPERS
// ================================================================= //

function createHr() {
    let hr = document.createElement("hr");

    return hr;
}

function createTotalPosts(total) {
    let span = document.createElement("span");
        span.innerHTML = `Your Posts: <strong>${total}</strong>`;
        span.className = "myPostsTotal mt-2";

    return span;
}

function createCloseMyPostsBtn() {
    let btn = document.createElement("span");
        btn.innerHTML   = "&times;";
        btn.className   = "closeMyPostsBtn mt-2";
        btn.onclick = function(e) {
            document.querySelector(".my-posts-container").style.display = "none";
        }

    return btn;
}

function createPostsContainer() {
    let container = document.createElement("div");
        container.className = "text-center";

    return container;
}

function createLink(url) {
    let link = document.createElement("a");
        link.href = url;

    return link
}

function createPostsLink() {
    let link = document.createElement("a");
        link.href        = `${APP_URL}post/create`;
        link.className   = "btn btn-outline-primary mt-3";
        link.textContent = "Create Post";

    return link
}

function createPostDiv() {
    let div           = document.createElement("div");
        div.className = "myPostsContainerContent mb-3 p-3";

    return div;
}

function createPostWarning(text, className) {
    let warning             = document.createElement("span");
        warning.className   = className;
        warning.textContent = text;

    return warning;
}

function createPostTitle(text, className) {
    let title             = document.createElement("h3");
        title.className   = className;
        title.textContent = text;

    return title;
}

function createPostDescription(text, className) {
    let description = document.createElement("div");
        description.className = className;
        description.innerHTML = text;

    return description;
}

function createPostBottomContent(className) {
    let bottomContent = document.createElement("div");
        bottomContent.className = className;

    return bottomContent;
}

function createPostViews(text, className) {
    let views = document.createElement("div");
        views.textContent = text;
        views.className   = className;

    return views;
}

function createViewsNumber(text) {
    let number = document.createElement("span");
        number.innerHTML = text;
        number.style.color = "#2F4F4F";

    return number;
}

function createPostDate(date, className) {
    let createdAt             = document.createElement("div");
        createdAt.className   = className;
        createdAt.textContent = date;

    return createdAt;
}

function createPostImage(src) {
    let img = document.createElement("img");
        img.style.width = "100%";
        img.height = "200";
        img.src = src;

    return img;
}

function createNoPostsContent(text, className) {
    let noPosts = document.createElement("div");
        noPosts.textContent = text;
        noPosts.className   = className;
        
    return noPosts;
}

function createActionContent(className) {
    let content = document.createElement("div");
        content.className = className;

    return content;
}

function createEditPost(id, className) {
    let edit             = document.createElement("a");
        edit.href        = `${APP_URL}post/edit/${id}`;
        edit.className   = className;
        edit.textContent = 'Edit';

    return edit;
}

function createRemovePost(id) {
    let form = document.createElement("form");
          form.action = `${APP_URL}/post/delete/${id}`;
          form.method = "post";
          form.addEventListener("submit", confirmRemovePostForm);

    let hidden = document.createElement("input");
          hidden.type  = "hidden";
          hidden.name  = "post_id";
          hidden.value = id;

    let button = document.createElement("button");
          button.type        = "submit";
          button.className   = "btn btn-outline-danger btn-sm";
          button.textContent = "Remove";

    form.appendChild(hidden);
    form.appendChild(button);

    return form;
}