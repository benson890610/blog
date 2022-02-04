# ID
# First Name
# Last Name
# Email
# Username 
# Password
# Address ID
# Image ID
# Updated At
# Registered At

CREATE TABLE IF NOT EXISTS users(
	user_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(20) NOT NULL,
    last_name VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    username VARCHAR(20) NOT NULL,
    password VARCHAR(100) NOT NULL,
    address_id INT UNSIGNED DEFAULT NULL,
    image_id INT UNSIGNED DEFAULT NULL,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    registered_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT users_email_uk UNIQUE(email),
    CONSTRAINT users_username_uk UNIQUE(username),
    CONSTRAINT users_address_id_fk FOREIGN KEY(address_id) REFERENCES address(address_id) ON DELETE SET NULL,
    CONSTRAINT users_image_id_fk FOREIGN KEY(image_id) REFERENCES profile_images(image_id) ON DELETE SET NULL,
    PRIMARY KEY(user_id)
);
