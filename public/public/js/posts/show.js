window.addEventListener("load", (e) => {

	const deleteForm = document.querySelector("#delete-post-form");

	deleteForm.addEventListener("submit", (e) => {

		e.preventDefault();

		if(confirm("Do you want to remove this post?")) {

			deleteForm.submit();

		}

	});

});