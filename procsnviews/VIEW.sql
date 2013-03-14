create view PedidoView as (select DocEntrega, PosPedido, PosOrdenFac, count(PosOrdenFac) CantPosOrdenFac from Pedidos group by DocEntrega, PosPedido Order by DocEntrega);
