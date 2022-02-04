# Image ID
# Name
# Size
# Type
# Root Path
# Src Path
# User ID
# Created At
# Updated At

CREATE TABLE IF NOT EXISTS profile_images(
	image_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    size INT NOT NULL,
    type VARCHAR(30) NOT NULL,
    src_path VARCHAR(255) NOT NULL,
    root_path VARCHAR(255) NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(image_id)
);

ALTER TABLE profile_images
ADD CONSTRAINT profile_images_user_id_fk FOREIGN KEY(user_id) REFERENCES users(user_id) ON DELETE CASCADE;