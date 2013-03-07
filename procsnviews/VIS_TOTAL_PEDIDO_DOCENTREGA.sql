CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `VIS_TOTAL_PEDIDO_DOCENTREGA` AS
    select 
        `p`.`DocEntrega` AS `DocEntrega`,
        sum(`p`.`PED_UNIDADES_SOLICITADAS`) AS `UnidadesPedidas`
    from
        `Pedidos` `p`
    where
        `p`.`StatusComplete` = 'NO'
    group by `p`.`DocEntrega`
    order by `p`.`DocEntrega`