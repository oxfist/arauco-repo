-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRO_ASI_ETA`()
BEGIN

	-- Variables para CUR_1
	DECLARE done BOOLEAN DEFAULT FALSE;
	DECLARE var_DocEntrega DOUBLE UNSIGNED;
	DECLARE var_PosPedido DOUBLE UNSIGNED;
	DECLARE var_Material DOUBLE UNSIGNED;
	-- DECLARE var_Desc_Mat VARCHAR(100);
	DECLARE var_LotesPedidos SMALLINT UNSIGNED;
	DECLARE var_LotesAsignados SMALLINT UNSIGNED;
	DECLARE VAR_AUX_MATERIAL DOUBLE UNSIGNED;

	-- Variables para CUR_2
	DECLARE VAR_STOCK_Lote varchar(255);

	-- Todos los pedidos que no est√°n completos.
	DECLARE CUR_1 CURSOR FOR
		SELECT
			p.DocEntrega,
			p.PosPedido,
			p.Material,
			p.PED_UNIDADES_SOLICITADAS,
			p.PED_UNIDADES_ASIGNADAS
		FROM
			Pedidos p
		WHERE
			p.StatusComplete = 'NO'
		ORDER BY
			p.Eta ASC;

	-- Todas las unidades que no han sido
	-- asignadas normalmente ni por ETA
	DECLARE CUR_2 CURSOR FOR
		SELECT
			s.Lote
			-- s.Material,
			-- s.Status
		FROM
			Stock s
		WHERE
			s.Status != 'A'
			AND s.STO_STATUS_ASI_ETA IS NULL
			AND s.Material = VAR_AUX_MATERIAL
		ORDER BY
			s.Lote DESC;

	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done := TRUE;

	OPEN CUR_1;

	process_loop: LOOP

		FETCH CUR_1 INTO
			var_DocEntrega,
			var_PosPedido,
			var_Material,
			var_LotesPedidos,
			var_LotesAsignados;

		IF done THEN
			CLOSE CUR_1;
			LEAVE process_loop;
		END IF;

		IF var_LotesAsignados < var_LotesPedidos THEN

			-- Se guarda el ID de material del actual Pedido
			SET VAR_AUX_MATERIAL := var_Material;
			OPEN CUR_2;

			asignacion_lotes_loop: LOOP

				-- Si el total de lotes asignados es menor a lo pedido
				-- por PosPedido (recordar que todo el pedido se considera
				-- incompleto si falta al menos una unidad por asignar).
				-- Se debe realizar esta comparaciÛn para no asignarle
				-- lotes a los PosPedido completos de un DocEntrega incompleto.

					FETCH CUR_2 INTO VAR_STOCK_Lote;-- , VAR_STOCK_Material, VAR_STOCK_Status;

					-- Se terminan los registros de CUR_2
					-- o se asignaron todos los lotes
					IF done OR var_LotesAsignados = var_LotesPedidos THEN
						SET done := FALSE;
						CLOSE CUR_2;
						LEAVE asignacion_lotes_loop;
					END IF;

					-- Se actualiza el lote para que estÈ asignado
					-- por ETA al DocEntrega y PosPedido
					UPDATE
						Stock
					SET
						STO_STATUS_ASI_ETA = 'A',
						STO_DOCENTREGA_ASI_ETA = var_DocEntrega,
						STO_POSPEDIDO_ASI_ETA = var_PosPedido
					WHERE
						Stock.Lote = VAR_STOCK_Lote;
					-- Se suma a la variable que guarda lo actualmente
					-- asignado el lote que fue asignado por ETA (es decir, +1)
					SET var_LotesAsignados := var_LotesAsignados + 1;

			END LOOP;

		END IF;

		SET var_DocEntrega := NULL;
		SET var_PosPedido := NULL;
		SET var_Material := NULL;
		SET var_LotesPedidos := NULL;
		SET var_LotesAsignados := NULL;
		SET VAR_AUX_MATERIAL := NULL;

	END LOOP;

	COMMIT;

END
