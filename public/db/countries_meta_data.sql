# Country ID
# Name
# Code
# Phone

CREATE TABLE IF NOT EXISTS countries(
	country_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    code CHAR(2) NOT NULL,
    phone VARCHAR(10) NOT NULL,
    CONSTRAINT countries_code_uk UNIQUE(code),
    CONSTRAINT countries_phone_uk UNIQUE(phone),
    PRIMARY KEY(country_id)
);