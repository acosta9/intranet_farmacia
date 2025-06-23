<?php

require_once dirname(__FILE__).'/../lib/contactenosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/contactenosGeneratorHelper.class.php';

/**
 * contactenos actions.
 *
 * @package    intelconexcorp.com
 * @subpackage contactenos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class contactenosActions extends autoContactenosActions
{
  public function executeSuscribir(sfWebRequest $request) {
    $request->getParameter('email');

    $titulo='Una persona, se acaba de registrar en magueymarket.com';
    $correo="info@magueymarket.com";

    $mail=$request->getParameter('email');

    $texto= <<<EOF
                <h3>Nueva suscripcion en magueymarket.com</h3>
                <br/>
                <p>Correo: $mail</p>
EOF;

$this->getUser()->setFlash('notice', $notice.'Los datos han sido guardados correctamente, nos pondremos en contacto con usted tan pronto como nos sea posible.');

        $message = $this->getMailer()->compose();
        $message->setSubject($titulo);
        $message->setTo($correo);
        $message->setFrom("noreply@magueymarket.com");
        $message->setBody($texto, 'text/html');
        $this->getMailer()->send($message);

        $this->redirect('@homepage');

  }
  public function executeMicontrasena(sfWebRequest $request) {
    $request->getParameter('email');

    $usuario = Doctrine_Core::getTable('SfGuardUser')->findOneBy('username', $request->getParameter('email'));

    if($usuario) {
			$numero = rand(1, 3);

			if($numero==1) {
				$password_txt="74UQzuLm";
				$salt="d1d9cb0617fa7c345144c903cec5aa5c";
				$password="67f8cba459e53829b6a8fdd29eaf938c3b2676ff";
			} else if($numero==2) {
				$password_txt="QNeofp4y";
				$salt="d1d9cb0617fa7c345144c903cec5aa5c";
				$password="996355c6f464ec753cb62a7e1e9d16b22c75b90f";
			} else {
				$password_txt="KDfWkc0n";
				$salt="d1d9cb0617fa7c345144c903cec5aa5c";
				$password="edac57b812c82200a776f12eb80918f8f43df698";
			}

			$clave_nueva = new SfGuardUser();
			$clave_nueva->assignIdentifier($usuario->getId());
			$clave_nueva->password = $password_txt;
			$clave_nueva->save();

	    $titulo='Cambio de contraseña en magueymarket.com';
	    $correo=$request->getParameter('email');

	    $texto= <<<EOF
	                <h3>Su nueva clave de acceso a magueymarket.com es</h3>
	                <br/>
	                <p>Contraseña nueva: $password_txt</p>
EOF;

	    $message = $this->getMailer()->compose();
	    $message->setSubject($titulo);
	    $message->setTo($correo);
	    $message->setFrom("noreply@magueymarket.com");
	    $message->setBody($texto, 'text/html');
	    $this->getMailer()->send($message);

      $this->getUser()->setFlash('notice', 'Se ha enviado un email, con los datos correspondientes para su inicio de sesion.');
      $this->redirect('@user');
    } else {
      $this->getUser()->setFlash('error', 'El email utilizado no existe en nuestra base de datos.');
      $this->redirect('@user');
    }
  }
  public function executeIndex(sfWebRequest $request){
    $this->redirect('contactenos/new');
  }

  public function executeShow(sfWebRequest $request){
      $this->redirect('contactenos');
  }

  public function executeEdit(sfWebRequest $request){
    $this->redirect('contactenos');
  }

  public function executeDelete(sfWebRequest $request){
      $this->redirect('contactenos');
  }
  public function executeNew(sfWebRequest $request){
    $this->form = $this->configuration->getForm();
    $this->contactenos = $this->form->getObject();
  }

  protected function processForm(sfWebRequest $request, sfForm $form) {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      //$notice = $form->getObject()->isNew() ? 'Data saved correctly, we will get back to you as soon as we can.' : 'Data saved correctly, we will get back to you as soon as we can.';
      $this->getUser()->setFlash('notice', $notice.'Los datos han sido guardados correctamente, nos pondremos en contacto con usted tan pronto como nos sea posible.');


      try {
        $contactenos = $form->save();

        $titulo=$contactenos->getNombre().' Desea contactarse contigo en magueymarket.com';
        $correo="info@magueymarket.com";

        $nombre=$contactenos->getNombre();
        $mensaje=$contactenos->getMensaje();
        $mail=$contactenos->getEmail();

        $this->redirect('contactenos/new?success=1');
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

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $contactenos)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');

        $this->redirect('@contactenos_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

        $this->redirect(array('sf_route' => 'contactenos_show', 'sf_subject' => $contactenos));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', sprintf('Error, la información que usted ha proporcionado no era válida, por favor vuelva a escribirla'));
    }
  }

}
