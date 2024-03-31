-- 必要なテーブル情報

-- 動画テーブル

CREATE TABLE videos (
  id INT PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  video LONGBLOB NOT NULL,
  thumbnail LONGBLOB NOT NULL,
  created_at DATETIME NOT NULL,
  visibility ENUM('public', 'private') NOT NULL DEFAULT 'public',
  deleted BOOLEAN NOT NULL DEFAULT FALSE,
  delete_reason TEXT DEFAULT NULL
);

-- ユーザーテーブル

CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL
);

-- ユーザー動画テーブル
CREATE TABLE user_videos (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  video_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (video_id) REFERENCES videos(id)
);