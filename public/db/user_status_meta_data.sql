# Status ID
# User ID
# Is Logged
# Logged In
# Logged Out
# Total Posts
# Star Rating
# Created At
# Updated At

CREATE TABLE user_status(
	status_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL UNIQUE,
    is_logged TINYINT(1),
    logged_in DATETIME NOT NULL,
    logged_out DATETIME NOT NULL,
    total_posts INT DEFAULT 0,
    star_rating INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT user_status_user_id_fk FOREIGN KEY(user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    PRIMARY KEY(status_id)
);