select
    `posts`.*,
    (select COUNT(CASE WHEN type = "LIKE" THEN 1 ELSE 0 END) from `post_reactions` where `post_id` = `posts`.`id` and `deleted_at` is null) as `reactionsCount`
from `posts`
    inner join `post_categories` on
        `post_categories`.`id` = `posts`.`category_id`
where
    `post_categories`.`slug` = 'videos' and
    `posts`.`deleted_at` is null
order by
    `views` desc
limit 3;


select
    `posts`.*,
    (
        select
          cOUNT(CASE WHEN type = "LIKE" THEN 1 ELSE 0 END) as 'like_count',
          SUM(CASE WHEN type = "UNLIKE" THEN 1 ELSE 0 END) as 'unlike_count'
        from `post_reactions`
        where
            `post_id` = `posts`.`id` and
            `deleted_at` is null
    ) as `reactions_count`
from `posts`
    inner join `post_categories` on `post_categories`.`id` = `posts`.`category_id`
where
    `post_categories`.`slug` = 'videos' and
    `posts`.`deleted_at` is null
order by
    `views` desc
limit 3;

SELECT
  (SELECT SUM(CASE
                  WHEN TYPE = 'LIKE' THEN 1
                  ELSE 0
              END) AS like_count
   FROM `post_reactions`
   WHERE `post_id` = `posts`.`id`
     AND `type` = 'LIKE'
     AND `deleted_at` IS NULL
   GROUP BY `post_id`) AS `like_count`,

  (SELECT SUM(CASE
                  WHEN TYPE = 'UNLIKE' THEN 1
                  ELSE 0
              END) AS unlike_count
   FROM `post_reactions`
   WHERE `post_id` = `posts`.`id`
     AND `type` = 'UNLIKE'
     AND `deleted_at` IS NULL
   GROUP BY `post_id`) AS `unlike_count`
FROM `posts`
INNER JOIN `post_categories` ON `post_categories`.`id` = `posts`.`category_id`
INNER JOIN `post_categories` ON `post_categories`.`id` = `posts`.`category_id`
WHERE `post_categories`.`slug` = videos
  AND `post_categories`.`slug` = videos
  AND `posts`.`deleted_at` IS NULL
ORDER BY `views` DESC,
         `views` DESC
LIMIT 3;

SELECT
    SUM(CASE WHEN type = 'LIKE' THEN 1 ELSE 0 END) as like_count
FROM
    post_reactions
WHERE post_id = 18;

