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