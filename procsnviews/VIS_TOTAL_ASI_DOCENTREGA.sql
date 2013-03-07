CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `VIS_TOTAL_ASI_DOCENTREGA` AS
    select 
        `p`.`DocEntrega` AS `DocEntrega`,
        sum(`p`.`PED_UNIDADES_ASIGNADAS`) AS `UnidadesAsignadas`
    from
        `Pedidos` `p`
    where
        (`p`.`StatusComplete` = 'NO')
    group by `p`.`DocEntrega`
    order by `p`.`DocEntrega`