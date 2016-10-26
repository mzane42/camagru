SELECT image.id AS image_id, user.login, url_link, creation_date, user.id AS user_id, GROUP_CONCAT(ci.content) AS comments, GROUP_CONCAT(u1.login) AS authors, COUNT(likes.likes_id) AS count_likes, COUNT(comments.comments_id) AS count_comments FROM `image`
LEFT JOIN `user` ON user.id = image.user_id
LEFT JOIN comment_image ci ON image.id = ci.image_id
LEFT JOIN user u1 ON u1.id = ci.user_id
LEFT JOIN (SELECT like_image.id AS likes_id, image_id FROM like_image LEFT JOIN image ON image.id = like_image.image_id WHERE like_image.image_id = image.id) likes ON likes.image_id = image.id
LEFT JOIN (SELECT comment_image.id AS comments_id, comment_image.image_id FROM comment_imageLEFT JOIN image ON image.id = comment_image.image_id WHERE comment_image.image_id = image.id) comments ON comments.image_id = image.id
GROUP BY image.id

SELECT image.id AS image_id, user.login, url_link, creation_date, user.id AS user_id, GROUP_CONCAT(ci.content) AS comments, GROUP_CONCAT(u1.login) AS authors, COUNT(likes.likes_id) AS count_likes, COUNT(comments.comments_id) AS count_comments FROM `image`
LEFT JOIN `user` ON user.id = image.user_id LEFT JOIN comment_image ci ON image.id = ci.image_id
LEFT JOIN comment_image ci ON image.id = ci.image_id
LEFT JOIN user u1 ON u1.id = ci.user_id
LEFT JOIN (SELECT like_image.id AS likes_id, image_id FROM like_image LEFT JOIN image ON image.id = like_image.image_id WHERE like_image.image_id = image.id) likes ON likes.image_id = image.id
LEFT JOIN (SELECT comment_image.id AS comments_id, comment_image.image_id FROM comment_imageLEFT JOIN image ON image.id = comment_image.image_id WHERE comment_image.image_id = image.id) comments ON comments.image_id = image.id
GROUP BY image.id


SELECT image.id AS image_id, user.login, url_link, creation_date, user.id AS user_id, GROUP_CONCAT(ci.content) AS comments, GROUP_CONCAT(u1.login) AS authors, COUNT(likes.likes_id) AS count_likes AS count_comments FROM `image`
LEFT JOIN `user` ON user.id = image.user_id
LEFT JOIN comment_image ci ON image.id = ci.image_id
LEFT JOIN user u1 ON u1.id = ci.user_id
LEFT JOIN (SELECT like_image.id AS likes_id, image_id FROM like_image LEFT JOIN image ON image.id = like_image.image_id WHERE like_image.image_id = image.id) likes ON likes.image_id = image.id
GROUP BY image.id

, COUNT(comments.comments_id)

SELECT image.id AS image_id, user.login, url_link, creation_date, user.id AS user_id, GROUP_CONCAT(ci.content) AS comments, GROUP_CONCAT(u1.login) AS authors FROM `image` LEFT JOIN `user` ON user.id = image.user_id LEFT JOIN comment_image ci ON image.id = ci.image_id LEFT JOIN user u1 ON u1.id = ci.user_id GROUP BY image.id

SELECT image.id AS image_id, user.login, url_link, creation_date, user.id AS user_id, GROUP_CONCAT(ci.content) AS comments, GROUP_CONCAT(u1.login) AS authors, COUNT(likes.likes_id) AS count_likes, COUNT(comments.comments_id) AS count_comments FROM `image`
LEFT JOIN `user` ON user.id = image.user_id LEFT JOIN comment_image ci ON image.id = ci.image_id
LEFT JOIN user u1 ON u1.id = ci.user_id
LEFT JOIN (SELECT like_image.id AS likes_id, image_id FROM like_image LEFT JOIN image ON image.id = like_image.image_id WHERE like_image.image_id = image.id) likes ON likes.image_id = image.id
LEFT JOIN (SELECT comment_image.id AS comments_id, comment_image.image_id FROM comment_image LEFT JOIN image ON image.id = comment_image.image_id WHERE comment_image.image_id = image.id) comments ON comments.image_id = image.id
GROUP BY image.id



SELECT image.id AS image_id, user.login, url_link, creation_date, user.id AS user_id, GROUP_CONCAT(ci.content) AS comments, GROUP_CONCAT(u1.login) AS authors FROM `image`
LEFT JOIN `user` ON user.id = image.user_id
LEFT JOIN comment_image ci ON image.id = ci.image_id
LEFT JOIN user u1 ON u1.id = ci.user_id
LEFT JOIN (SELECT like_image.id AS likes_id, image.id FROM `like_image` LEFT JOIN image ON image.id = like_image.image_id WHERE like_image.image_id = image.id) likes ON likes.image_id = image.id GROUP BY image.id
