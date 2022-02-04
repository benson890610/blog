# Address ID
# Country ID
# City
# Address Line
# Zip Code
# Updated at
# Created at

CREATE TABLE IF NOT EXISTS address(
	address_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    country_id INT UNSIGNED NOT NULL,
    city VARCHAR(50) NOT NULL,
    address_line VARCHAR(100) NOT NULL,
    zip_code VARCHAR(30) NOT NULL,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT address_country_id_fk FOREIGN KEY(country_id) REFERENCES countries(country_id) ON DELETE CASCADE,
    PRIMARY KEY(address_id)
);