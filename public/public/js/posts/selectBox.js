let h1 = document.querySelector("#main-heading");

let selectBoxArea     = document.querySelector(".select-box-area");
let selectBox         = document.querySelector(".select-category");
let index             = selectBox.selectedIndex;
let selectedOptionDIV = document.createElement("div");

// ================================================================= //
// Select box fetching posts
// ================================================================= //

document.addEventListener("click", closeOptionsDIV);

selectedOptionDIV.setAttribute("class", "selected-element");
selectedOptionDIV.textContent = selectBox.options[index].innerText;
selectedOptionDIV.addEventListener("click", selectedOptionDivActionEvent);

selectBoxArea.appendChild(selectedOptionDIV);

let optionsDIV = document.createElement("div");
optionsDIV.setAttribute("class", "options-div hide-options-div");

appendElementsToOptionsDiv(optionsDIV);

selectBoxArea.appendChild(optionsDIV);

function appendElementsToOptionsDiv(div) {
	for(let i = 0; i < selectBox.length; i++) {
		let option = document.createElement("div");

		option.textContent = selectBox.options[i].textContent;
		option.addEventListener("click", optionActionEvent);
		div.appendChild(option);
	}
}

function copySelectBoxValues(obj, option) {
	for(let j = 0; j < selectBox.length; j++) {
		if(option.textContent === selectBox.options[j].textContent) {
			selectBox.options[j].selected = true;

			let id = selectBox.options[j].value;
			
			obj.text = selectBox.options[j].innerText;
			obj.url  = `${APP_SRC}posts/search/${id}`;
			break;
		}
	}
}

function markSelectedOption(option) {
	for(let j = 0; j < selectBox.length; j++) {

		selectedOptionDIV.textContent = option.textContent;

		let oldSelectedOption = optionsDIV.querySelector(".option-selected");

		if(oldSelectedOption != null) oldSelectedOption.classList.remove("option-selected");

		option.setAttribute("class", "option-selected");
		break;
	}
}

function closeOptionsDIV() {
	optionsDIV.classList.add("hide-options-div");
	selectedOptionDIV.classList.remove("arrow-up");
}

// Fired Events
function selectedOptionDivActionEvent(e) {
	let selectedOptionDIV = e.target;

	e.stopPropagation();
	closeOptionsDIV();

	selectedOptionDIV.nextSibling.classList.toggle("hide-options-div");
	selectedOptionDIV.classList.toggle("arrow-up");
}

function optionActionEvent(e) {
	let option = e.target;
	let category = {};

	copySelectBoxValues(category, option);
	markSelectedOption(option);

	fetchCategoryPosts(category.url)
	.then(data => {
		showCategoryPosts(data);
		updateCategoryPagination(data);
		h1.innerText = `${category.text} Posts Content`;
	});
}

// =================================================================== //
// Category pagination links fetching posts
// =================================================================== //

function showCategoryPosts(data) {
	const content = document.querySelector("#posts-content");

	content.innerHTML = "";

	if(data.posts.length > 0) {
		data.posts.forEach((post) => {
			displaySearchPost(post);
		});
	} else {
		displaySearchNoPosts();
	}
}

function displaySearchPost(post) {
	const content = document.querySelector("#posts-content");

	if(post.image_src == null) {
		content.innerHTML += `
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
		content.innerHTML += `
		<div class="post card mt-5 p-3">
			<div class="card-body">
				<div class="d-flex-between-center">
					<h3 class="post-title card-title mb-3">${post.title}</h3>
					<h5 class="text-muted">${post.category_name}</h5>
				</div>
				<p class="text-muted">${post.description}</p>
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

function displaySearchNoPosts() {
	const content = document.querySelector("#posts-content");

	content.innerHTML = `
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

function updateCategoryPagination(data) {
	const pagination = document.querySelector(".pagination");

	pagination.innerHTML = "";

	let totalPages = calculatePostPages(data);

	for(let i = 0; i < totalPages; i++) {
		let link = createPaginationLink(i, data);

		pagination.appendChild(link);
	}

	if(totalPages > 1) {
		// Show or remove next link
		if(totalPages > data.current_page) {
			let nextLink = createPaginationNextLink(data);

			pagination.appendChild(nextLink);
		}
		// Show or remove previous link
		if(data.current_page > 1) {
			let prevLink = createPaginationPrevLink(data);

			pagination.insertBefore(prevLink, pagination.firstElementChild);
		}
	}
}

function createPaginationLink(position, data) {
	let current = position + 1;
	let a    = document.createElement("a");

	a.innerText = current;
	a.className = ((data.current_page - 1) == position) ? 'pagination-link pagination-link-selected' : 'pagination-link';
	a.href      = `${APP_SRC}posts/search/${data.category_id}/${current}`
	a.addEventListener("click", (e) => {

		e.preventDefault();

		let url = a.href;

		fetchCategoryPosts(url)
		.then(data => {
			showCategoryPosts(data);
			updateCategoryPagination(data);
		});

	});

	return a;
}

function createPaginationPrevLink(data) {
	let prevPage = parseInt(data.current_page) - 1;
	let a        = document.createElement("a");

	a.className = "prev-link prev";
	a.href      = `${APP_SRC}posts/search/${data.category_id}/${prevPage}`;
	a.addEventListener("click", (e) => {

		e.preventDefault();

		let url = a.href;

		fetchCategoryPosts(url)
		.then(data => {
			showCategoryPosts(data);
			updateCategoryPagination(data);
		});

	});

	let icon = document.createElement("i");

	icon.className = "bx bx-chevrons-left";

	a.appendChild(icon);

	return a;
}

function createPaginationNextLink(data) {
	let nextPage = parseInt(data.current_page) + 1;
	let a        = document.createElement("a");

	a.className = "next-link next";
	a.href      = `${APP_SRC}posts/search/${data.category_id}/${nextPage}`;
	a.addEventListener("click", (e) => {

		e.preventDefault();

		let url = a.href;

		fetchCategoryPosts(url)
		.then(data => {
			showCategoryPosts(data);
			updateCategoryPagination(data);
		});

	});

	let icon = document.createElement("i");

	icon.className = "bx bx-chevrons-right";
	
	a.appendChild(icon);

	return a;
}

function calculatePostPages(data) {
	let pages = parseInt(data.total) / parseInt(data.limit);

	pages = (parseInt(data.total) % parseInt(data.limit) != 0) ? pages + 1 : pages;
	pages = Math.floor(pages);

	return pages;
}

// ========================================================================= //
// Fetch function
// ========================================================================= //

async function fetchCategoryPosts(url) {
	const resposne = await fetch(url, {
		method: 'GET',
		headers: {
			"X-Requested-With": "XMLHttpRequest"
		},
		referrer: 'http://blogdevcommunity/posts',
		referrerPolicy: 'same-origin'
	});

	const posts = await resposne.json();

	return posts;
}