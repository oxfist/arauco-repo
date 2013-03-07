CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `VIS_COMPLETABLE_FPE` AS
    select 
        `p`.`DocEntrega` AS `DocEntrega`,
        count(`s`.`Lote`) AS `UnidadesAsignadas`
    from
        (`Stock` `s`
        join `Pedidos` `p`)
    where
        ((`s`.`STO_DOCENTREGA_ASI_FPE` = `p`.`DocEntrega`)
            and (`s`.`STO_POSPEDIDO_ASI_FPE` = `p`.`PosPedido`))
    group by `p`.`DocEntrega`
    order by `p`.`DocEntrega`
