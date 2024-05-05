CREATE DATABASE television;

CREATE TABLE Channels(
    PRIMARY KEY (id),
    id   INT          NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE Genres(
    PRIMARY KEY(id),
    id    INT         NOT NULL AUTO_INCREMENT,
    genre VARCHAR(20) NOT NULL
);

CREATE TABLE Programs(
    PRIMARY KEY(id, channel_id),
    id             INT          NOT NULL AUTO_INCREMENT,
    channel_id     INT          NOT NULL,
    genre_id       INT          NOT NULL,
    program_title  VARCHAR(100) NOT NULL,
    program_detail VARCHAR(500) NOT NULL,
    FOREIGN KEY(channel_id) REFERENCES Channels(id),
    FOREIGN KEY(genre_id)   REFERENCES Genres(id)
);

CREATE TABLE Seasons(
    PRIMARY KEY(id, program_id),
    id         INT NOT NULL AUTO_INCREMENT,
    program_id INT NOT NULL,
    season_no  INT,
    FOREIGN KEY(program_id) REFERENCES Programs(id)
);

CREATE TABLE Episodes(
    PRIMARY KEY(id, program_id, season_id),
    id             INT          NOT NULL AUTO_INCREMENT,
    program_id     INT          NOT NULL,
    season_id      INT          NOT NULL,
    episode_no     INT,
    episode_title  VARCHAR(100) NOT NULL,
    episode_detail VARCHAR(500) NOT NULL,
    video_length   TIME         NOT NULL,
    release_date   DATE         NOT NULL,
    num_of_views   INT          NOT NULL DEFAULT 0,
    FOREIGN KEY(program_id) REFERENCES Programs(id),
    FOREIGN KEY(season_id)  REFERENCES Seasons(id)
);

CREATE TABLE Times(
    PRIMARY KEY(id, program_id, season_id, episode_id),
    id         INT  NOT NULL AUTO_INCREMENT,
    program_id INT  NOT NULL,
    season_id  INT  NOT NULL,
    episode_id INT  NOT NULL,
    start_time TIME NOT NULL,
    end_time   TIME NOT NULL,
    FOREIGN KEY(program_id) REFERENCES Programs(id),
    FOREIGN KEY(season_id)  REFERENCES Seasons(id),
    FOREIGN KEY(episode_id) REFERENCES Episodes(id)
);
