-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRO_ASI_COM_INC`()
BEGIN

	-- Variables para FETCH del cursor
	DECLARE done BOOLEAN DEFAULT FALSE;
	DECLARE var_DocEntrega DOUBLE;
	DECLARE var_PosPedido DOUBLE;
	DECLARE var_Material DOUBLE;
	DECLARE var_Desc_Mat VARCHAR(255);
	DECLARE var_LotesPedidos MEDIUMINT UNSIGNED;
	DECLARE var_LotesAsignados MEDIUMINT UNSIGNED;
	DECLARE var_StatusComplete VARCHAR(3);

	DECLARE VAR_SUMA_TOTAL_LOTES MEDIUMINT UNSIGNED;
	DECLARE VAR_SUMA_LOTES_PUERTO MEDIUMINT UNSIGNED;

	DECLARE CUR_FIRST CURSOR FOR
		SELECT
			p.DocEntrega,
			p.PosPedido,
			s.Material,
			s.Desc_Mat,
			p.PED_UNIDADES_SOLICITADAS,
			COUNT( s.Lote ) UnidadesAsignadas,
			p.Statuscomplete
		FROM
			Stock s,
			Pedidos p
		WHERE
			s.Nro_Entrega = p.DocEntrega
			AND s.Pos_Entrega = p.PosPedido

		GROUP BY
			p.DocEntrega,
			p.PosPedido
		ORDER BY
			p.DocEntrega DESC;

        DECLARE CUR_SECOND CURSOR FOR
            SELECT
                    p.DocEntrega
            FROM
                    Pedidos p
            WHERE
                p.PED_UNIDADES_ASIGNADAS < p.PED_UNIDADES_SOLICITADAS
            GROUP BY
                p.DocEntrega;

	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

	OPEN CUR_FIRST;

	first_loop: LOOP

		FETCH CUR_FIRST INTO var_DocEntrega, var_PosPedido,
			var_Material, var_Desc_Mat, var_LotesPedidos,
			var_LotesAsignados, var_StatusComplete;

		IF done THEN
			CLOSE CUR_FIRST;
			LEAVE first_loop;
		END IF;

		-- Si el el DocEntrega no tiene ya asignado 'NO'
		-- y si el total de lotes asignados es menor a lo pedido
                IF ( var_LotesAsignados >= var_LotesPedidos ) THEN
                        -- Cantidad total de lotes asignados
                        SELECT
                                COUNT( s.Lote )
                        INTO
                                VAR_SUMA_TOTAL_LOTES
                        FROM
                                Stock s
                        WHERE
                                s.Nro_Entrega = var_DocEntrega;

                        -- Cantidad de lotes asignados en puerto
                        SELECT
                                COUNT( s.Lote )
                        INTO
                                VAR_SUMA_LOTES_PUERTO
                        FROM
                                Stock s
                        WHERE
                                s.Nro_Entrega = var_DocEntrega
                                AND ((Centro LIKE 'TD%')
                                      OR
                                      (Centro IN ('AD04', 'AD05', 'AD06', 'AD07', 'AD08', 'AD09', 'AD10', 'AD11', 'AD12', 'AD13', 'AD14', 'AD15', 'AD16', 'AD17', 'AD18', 'AD19', 'AD20')));

                              IF ((var_StatusComplete != 'CPL' OR var_StatusComplete IS NULL) AND VAR_SUMA_TOTAL_LOTES = VAR_SUMA_LOTES_PUERTO) THEN
                                UPDATE
                                    Pedidos
                                SET
                                    StatusComplete = 'CPU'
                                WHERE
                                    Pedidos.DocEntrega = var_DocEntrega;
                            ELSE
                                UPDATE
                                    Pedidos
                                SET
                                    StatusComplete = 'CPL'
                                WHERE
                                    Pedidos.DocEntrega = var_DocEntrega;

                            END IF;

                END IF;

		UPDATE
			Pedidos
		SET
			PED_UNIDADES_ASIGNADAS = var_LotesAsignados
		WHERE
			Pedidos.DocEntrega = var_DocEntrega
			AND Pedidos.PosPedido = var_PosPedido;

		SET VAR_SUMA_TOTAL_LOTES := NULL;
		SET VAR_SUMA_LOTES_PUERTO := NULL;
		SET var_DocEntrega := NULL;
		SET var_PosPedido := NULL;
		SET var_Material := NULL;
		SET var_Desc_Mat := NULL;
		SET var_LotesPedidos := NULL;
		SET var_LotesAsignados := NULL;
		SET var_StatusComplete := NULL;

	END LOOP; -- first_loop

        SET done := FALSE;

        OPEN CUR_SECOND;

	second_loop: LOOP

		FETCH CUR_SECOND INTO var_DocEntrega;

		IF done THEN
			CLOSE CUR_SECOND;
			LEAVE second_loop;
		END IF;
            
                UPDATE
                        Pedidos
                SET
                        StatusComplete = 'NO'
                WHERE
                        DocEntrega = var_DocEntrega;

                SET var_DocEntrega := NULL;
        END LOOP;

	COMMIT;

END
