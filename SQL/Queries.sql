1
SELECT
     episode_title AS エピソードタイトル,
     num_of_views  AS 視聴数
  FROM Episodes
 ORDER BY num_of_views DESC
 LIMIT 3;

2
SELECT
     P.program_title  AS 番組タイトル,
     S.season_no      AS シーズン数,
     E.episode_no     AS エピソード数,
     E.episode_title  AS エピソードタイトル,
     E.num_of_views   AS 視聴数
  FROM Programs AS P
       LEFT JOIN Episodes AS E
       ON P.id = E.program_id
       LEFT JOIN Seasons AS S
       ON S.id = E.season_id
 ORDER BY E.num_of_views DESC
 LIMIT 3;

3
-- サンプルデータの都合上、「本日」は2024-02-16としている
SELECT
     C.name           AS チャンネル名,
     P.program_title  AS 番組タイトル,
     E.release_date   AS 公開日,
     T.start_time     AS 放送開始時刻,
     T.end_time       AS 放送終了時刻,
     S.season_no      AS シーズン数,
     E.episode_no     AS エピソード数,
     E.episode_title  AS エピソードタイトル,
     E.episode_detail AS エピソード詳細
  FROM Channels AS C
       LEFT JOIN Programs AS P
       ON C.id = P.channel_id
       LEFT JOIN Episodes AS E
       ON P.id = E.program_id
       LEFT JOIN Times AS T
       ON E.id = T.episode_id
       LEFT JOIN Seasons AS S
       ON S.id = E.season_id
 WHERE release_date = '2024-02-16'
   AND (start_time BETWEEN '0:00:00' AND '23:59:59');
-- 「本日」のデータを抽出するなら
--  WHERE release_date = CURDATE()
--    AND (start_time BETWEEN '0:00:00' AND '23:59:59');

4
-- サンプルデータの都合上、「本日」は2024-02-10としている
SELECT
     release_date   AS 公開日,
     C.name         AS チャンネル名,
     start_time     AS 放送開始時刻,
     end_time       AS 放送終了時刻,
     season_no      AS シーズン数,
     episode_no     AS エピソード数,
     episode_title  AS エピソードタイトル,
     episode_detail AS エピソード詳細
  FROM Channels AS C
       LEFT JOIN Programs AS P
       ON C.id = P.channel_id
       LEFT JOIN Episodes AS E
       ON P.id = E.program_id
       LEFT JOIN Times AS T
       ON E.id = T.episode_id
       LEFT JOIN Seasons AS S
       ON S.id = E.season_id
 WHERE (C.name LIKE 'ドラマ%')
   AND (release_date BETWEEN '2024-02-10' AND '2024-02-17')
   AND (start_time BETWEEN '0:00:00' AND '23:59:59');
-- 「本日」のデータを抽出するなら
--  WHERE (C.name LIKE 'ドラマ%')
--    AND (release_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY))
--    AND (start_time BETWEEN '0:00:00' AND '23:59:59');

5
SELECT
     program_title,
     num_of_views
  FROM Programs AS P
       LEFT JOIN Episodes AS E
       ON P.id = E.program_id
 WHERE release_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()
 ORDER BY num_of_views DESC
 LIMIT 2;

6
SELECT G1.genre AS ジャンル名,
       (SELECT avg_per_program.program_title
          FROM Genres AS G2
               INNER JOIN Programs AS P
               ON G2.id = P.genre_id
               INNER JOIN (SELECT program_title, AVG(num_of_views) AS avg2
                             FROM Episodes AS E
                                  LEFT JOIN Programs AS P
                                  ON E.program_id = P.id
                            GROUP BY program_title) AS avg_per_program
               ON avg_per_program.program_title = P.program_title
        WHERE avg2 = MAX(avg_per_program.avg1)
          AND G1.genre = G2.genre) AS 番組タイトル,
       MAX(avg_per_program.avg1) AS エピソード平均視聴数
  FROM Genres AS G1
       INNER JOIN Programs AS P
       ON G1.id = P.genre_id
       INNER JOIN (SELECT program_title, AVG(num_of_views) AS avg1
                     FROM Episodes AS E
                          LEFT JOIN Programs AS P
                          ON E.program_id = P.id
                    GROUP BY program_title) AS avg_per_program
       ON avg_per_program.program_title = P.program_title
 GROUP BY G1.genre;
