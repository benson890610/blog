# Image ID
# Name
# Size
# Type
# Src Path
# Root Path
# Post ID

CREATE TABLE post_images(
	image_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    size INT UNSIGNED NOT NULL,
    type VARCHAR(30) NOT NULL,
    src_path VARCHAR(255) NOT NULL,
    root_path VARCHAR(255) NOT NULL,
    post_id INT UNSIGNED NOT NULL UNIQUE,
    CONSTRAINT post_images_post_id_fk FOREIGN KEY(post_id) REFERENCES posts(post_id) ON DELETE CASCADE,
    PRIMARY KEY(image_id)
);