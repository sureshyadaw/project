<?php
/**
@file
Contains \Drupal\bd_contact\Controller\AdminController.
 */

namespace Drupal\bd_contact\Controller;

use Drupal\bd_contact\BdContactStorage;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\Core\Link;

 

class AdminController extends ControllerBase {

function contentOriginal() {
  $url = Url::fromRoute('bd_contact_add');
  //$add_link = ;
  $add_link = '<p>' . \Drupal::l(t('+ AddNew Message'), $url) . '</p>';
 // Table header
  $header = array( 'id' => t('Id'), 'name' => t('Submitter name'), 'message' => t('Message'),'email' =>t('Email Id'), 'operations' => t('Delete'), );

  $rows = array();
  foreach(BdContactStorage::getAll() as $id=>$content) {
    // Row with attributes on the row and some of its cells.
    $rows[] = array( 'data' => array($id, $content->name, $content->message, l('Delete', "admin/content/bd_contact/delete/$id")) );
   }

   $table = array( '#type' => 'table', '#header' => $header, '#rows' => $rows, '#attributes' => array( 'id' => 'bd-contact-table', ), );
   return $add_link . drupal_render($table);
 }

//  public function content1() {
//    return array(
//      '#type' => 'markup',
//      '#markup' => t('Hello World'),
//    );
//  }

  function content() {
//    $url = Url::fromRoute('bd_contact_add'); 
//    $add_link = '<p>' . \Drupal::l(t('+ AddNew Message'), $url).'</p>';
// 
// $link = '<p>'.Link::fromTextAndUrl(t('+ AddNew Message1'), Url::fromRoute('bd_contact_add', [], ['fragment' => ' ', 'absolute' => TRUE]))->toString().'</p>';
// //$link = Link::fromTextAndUrl(t('Drupal 8 modules list'), Url::fromRoute('system.modules_list', [], ['fragment' => 'edit-modules-field-types', 'absolute' => TRUE]))->toString();
//
//  
//  
// $text = array(
//      '#type' => 'markup',       
//      '#markup' => $add_link.$link, 
//    );
$url = Url::fromRoute('bd_contact_add');
  $add_link = Link::fromTextAndUrl(t('New Message'), $url);
  $add_link = $add_link->toRenderable();
  // If you need some attributes.
  $add_link['#attributes'] = array('class' => array('button', 'button-action', 'button--primary', 'button--small'));
  
  
         // Table header.
    $header = array(
      'id' => t('Id/edit'),
      'name' => t('Submitter name'),
      'message' => t('Message'),
        'email_id'=>t('Email Id'),
      'operations' => t('Delete'),
    );
    $rows = array();
  $url = Url::fromRoute('bd_contact_add');
  $add_link = Link::fromTextAndUrl(t('New Message'), $url);
  $add_link = $add_link->toRenderable();
  // If you need some attributes.
  $add_link['#attributes'] = array('class' => array('button', 'button-action', 'button--primary', 'button--small'));
  
  
    foreach (BdContactStorage::getAll() as $id => $content) {
      // Row with attributes on the row and some of its cells.
      $editUrl = Url::fromRoute('bd_contact_edit', array('id' => $id));
      $deleteUrl = Url::fromRoute('bd_contact_delete', array('id' => $id));
      
 
      
      $rows[] = array(
        'data' => array(
          \Drupal::l($id, $editUrl),
          $content->name, $content->message,$content->email,
          \Drupal::l('Delete', $deleteUrl)
        ),
      );
    }
    $table = array(
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#attributes' => array(
        'id' => 'bd-contact-table',
      ),
    );
    //return $add_link . ($table);
    return array(
      $add_link,
      $table, 
    );
  }
}
  