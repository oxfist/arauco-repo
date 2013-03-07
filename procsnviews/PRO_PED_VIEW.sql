-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRO_PED_VIEW`()
BEGIN

	-- Variables para CUR_1
	DECLARE var_DocEntrega integer UNSIGNED;
	DECLARE var_PosPedido smallint UNSIGNED;
	DECLARE var_PosOrdenFac integer UNSIGNED;
	DECLARE done BOOLEAN;

	-- Todos los pedidos que no están completos.
	DECLARE CUR_1 CURSOR FOR
		SELECT
			p.DocEntrega,
			p.PosPedido,
			p.PosOrdenFac
		FROM
			PedidoView p
		WHERE
			p.CantPosOrdenFac > 1
		ORDER BY
			p.DocEntrega ASC;

	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

	OPEN CUR_1;

	process_loop: LOOP

		FETCH CUR_1 INTO
			var_DocEntrega,
			var_PosPedido,
			var_PosOrdenFac;

		IF done THEN
			CLOSE CUR_1;
			LEAVE process_loop;
		END IF;
		
		DELETE FROM Pedidos
		WHERE Pedidos.DocEntrega = var_DocEntrega
		AND Pedidos.PosPedido = var_PosPedido
		AND Pedidos.PosOrdenFac != var_PosOrdenFac;

	END LOOP;

	COMMIT;

END