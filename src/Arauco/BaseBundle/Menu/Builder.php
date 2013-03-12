<?php

namespace Arauco\BaseBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Inicio', array('route' => 'arauco_home'));
        $menu->addChild('Stock', array('route' => 'arauco_stock_index'));
        $menu->addChild('Pedidos', array('route' => 'arauco_pedido_index'));
        $menu->addChild('Balance', array('route' => 'arauco_balance_index'));
        
        /*$pedidos->addChild('Todos', array('route' => 'arauco_pedido_index'));
        $pedidos->addChild('AASA', array('route' => 'arauco_pedido_index_aasa'));
        $pedidos->addChild('PASA', array('route' => 'arauco_pedido_index_pasa'));*/
        
        return $menu;
    }
}