<?php

require_once dirname(__FILE__).'/../lib/usuariosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/usuariosGeneratorHelper.class.php';

/**
 * usuarios actions.
 *
 * @package    policarirubana
 * @subpackage usuarios
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class usuariosActions extends autoUsuariosActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->redirect('usuarios/show?id='.$this->getUser()->getGuardUser()->getId());
  }

  public function executeShow(sfWebRequest $request){
      $this->redirect('user/historial');
  }
  public function executeEdit(sfWebRequest $request)
  {
    if($request->getParameter('id')!=$this->getUser()->getGuardUser()->getId()) {
        $this->redirect('usuarios/edit?id='.$this->getUser()->getGuardUser()->getId());
    }

    $this->sf_guard_user = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->sf_guard_user);
  }

  public function executeDelete(sfWebRequest $request){
      $this->redirect('user/historial');
  }
  public function executeNew(sfWebRequest $request) {
      if(!$this->getUser()->isAuthenticated()) {
          $this->form = $this->configuration->getForm();
          $this->sf_guard_user = $this->form->getObject();
      } else {
          $this->redirect('user/historial');
      }
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    $val=0;
    if($form->getObject()->isNew()) { $val=1;}

    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'Los datos de inicio de sesion han sido enviados a su correo' : 'Los datos de inicio de sesion han sido enviados a su correo';

      try {
        $sf_guard_user = $form->save();

        if($val==1) {
         $user = Doctrine::getTable('SfGuardUser')->findOneBy('id',$sf_guard_user->getId());
         $contactenos="http://magueymarket.com/index.php/contactenos";
         $homepage="http://magueymarket.com/index.php";
         $logo="http://magueymarket.com/images/logo.png";
         $myaccount="http://magueymarket.com/index.php/user";
         $usuario="Hola ".$user->getFirstName().",";
         $usuario2=$sf_guard_user->getUsername();
         $password="";

            $texto= <<<EOF
                 <table style="width:640px;color:rgb(51,51,51);margin:0 auto;border-collapse:collapse">
   <tbody>
       <tr>
           <td style="padding:0 20px 20px 20px;vertical-align:top;font-size:13px;line-height:18px;font-family:Arial,sans-serif">
               <table style="width:100%;border-collapse:collapse">
                   <tbody>
                       <tr>
                           <td style="vertical-align:top;font-size:13px;line-height:18px;font-family:Arial,sans-serif"> </td>
                       </tr>
                       <tr>
                           <td style="vertical-align:top;font-size:13px;line-height:18px;font-family:Arial,sans-serif">
                               <table style="width:100%;border-collapse:collapse">
                                   <tbody>
                                       <tr>
                                           <td rowspan="2" style="width:115px;padding:20px 20px 0 0;vertical-align:top;font-size:13px;line-height:18px;font-family:Arial,sans-serif">
                                               <a href="$homepage" title="Visit www.magueymarket.com" style="text-decoration:none;color:rgb(0,102,153);font:12px/16px Arial,sans-serif" target="_blank">
                                                   <img alt="magueymarket.com" src="$logo" style="border:0;width:115px">
                                               </a>
                                           </td>
                                           <td style="text-align:right;padding:5px 0;border-bottom:1px solid rgb(204,204,204);white-space:nowrap;vertical-align:top;font-size:13px;line-height:18px;font-family:Arial,sans-serif"> </td>
                                           <td style="width:100%;text-align:right;padding:5px 0;border-bottom:1px solid rgb(204,204,204);white-space:nowrap;vertical-align:top;font-size:13px;line-height:18px;font-family:Arial,sans-serif">
                                               <div>
                                                   <a href="$contactenos" style="border-right:0px solid rgb(204,204,204);margin-right:0px;padding-right:0px;text-decoration:none;color:rgb(0,102,153);font:12px/16px Arial,sans-serif" target="_blank">Tus recomendaciones</a>
                                                   <div></div>
                                               </div>
                                           </td>
                                           <td style="text-align:right;padding:5px 0;border-bottom:1px solid rgb(204,204,204);white-space:nowrap;vertical-align:top;font-size:13px;line-height:18px;font-family:Arial,sans-serif">
                                               <span style="text-decoration:none;color:rgb(204,204,204);font-size:15px;font-family:Arial,sans-serif">&nbsp;|&nbsp;</span>
                                               <a href="$myaccount" style="border-right:0px solid rgb(204,204,204);margin-right:0px;padding-right:0px;text-decoration:none;color:rgb(0,102,153);font:12px/16px Arial,sans-serif" target="_blank">Tu cuenta</a
                                               <span style="text-decoration:none;color:rgb(204,204,204);font-size:15px;font-family:Arial,sans-serif">&nbsp;|&nbsp;</span>
                                               <a href="$homepage" style="border:0;margin:0;padding:0;border-right:0px solid rgb(204,204,204);margin-right:0px;padding-right:0px;text-decoration:none;color:rgb(0,102,153);font:12px/16px Arial,sans-serif" target="_blank">magueymarket.com</a>
                                           </td>
                                       </tr>
                                       <tr>
                                           <td colspan="3" style="text-align:right;padding:7px 0 5px 0;vertical-align:top;font-size:13px;line-height:18px;font-family:Arial,sans-serif">
                                               <h2 style="font-size:20px;line-height:24px;margin:0;padding:0;font-weight:normal;color:rgb(0,0,0)!important">
                                                   Confirmacion datos de usuario
                                                       </h2>
                                                   <br/>
                                           </td>
                                       </tr>
                                   </tbody>
                               </table>
                           </td>
                       </tr>
                       <tr>
                           <td style="vertical-align:top;font-size:13px;line-height:18px;font-family:Arial,sans-serif">
                               <table style="width:100%;border-collapse:collapse">
                                   <tbody>
                                       <tr>
                                           <td style="vertical-align:top;font-size:13px;line-height:18px;font-family:Arial,sans-serif">
                                               <h3 style="font-size:18px;color:rgb(204,102,0);margin:15px 0 0 0;font-weight:normal">$usuario</h3>
                                               <p style="margin:1px 0 8px 0;font:12px/16px Arial,sans-serif">
                                                   <br/>Estimado cliente, </p>
                                               <p style="margin:1px 0 8px 0;font:12px/16px Arial,sans-serif">
                                                   Le recordamos que su nombre de usuario es <b>$usuario2</b></p>
                                               <p style="margin:1px 0 8px 0;font:12px/16px Arial,sans-serif">
                                                   <br/><br/>Para acceder a tu cuenta puedes hacerlo a través del siguiente enlace <a href="$myaccount"> Mi cuenta</a></p>
                                           </td>
                                       </tr>
                                   </tbody>
                               </table>
                           </td>
                       </tr>
                   </tbody>
               </table>
           </td>
       </tr>
   </tbody>
</table>

EOF;
            $correo=$sf_guard_user->getEmailAddress();

            $message = $this->getMailer()->compose();
            $message->setSubject("Datos de usuario para acceder en magueymarket.com");
            $message->setTo($correo);
            $message->setFrom("noreply@magueymarket.com");
            $message->setBody($texto, 'text/html');
            $this->getMailer()->send($message);

            $this->getUser()->setFlash('notice', $notice);

            $this->redirect('user');
          } else {
            $this->getUser()->setFlash('notice', "Los datos han sido guardados correctamente");
            $this->redirect('user/micuenta');
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

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $sf_guard_user)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');

        $this->redirect('@sf_guard_user_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

        $this->redirect(array('sf_route' => 'sf_guard_user_show', 'sf_subject' => $sf_guard_user));
      }
    }
    else
    {
      if($val == 0) {
        $this->getUser()->setFlash('error', sprintf('Error, la información que usted ha proporcionado no era válida, por favor vuelva a escribirla'));
        $this->redirect('user/micuenta');
      }
      $this->getUser()->setFlash('error', sprintf('Error, la información que usted ha proporcionado no era válida, por favor vuelva a escribirla'));
      //$this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
    }
  }

}
