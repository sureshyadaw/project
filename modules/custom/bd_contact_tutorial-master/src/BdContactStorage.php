<?php

namespace Drupal\bd_contact;

class BdContactStorage {

  static function getAll() {
    $result = db_query('SELECT * FROM {bd_contact}')->fetchAllAssoc('id');
    return $result;
  }

  static function exists($id) {
    return (bool) $this->get($id);
  }

  static function get($id) {
    $result = db_query('SELECT * FROM {bd_contact} WHERE id = :id', array(':id' => $id))->fetchAllAssoc('id');
    if ($result) {
      return $result[$id];
    }
    else {
      return FALSE;
    }
  }

  static function add($name, $message,$email) {
    db_insert('bd_contact')->fields(array(
      'name' => $name,
      'message' => $message,
      'email' =>$email,
    ))->execute();
  }

  static function edit($id, $name, $message,$email) {
    db_update('bd_contact')->fields(array(
      'name' => $name,
      'message' => $message,
        'email' =>$email,
    ))
    ->condition('id', $id)
    ->execute();
  }
  
  static function delete($id) {
    db_delete('bd_contact')->condition('id', $id)->execute();
  }
}
