# Post ID
# Title
# Description 
# User ID
# Created At
# Updated At

CREATE TABLE posts(
	post_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    user_id INT UNSIGNED NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT posts_user_id_fk FOREIGN KEY(user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    PRIMARY KEY(post_id)
);