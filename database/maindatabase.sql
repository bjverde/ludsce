PRAGMA foreign_keys=OFF; 

CREATE TABLE arquivos( 
      idarquivo  INTEGER    NOT NULL  , 
      nrordem int   NOT NULL  , 
      stAtivo char  (1)   NOT NULL  , 
      img_caminho text   NOT NULL  , 
      dt_inicio datetime   NOT NULL  , 
      dt_fim datetime   NOT NULL  , 
      nmlogin_inclusao varchar  (300)   NOT NULL  , 
      dt_inclusao datetime   NOT NULL  , 
      nmlogin_alteracao varchar  (300)   , 
      dt_alteracao datetime   , 
      dt_exclusao datetime   , 
 PRIMARY KEY (idarquivo)) ; 

CREATE TABLE config( 
       id INTEGER NOT NULL
      ,show_title_bar  char(1) NOT NULL DEFAULT 'S'
      ,title_bar_color char(8) NOT NULL
      ,name_title text NULL
      ,color_name char  (8)   NOT NULL
      ,logo_file  text
      ,show_clock char(1) NOT NULL DEFAULT 'S'
      ,interval   int     NOT NULL DEFAULT 5000
      ,show_info  char(1) NOT NULL DEFAULT 'N'
      ,PRIMARY KEY (id)
      );