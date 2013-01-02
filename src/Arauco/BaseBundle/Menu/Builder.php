<?php

namespace Arauco\BaseBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
      $menu = $factory->createItem('root');

      $item = $menu->addChild('Inicio', array('route' => 'arauco_home'));
      $item = $menu->addChild('Stock', array('route' => 'arauco_stock_index'));
      $item = $menu->addChild('Balance de masa', array('route' => 'arauco_balance_index'));

      return $menu;
    }
}