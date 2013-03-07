-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRO_ASI_COMPLETABLE`()
BEGIN

	-- Variables para CUR_1
	DECLARE done BOOLEAN DEFAULT FALSE;
	DECLARE VAR_DOCENTREGA DOUBLE;
	DECLARE VAR_UNIDADES DOUBLE;
	DECLARE VAR_VIEW_DOCENTREGA DOUBLE;
	DECLARE VAR_VIEW_PEDIDO DOUBLE;
	DECLARE VAR_VIEW_TOTAL_ASI DOUBLE;

	DECLARE CUR_1 CURSOR FOR
		SELECT
			e.DocEntrega,
			e.UnidadesAsignadas
		FROM
			VIS_COMPLETABLE_ETA e;

	DECLARE CUR_2 CURSOR FOR
		SELECT
			f.DocEntrega,
			f.UnidadesAsignadas
		FROM
			VIS_COMPLETABLE_FPE f;

	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

	OPEN CUR_1;

	eta_loop: LOOP

		FETCH CUR_1 INTO VAR_DOCENTREGA, VAR_UNIDADES;

		IF done THEN
			CLOSE CUR_1;
			LEAVE eta_loop;
		END IF;

		SELECT 
			v.DocEntrega,
			v.UnidadesPedidas,
			t.UnidadesAsignadas
		INTO
			VAR_VIEW_DOCENTREGA,
			VAR_VIEW_PEDIDO,
			VAR_VIEW_TOTAL_ASI
		FROM
			VIS_TOTAL_PEDIDO_DOCENTREGA v,
			VIS_TOTAL_ASI_DOCENTREGA t
		WHERE
			t.DocEntrega = v.DocEntrega
			AND t.DocEntrega = VAR_DOCENTREGA
		ORDER BY
			t.DocEntrega;

		-- Si la suma de lo ya asignado con lo
		-- asignado por ETA es igual a lo pedido,
		-- se pone el status .
		IF VAR_UNIDADES + VAR_VIEW_TOTAL_ASI = VAR_VIEW_PEDIDO THEN

			UPDATE Pedidos
			SET PED_COMPLETABLE_ETA = TRUE
			WHERE DocEntrega = VAR_DOCENTREGA;

		END IF;

		SET VAR_VIEW_DOCENTREGA := NULL;
		SET VAR_VIEW_PEDIDO := NULL;
		SET VAR_VIEW_TOTAL_ASI := NULL;
		SET VAR_DOCENTREGA := NULL;
		SET VAR_UNIDADES := NULL;

	END LOOP;
	
	SET done := FALSE;
	OPEN CUR_2;

	fpe_loop: LOOP

		FETCH CUR_2 INTO VAR_DOCENTREGA, VAR_UNIDADES;

		IF done THEN
			CLOSE CUR_2;
			LEAVE fpe_loop;
		END IF;

		SELECT 
			v.DocEntrega,
			v.UnidadesPedidas,
			t.UnidadesAsignadas
		INTO
			VAR_VIEW_DOCENTREGA,
			VAR_VIEW_PEDIDO,
			VAR_VIEW_TOTAL_ASI
		FROM
			VIS_TOTAL_PEDIDO_DOCENTREGA v,
			VIS_TOTAL_ASI_DOCENTREGA t
		WHERE
			t.DocEntrega = v.DocEntrega
			AND t.DocEntrega = VAR_DOCENTREGA
		ORDER BY
			t.DocEntrega;

		-- Si la suma de lo ya asignado con lo
		-- asignado por FPE es igual a lo pedido,
		-- se pone el status .
		IF VAR_UNIDADES + VAR_VIEW_TOTAL_ASI = VAR_VIEW_PEDIDO THEN

			UPDATE Pedidos
			SET PED_COMPLETABLE_FPE = TRUE
			WHERE DocEntrega = VAR_DOCENTREGA;

		END IF;

		SET VAR_VIEW_DOCENTREGA := NULL;
		SET VAR_VIEW_PEDIDO := NULL;
		SET VAR_VIEW_TOTAL_ASI := NULL;
		SET VAR_DOCENTREGA := NULL;
		SET VAR_UNIDADES := NULL;

	END LOOP;

	COMMIT;

END