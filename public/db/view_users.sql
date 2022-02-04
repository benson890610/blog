# User ID
# Full Name
# Email
# Username
# Password (temporary)
# Registered At
# Stauts ID
# Is Logged
# Logged In
# Logged Out
# Total Posts
# Star Rating
# Address ID
# Full Address Name
# Image Name
# Src Path
# Root Path

CREATE VIEW view_users AS 
SELECT 
	u.user_id,
    CONCAT_WS(' ', u.first_name, u.last_name) as full_name,
    u.email,
    u.username,
    u.password,
    u.registered_at,
    us.status_id,
    us.is_logged,
    us.logged_in,
    us.logged_out,
    us.total_posts,
    us.star_rating,
    a.address_id,
    CONCAT(c.name, ' ', a.city, '(', a.zip_code, ')', a.address_line) as full_address,
    pi.name as image_name,
    pi.src_path,
    pi.root_path
FROM users u
INNER JOIN user_status us 
	ON u.user_id = us.user_id
LEFT JOIN address a 
	ON u.address_id = a.address_id
LEFT JOIN countries c 
	ON a.country_id = c.country_id
LEFT JOIN profile_images pi 
	ON u.image_id = pi.image_id;
	