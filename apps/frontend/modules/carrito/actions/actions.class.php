<?php

require_once dirname(__FILE__).'/../lib/carritoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/carritoGeneratorHelper.class.php';

/**
 * carrito actions.
 *
 * @package    magueymarket.com
 * @subpackage carrito
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class carritoActions extends autoCarritoActions
{
	public function executeActualizar(){
		$this->getUser()->setFlash('notice', 'Carrito actualizado.');
		$this->redirect('carrito');
	}

	public function executeIndex(sfWebRequest $request) {
		$this->setSearch('');
		$filters=array(
			'sf_guard_user_id' => $this->getUser()->getGuardUser()->getId(),
		);

		$this->setFilters($filters);

		if ($request->getParameter('filters')) {
			$this->setFilters($request->getParameter('filters'));
		}

		if ($request->getParameter('sort')) {
			$this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
		}

		if ($request->getParameter('maxPerPage')) {
			$this->setMaxPerPage($request->getParameter('maxPerPage'));
			$this->setPage(1);
		}

		if ($request->getParameter('page')) {
			$this->setPage($request->getParameter('page'));
		}

		$this->pager = $this->getPager();
		$this->sort = $this->getSort();

		if ($request->isXmlHttpRequest()) {
			$partialFilter = null;
			sfConfig::set('sf_web_debug', false);
			$this->setLayout(false);
			sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'Date'));

			if ($request->hasParameter('search')) {
				$partialSearch = $this->getPartial('carrito/search', array('configuration' => $this->configuration));
			}

			if ($request->hasParameter('_reset')) {
				$partialFilter = $this->getPartial('carrito/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
			}

			$partialList = $this->getPartial('carrito/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));

			if (isset($partialSearch)) {
				$partialList .= '#__filter__#'.$partialSearch;
			}

			if (isset($partialFilter)) {
				$partialList .= '#__filter__#'.$partialFilter;
			}
			return $this->renderText($partialList);
		}
	}

	public function executeShow(sfWebRequest $request){
			$this->redirect('carrito');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->redirect('carrito');
	}

	public function executeNew(sfWebRequest $request) {
			$this->redirect('carrito');
	}

	public function executeProcesar(sfWebRequest $request) {
    $count_ccs = Doctrine_Core::getTable('OrdenCompra')
      ->createQuery('a')
      ->select('COUNT(id) as contador')
      ->Where("id LIKE '99%'")
      ->limit(1)
      ->execute();
    $count = 0;
    foreach ($count_ccs as $count_cc) {
      $count=$count_cc["contador"];
      break;
		}
		$id="99".($count+1);
			
		$order = new OrdenCompra();
		$order->id = $id;
		$order->ncontrol = $id;
		$order->empresa_id = 11;
		$order->deposito_id = 111;
		$order->cliente_id = $this->getUser()->getGuardUser()->getClienteId();
		$order->orden_compra_estatus_id = 1;
		$order->save();

		$carritos = Doctrine_Core::getTable('Carrito')
			->createQuery('a')
			->where('sf_guard_user_id = ?', $this->getUser()->getGuardUser()->getId())
			->orderBy('id DESC')
			->execute();

		$subtotal2=0; $i=0; $titulo=""; $titulo_cant=0;
		foreach ($carritos as $carrito) {
			if (!empty($carrito->getInventarioId())) {
				$inv = Doctrine::getTable('Inventario')->findOneBy('id', $carrito->getInventarioId());
				$producto = Doctrine::getTable('Producto')->findOneBy('id', $inv->getProductoId());
				$cid=$this->getUser()->getGuardUser()->getTipoPrecio();

				$productNombre=$producto->getNombre();
				$productPrice=$producto["precio_usd_$cid"];
				$productCantidad=$carrito->getCantidad();

				$details = new OrdenCompraDet();
				$details->orden_compra_id = $order->getId();
				$details->qty = $productCantidad;
				$details->descripcion = $producto->getDescripcion();
				$details->price_unit = $productPrice;
				$details->price_tot = ($productPrice*$carrito->getCantidad());
				$details->inventario_id = $carrito->getInventarioId();
				$details->save();

				$subtotal2+=($productPrice*$carrito->getCantidad());

				if($i==0) {
					$titulo=$productNombre;
				}
				$i++; $titulo_cant++;
				$carrito->delete();
			} elseif (!empty($carrito->getOfertaId())) {
				$oferta = Doctrine::getTable('Oferta')->findOneBy('id', $carrito->getOfertaId());

				$productNombre=$oferta->getNombre();
				$productPrice=$oferta["precio_usd"];
				$productCantidad=$carrito->getCantidad();

				$details = new OrdenCompraDet();
				$details->orden_compra_id = $order->getId();
				$details->qty = $productCantidad;
				$details->descripcion = $oferta->getDescripcion();
				$details->price_unit = $productPrice;
				$details->price_tot = ($productPrice*$carrito->getCantidad());
				$details->oferta_id = $carrito->getOfertaId();
				$details->save();

				$subtotal2+=($productPrice*$carrito->getCantidad());

				if($i==0) {
					$titulo=$productNombre;
				}
				$i++; $titulo_cant++;
				$carrito->delete();
			}
		}

		$titulo2="";
		if($titulo_cant=="1") {
			$titulo2=$titulo;
			$titulo='Tu orden de compra en droguesi.com de "'.$titulo.'".';
		} else {
			$titulo_cant=$titulo_cant-1;
			$titulo2=$titulo.'..." y '.$titulo_cant.' articulo(s) mas.';
			$titulo='Tu orden de compra en droguesi.com de "'.$titulo.'..." y '.$titulo_cant.' articulo(s) mas.';
		}

		$order->titulo = $titulo;
		$order->total = $subtotal2;
		$order->save();

		$this->getUser()->setFlash('notice', 'Su pedido ha sido realizado, un e-mail ha sido enviado a usted con los detalles del pedido.');
		$this->redirect('orden_compra/index?success=1');
	}

	public function executeReview(sfWebRequest $request) {
		$this->tipo = $request->getParameter('radio');

		$this->results = Doctrine_Query::create()
		->select('c.*')
		->from('Carrito c')
		->where('c.sf_guard_user_id = ?', $this->getUser()->getGuardUser()->getId())
		->execute();

		$this->shipping=Doctrine::getTable('SfGuardShippingAddress')->findOneBy('sf_guard_user_id',$this->getUser()->getGuardUser()->getId());
		$this->billing=Doctrine::getTable('SfGuardBillingAddress')->findOneBy('sf_guard_user_id',$this->getUser()->getGuardUser()->getId());

		$this->costo_envio=Doctrine::getTable('Estado')->findOneBy('nombre',$this->shipping->getEstado());
	}

	public function executeListado(sfWebRequest $request){
	}

	public function executeEliminarItem(sfWebRequest $request){
		$carrito=Doctrine::getTable('Carrito')->findOneBy('id',$request->getParameter('id'));
		$carrito->delete();

		$this->getResponse()->setContentType('application/json');
		return $this->renderText(json_encode("success"));					
	}

	public function executeActualizarItem(sfWebRequest $request){
		$carrito=Doctrine::getTable('Carrito')->findOneBy('id',$request->getParameter('id'));
		$carrito->cantidad=$request->getParameter('cantidad');
		$carrito->save();

		$this->getResponse()->setContentType('application/json');
		return $this->renderText(json_encode("success"));					
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

		if ($form->isValid()) {
			$notice = $form->getObject()->isNew() ? 'El artículo que ha seleccionado se ha añadido correctamente a su carrito.' : 'El artículo que ha seleccionado se ha añadido correctamente a su carrito.';

			try {
				$carrito = $form->save();
				
				$cars = Doctrine_Query::create()
					->select('c.*')
					->from('Carrito c')
					->where('c.inventario_id =?', $carrito->getInventarioId())
					->execute();
				$cant=0;
				foreach ($cars as $car) {
					$cant+=$car->getCantidad();
				}
				$i=0;
				foreach ($cars as $car) {
					if($i==0) {
						$car->cantidad=$cant;
						$car->save();
					} else {
						$car->delete();
					}
					$i++;
				}

				$cars = Doctrine_Query::create()
					->select('c.*')
					->from('Carrito c')
					->where('c.oferta_id =?', $carrito->getOfertaId())
					->execute();
				$cant=0;
				foreach ($cars as $car) {
					$cant+=$car->getCantidad();
				}
				$i=0;
				foreach ($cars as $car) {
					if($i==0) {
						$car->cantidad=$cant;
						$car->save();
					} else {
						$car->delete();
					}
					$i++;
				}

			} catch (Doctrine_Validator_Exception $e) {
				$errorStack = $form->getObject()->getErrorStack();
				$message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ?  's' : null) . " with validation errors: ";

				foreach ($errorStack as $field => $errors) {
					$message .= "$field (" . implode(", ", $errors) . "), ";
				}

				$message = trim($message, ', ');
				$this->getUser()->setFlash('error', $message);
				return sfView::SUCCESS;
			}

			$this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $carrito)));

			if ($request->hasParameter('_save_and_add')) {
				$this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');
				$this->redirect('@carrito_new');
			} else {
				$this->getUser()->setFlash('notice', $notice);
				$this->getResponse()->setContentType('application/json');
				return $this->renderText(json_encode("success"));
			}
		} else {
			$this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
		}
	}
}
