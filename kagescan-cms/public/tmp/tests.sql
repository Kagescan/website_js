CREATE TABLE articles (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(128) NOT NULL,
  slug varchar(128) NOT NULL,
  body text NOT NULL,

  PRIMARY KEY (id),
  KEY slug (slug)
);

INSERT INTO articles(title, slug, body) VALUES (
  "Nouveau site pour Kagescan !",
  "blog:new_kagescan",
  "Kagescan a déjà 5 ans :open_mouth:. Sans réelle mise à jour depuis 2018, il était temps de le remettre à neuf !"
);

INSERT INTO articles(title, slug, body) VALUES (
  "Du concret sur l'animé ?",
  "blog:anime_concret",
  "Promis depuis 2016, nous nous retrouvons enfin avec une annonce concrète !"
);
