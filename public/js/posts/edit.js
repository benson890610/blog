const deleteImageLabel = document.querySelector("#delete-image-label");
const deleteImageCheck = document.querySelector("#delete_image");
const editForm         = document.querySelector("#edit-form");

if(deleteImageLabel != null) {
	deleteImageLabel.addEventListener("click", (e) => {
		if(deleteImageCheck.checked === false) {
			deleteImageLabel.className = "btn btn-danger";
		} else {
			deleteImageLabel.className = "btn btn-outline-danger";
		}
	});
}

editForm.addEventListener("submit", (e) => {

	e.preventDefault();

	//CKEDITOR texarea value fix
	for(instance in CKEDITOR.instances) {
		CKEDITOR.instances[instance].updateElement();
	}

	e.target.submit();

});
