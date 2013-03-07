CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `VIS_COMPLETABLE_ETA` AS
    select 
        `p`.`DocEntrega` AS `DocEntrega`,
        count(`s`.`Lote`) AS `UnidadesAsignadas`
    from
        (`Stock` `s`
        join `Pedidos` `p`)
    where
        ((`s`.`STO_DOCENTREGA_ASI_ETA` = `p`.`DocEntrega`)
            and (`s`.`STO_POSPEDIDO_ASI_ETA` = `p`.`PosPedido`))
    group by `p`.`DocEntrega`
    order by `p`.`DocEntrega`