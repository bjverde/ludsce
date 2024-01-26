INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Arquivos','ArquivosList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) 
    VALUES ( (SELECT max(sgp.id) + 1 FROM system_group_program as sgp)
           , 1 -- adm
           , (SELECT p.id FROM system_program p where p.controller = 'ArquivosList')
           );

INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro Arquivos','ArquivosForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) 
    VALUES ( (SELECT max(sgp.id) + 1 FROM system_group_program as sgp)
           , 1 -- adm
           , (SELECT p.id FROM system_program p where p.controller = 'ArquivosForm')
           );

INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Config','ConfigForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) 
    VALUES ( (SELECT max(sgp.id) + 1 FROM system_group_program as sgp)
           , 1 -- adm
           , (SELECT p.id FROM system_program p where p.controller = 'ConfigForm')
           );

-- Remove Documente
DELETE FROM system_group_program 
WHERE 1=1
and system_group_id = 1 -- adm
and system_program_id in (21,43,46,47,49);


-- Remove Wiki
DELETE FROM system_group_program 
WHERE 1=1
and system_group_id = 1 -- adm
and system_program_id in (58,59,60,61);

-- Remove Publicações
DELETE FROM system_group_program 
WHERE 1=1
and system_group_id = 1 -- adm
and system_program_id in (52,53,54,55,56);





-- ------------------------
-- Grupo user
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Arquivos','ArquivosList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) 
    VALUES ( (SELECT max(sgp.id) + 1 FROM system_group_program as sgp)
           , 2 -- user
           , (SELECT p.id FROM system_program p where p.controller = 'ArquivosList')
           );

INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro Arquivos','ArquivosForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) 
    VALUES ( (SELECT max(sgp.id) + 1 FROM system_group_program as sgp)
           , 2 -- user
           , (SELECT p.id FROM system_program p where p.controller = 'ArquivosForm')
           );

INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Config','ConfigForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) 
    VALUES ( (SELECT max(sgp.id) + 1 FROM system_group_program as sgp)
           , 2 -- user
           , (SELECT p.id FROM system_program p where p.controller = 'ConfigForm')
           );

-- Remove Documente
DELETE FROM system_group_program 
WHERE 1=1
and system_group_id = 2 -- user
and system_program_id in (21,43,46,47,49);


-- Remove Wiki
DELETE FROM system_group_program 
WHERE 1=1
and system_group_id = 2 -- user
and system_program_id in (58,59,60,61);

-- Remove Publicações
DELETE FROM system_group_program 
WHERE 1=1
and system_group_id = 2 -- user
and system_program_id in (52,53,54,55,56);