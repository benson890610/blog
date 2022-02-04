window.addEventListener("load", (e) => {

	const APP_SRC          = "http://blogdevcommunity.test/";
	const form             = document.querySelector("#post-form");
	const category         = document.querySelector("#category");
	const title            = document.querySelector("#title");
	const description      = document.querySelector("#summary-editor");
	const file             = document.querySelector("#file");
	const labelFile        = document.querySelector("#label-file");
	const uploadContent    = document.querySelector("#upload-image-content");
	const allowedImageType = ["image/jpeg", "image/png"];
	const IMG_MIN_SIZE     = 50000;

	form.addEventListener("submit", createPost);
	file.addEventListener("change", showFileImage);

	function createPost(e) {
		e.preventDefault();

		let createPost = true;

		//CKEDITOR texarea value fix
		for(instance in CKEDITOR.instances) {
			CKEDITOR.instances[instance].updateElement();
		}

		// Title and Description error check
		if(title.value === "" || description.value === "") {
			createPost = false;

			if(title.value === "") {
				toggleTitleError(true);
			} else {
				toggleTitleError(false);
			}

			if(description.value === "") {
				toggleDescriptionError(true);
			} else {
				toggleDescriptionError(false);
			}
		} else {
			createPost = true;
		}

		if(createPost) {
			toggleTitleError(false);
			toggleDescriptionError(false);
			
			uploadContent.innerHTML = "";
			uploadContent.removeAttribute("style");

			if(file.files.length > 0) {
				let uploadGif = createUploadGif(`${APP_SRC}public/images/uploading.gif`);

				form.appendChild(uploadGif);

				setTimeout(function(){
					e.target.submit();
				}, 2000);
			} else {
				e.target.submit();
			}

		}
	}

	function toggleTitleError(isError) {
		if(isError) {
			title.classList.add("is-invalid");
			title.nextElementSibling.innerText = "Title field is required";
		} else {
			title.classList.remove("is-invalid");
			title.nextElementSibling.innerText = "";
		}
	}

	function toggleDescriptionError(isError) {
		if(isError) {
			description.classList.add("is-invalid");
			description.nextElementSibling.nextElementSibling.innerText = "Description field is required";
		} else {
			description.classList.remove("is-invalid");
			description.nextElementSibling.nextElementSibling.innerText = "";
		}
	}

	function showFileImage(e) {

		const inputFile = e.target;
		const reader    = new FileReader();
		let type = inputFile.files[0].type;
		let size = inputFile.files[0].size;

		uploadContent.innerHTML = "";

		if(allowedImageType.indexOf(type) != -1) {

			hideInputFileError();

			if(size < IMG_MIN_SIZE) {

				showInputFileError("Image resolution must be beyond " + (IMG_MIN_SIZE / 1000) + "Kb");

			} else {

				hideInputFileError();

				reader.readAsDataURL(inputFile.files[0]);
				reader.addEventListener("load", parseImage);

			}

		} else {

			showInputFileError("Unsupported file type");

		}

	}

	function parseImage(e) {
		let result = e.target.result;

		let image    = createUploadImage(result);
		let text     = createUploadImageName(file.files[0].name);
		let close    = createUploadImageCloseBtn();

		uploadContent.style.paddingTop      = "80px";
		uploadContent.style.paddingBottom   = "20px";
		uploadContent.style.backgroundColor = "rgba(255, 255,255, 0.4)";
		uploadContent.style.width           = "100%";
		uploadContent.style.height          = "auto";
		uploadContent.style.overflow        = "hidden";
		uploadContent.style.paddingRight    = "30px";
		uploadContent.appendChild(image);
		uploadContent.appendChild(text);
		uploadContent.appendChild(close);
	}

	function createUploadGif(url) {
		let uploading = new Image();
			uploading.style.display = "block";
			uploading.style.width   = "100px";
			uploading.style.height  = "70px";
			uploading.style.margin  = "0 auto";
			uploading.src           = url;

		return uploading;
	}

	function createUploadImage(url) {
		const image = new Image();

		image.src                = url;
		image.width              = 600;
		image.height             = 400;
		image.style.maxWidth     = "600px";
		image.style.maxHeight    = "400px";
		image.style.display      = "block";
		image.style.margin       = "0 auto";
		image.style.borderRadius = "5px";

		return image;
	}

	function createUploadImageName(name) {
		const text = document.createElement("p");

		text.innerText = name;
		text.style.textAlign  = "center";
		text.style.fontFamily = "Nunito, Arial, sans-serif";
		text.style.fontWeight = "bold";
		text.style.padding    = "10px 0";

		return text;
	}

	function createUploadImageCloseBtn() {
		const btn = document.createElement("span");

		btn.setAttribute("title", "Close");
		btn.innerHTML = "&times;";
		btn.className = "upload-image-close-btn";
		btn.addEventListener("click", closeUploadContent);

		return btn;
	}

	function closeUploadContent() {
		uploadContent.innerHTML = "";
		uploadContent.removeAttribute("style");
		file.value = "";
	}

	function showInputFileError(msg) {
		file.classList.add("is-invalid");
		file.nextElementSibling.innerText = msg;
		labelFile.style.background        = "red";
		labelFile.style.color             = "white"
	}

	function hideInputFileError() {
		file.classList.remove("is-invalid");
		file.nextElementSibling.innerText = "";
		labelFile.removeAttribute("style");
	}

});