const APP_SRC             = "http://blogdevcommunity.test/";
const postsContent        = document.querySelector("#posts-content");
const pagination          = document.querySelector(".pagination");
const homePaginationLinks = document.querySelectorAll(".pagination-link");
let selectedPage;

// =================================================== //
// Home pagination links 
// =================================================== //

homePaginationLinks.forEach(link => {
	link.addEventListener("click", (e) => {
		e.preventDefault();

		let pageNum = getPageNumber(e);
		let url     = `${APP_SRC}posts/page/${pageNum}`;

		fetchPosts(url)
		.then(data => {
			showPosts(data);
			updatePagination(data);
		});
	});
});

function showPosts(data) {
	postsContent.innerHTML = "";

	if(data.posts.length > 0) {
		data.posts.forEach((post) => { displayLinkPost(post) });
	} else {
		displayLinkNoPosts();
	}
	updatePagination(data);
}

function displayLinkPost(post) {
	if(post.image_src == null) {

	postsContent.innerHTML += `
	<div class="post card mt-5 p-3">
		<div class="card-body">
			<div class="d-flex-between-center">
				<h3 class="post-title card-title mb-3">${post.title}</h3>
				<h5 class="text-muted">${post.category_name}</h5>
			</div>
			<div class="card-text text-muted">${post.description}</div>
			<div class="mt-3 d-flex-between">
				<span>
					<small>
						<a href="${APP_SRC}member/show/${post.username}">${post.user}</a>
					</small>
				</span>
				<span>
					<small class="post-created-at">${post.created_at}</small>
				</span>
			</div>
			<hr>
            <div>
                <a class="btn btn-outline-primary" href="${APP_SRC}post/show/${post.post_id}">Read More</a>
            </div>
		</div>
	</div>`;

	} else {

		postsContent.innerHTML += `
		<div class="post card mt-5 p-3">
			<div class="card-body">
				<div class="d-flex-between-center">
					<h3 class="post-title card-title mb-3">${post.title}</h3>
					<h5 class="text-muted">${post.category_name}</h5>
				</div>
				<div class="card-text text-muted">${post.description}</div>
				<div class="mx-auto text-center">
                    <img style="width: 80%" height="600" src="${post.image_src}">
                </div>
				<div class="mt-3 d-flex-between">
					<span>
						<small>
							<a href="${APP_SRC}member/show/${post.username}">${post.user}</a>
						</small>
					</span>
					<span>
						<small class="post-created-at">${post.created_at}</small>
					</span>
				</div>
				<hr>
	            <div>
	                <a class="btn btn-outline-primary" href="${APP_SRC}posts/show/${post.post_id}">Read More</a>
	            </div>
			</div>
		</div>`;

	} 
}

function displayLinkNoPosts() {
	postsContent.innerHTML = `
	<div class="card mt-5 p-3">
		<div class="card-body">
			<h5 class="card-title text-center">There is no post posted by that category</h5>
			<p class="card-text text-muted text-center">Create your own post</p>
			<hr>
			<div class="text-center">
				<a href="${APP_SRC}post/create" class="btn btn-primary">Crete Post <i class="bx bx-plus"></i></a>
			</div>
		</div>
	</div>`;
}

function updatePagination(data) {
	let totalPages = calculatePostPages(data);

	if(totalPages > 1) {

		if(totalPages > data.current_page) {
			removeOldNextLink();
			addNewNextLink(data);
		} else {
			removeOldNextLink();
		}

		if(data.current_page > 1) {
			removeOldPrevLink();
			addNewPrevLink(data);
		} else {
			removeOldPrevLink();
		}
		markPage(data);
	}
}

function removeOldNextLink() {
	if(pagination.querySelector(".next") != null) pagination.removeChild(pagination.querySelector(".next"));
}

function addNewNextLink(data) {
	let nextPageNum  = data.current_page + 1;
	let a            = document.createElement("a");

	a.className = "next-link next";
	a.href      = `${APP_SRC}posts/page/${nextPageNum}`;
	a.addEventListener("click", (e) => {
		e.preventDefault(); 
		linkActionEvent(a);
	});
	appendLinkToPagination(a, "bx bx-chevrons-right");
}

function removeOldPrevLink() {
	if(pagination.querySelector(".prev") != null) pagination.removeChild(pagination.querySelector(".prev"));
}

function addNewPrevLink(data) {
	let prevPageNum  = data.current_page - 1;
	let a            = document.createElement("a");

	a.className = "prev-link prev";
	a.href      = `${APP_SRC}posts/page/${prevPageNum}`;
	a.addEventListener("click", (e) => {
		e.preventDefault();
		linkActionEvent(a);
	});

	prependLinkToPagination(a, "bx bx-chevrons-left");
}

function prependLinkToPagination(link, className) {
	const pagination = document.querySelector(".pagination");
	let icon         = document.createElement("i");

	icon.className = className;

	link.appendChild(icon);
	pagination.insertBefore(link, pagination.firstElementChild);
}

function appendLinkToPagination(link, className) {
	let icon = document.createElement("i");

	icon.className = className;

	link.appendChild(icon);
	pagination.appendChild(link);
}

function calculatePostPages(data) {
	let pages = parseInt(data.total) / parseInt(data.limit);

	pages = (parseInt(data.total) % parseInt(data.limit) != 0) ? pages + 1 : pages;
	pages = Math.floor(pages);

	return pages;
}

function markPage(data) {
	if(data.posts.length > 0) {
		if(selectedPage == undefined) {
			selectedPage = data.current_page - 1;
			homePaginationLinks[selectedPage].classList.add('pagination-link-selected');
		} else {
			homePaginationLinks[selectedPage].classList.remove('pagination-link-selected');

			selectedPage = data.current_page - 1;
			homePaginationLinks[selectedPage].classList.add('pagination-link-selected');
		}
	}
}

function getPageNumber(event) {
	let link     = event.target;
	let url      = link.href;
	let urlArray = url.split('/');
	let pageNum  = urlArray[urlArray.length - 1];

	pageNum = parseInt(pageNum);

	return pageNum;
}

function linkActionEvent(link) {
	let url  = link.href;

	fetchPosts(url)
	.then(data => {
		showPosts(data);
		updatePagination(data);
	});
}

// =================================================== //
// Fetch functions
// =================================================== //

async function fetchPosts(url) {
	const response = await fetch(url, {
		method: 'GET',
		headers: {
			"X-Requested-With": "XMLHttpRequest"
		},
		referrer: `${APP_SRC}posts`,
		referrerPolicy: 'same-origin'
	});

	const posts = await response.json();

	return posts;
}

// =================================================== //
// Back to top event 
// =================================================== //

document.querySelector("#back-to-top").addEventListener("click", (e) => {
	e.preventDefault();
	window.scrollTo({top: 0, behavior: "smooth"});
});