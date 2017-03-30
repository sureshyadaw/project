<?php
 

function bd_contact_views_data() {
    $data = array();
     $data['bd_contact'] = array();
     $data['bd_contact']['table'] = array();
     // Within 'table', the value of 'group' (translated string) is used as a
  // prefix in Views UI for this table's fields, filters, etc. When adding
  // a field, filter, etc. you can also filter by the group.  
  $data['bd_contact']['table']['group'] = t('Bd contact table');
   // Within 'table', the value of 'provider' is the module that provides schema
  // or the entity type that causes the table to exist. Setting this ensures
  // that views have the correct dependencies. This is automatically set to the
  // module that implements hook_views_data().
$data['bd_contact']['table']['provider'] = 'bd_contact';
  
// Some tables are "base" tables, meaning that they can be the base tables
  // for views. Non-base tables can only be brought in via relationships in
  // views based on other tables. To define a table to be a base table, add
  // key 'base' to the 'table' array:
  $data['bd_contact']['table']['base'] = array(
    'field' => 'bd_contact_id', // This is the identifier field for the view. 
    'title' => t('bd contact table'), 
    'help' => t('Example table contains bd contact table content and can be related to nodes.'), 
    'weight' => -10,
  );

   // Some tables have an implicit, automatic relationship to other tables,
  // meaning that when the other table is available in a view (either as the
  // base table or through a relationship), this table's fields, filters, etc.
  // are automatically made available without having to add an additional
  // relationship. To define an implicit relationship that will make your
  // table automatically available when another table is present, add a 'join'
  // section to your 'table' section. Note that it is usually only a good idea
  // to do this for one-to-one joins, because otherwise your automatic join
  // will add more rows to the view. It is also not a good idea to do this if
  // most views won't need your table -- if that is the case, define a
  // relationship instead (see below).
  //
  // If you've decided an automatic join is a good idea, here's how to do it;
  // the resulting SQL query will look something like this:
  //   ... FROM example_table et ... JOIN node_field_data nfd
  //   ON et.nid = nfd.nid AND ('extra' clauses will be here) ...
  // although the table aliases will be different.
//  $data['bd_contact']['table']['join'] = array(
//    
//    'node' => array(
//      'left_field' => 'id', 
//      'field' => 'id',
//    ),
//  );

   

   
//  $data['bd_contact']['id'] = array(
//    'title' => t('Example content'), 
//    'help' => t('Some example content that references a node.'),
//    
//    'relationship' => array(
//      'base' => 'node', // The name of the table to join with 
//      'field' => 'id', // The name of the field to join with 
//      'id' => 'standard', 
//      'label' => t('Example node'),
//    ),
//  );
/*column fields which will be available in view add field
  -----------------BEGIN
 */
  // Example plain text field.
  $data['bd_contact']['name'] = array(
    'title' => t('name Plain text field'), 
    'help' => t('Just a plain text field of name .'), 
    'field' => array(
      'id' => 'standard',
    ), 
    'sort' => array(
      'id' => 'standard',
    ), 
    'filter' => array(
      'id' => 'string',
    ), 
    'argument' => array(
      'id' => 'string',
    ),
  );
  // Example plain text field.
  $data['bd_contact']['email'] = array(
    'title' => t('email Plain text field'), 
    'help' => t('Just a plain text field.'), 
    'field' => array(
      'id' => 'standard',
    ), 
    'sort' => array(
      'id' => 'standard',
    ), 
    'filter' => array(
      'id' => 'string',
    ), 
    'argument' => array(
      'id' => 'string',
    ),
  );
  // Example plain text field.
  $data['bd_contact']['message'] = array(
    'title' => t('message Plain text field'), 
    'help' => t('Just a plain text field.'), 
    'field' => array(
      'id' => 'standard',
    ), 
    'sort' => array(
      'id' => 'standard',
    ), 
    'filter' => array(
      'id' => 'string',
    ), 
    'argument' => array(
      'id' => 'string',
    ),
  );

/*
 //  // Example numeric text field.
//  $data['bd_contact']['numeric_field'] = array(
//    'title' => t('Numeric field'), 
//    'help' => t('Just a numeric field.'), 
//    'field' => array(
//      'id' => 'numeric',
//    ), 
//    'filter' => array(
//      'id' => 'numeric',
//    ), 
//    'sort' => array(
//      'id' => 'standard',
//    ),
//  );

  // Example boolean field.
//  $data['bd_contact']['boolean_field'] = array(
//    'title' => t('Boolean field'), 
//    'help' => t('Just an on/off field.'), 
//    'field' => array(
//      'id' => 'boolean',
//    ), 
//    'filter' => array(
//      'id' => 'boolean',
//      // Note that you can override the field-wide label: 
//      'label' => t('Published'),
//      // This setting is used by the boolean filter handler, as possible option. 
//      'type' => 'yes-no',
//      // use boolean_field = 1 instead of boolean_field <> 0 in WHERE statment. 
//      'use_equal' => TRUE,
//    ), 
//    'sort' => array(
//      'id' => 'standard',
//    ),
//  );
//
//  // Example timestamp field.
//  $data['bd_contact']['timestamp_field'] = array(
//    'title' => t('Timestamp field'), 
//    'help' => t('Just a timestamp field.'), 
//    'field' => array(
//      'id' => 'date',
//    ), 
//    'sort' => array(
//      'id' => 'date',
//    ), 
//    'filter' => array(
//      'id' => 'date',
//    ),
//  );
*/
  return $data;
}