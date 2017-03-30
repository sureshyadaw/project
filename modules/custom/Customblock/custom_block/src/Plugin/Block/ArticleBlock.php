<?php

/**
 * @file
 * Contains \Drupal\article\Plugin\Block\XaiBlock.
 */

namespace Drupal\custom_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'article' block.
 *
 * @Block(
 *   id = "article_block",
 *   admin_label = @Translation("Article block"),
 *   category = @Translation("Custom article block example")
 * )
 */
class ArticleBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build() {

        /* calling form in the block */
     $form=\Drupal::formBuilder()->getForm('Drupal\depenedenddropdown\Form\depenedenddropdownForm');
      
      return $form;

 
// $comment_count = \Drupal::entityQuery('comment')
//    ->condition('entity_id', 27)
//    ->condition('entity_type', 'node')
//    ->condition('entity_bundle','') 
//    ->count()->execute();

//           return array(
//            '#type' => 'markup',
//            '#markup' => $this->t('heol<h3>Wlecome from Custom block</h3>.')
//                    //.$comment_count)
//        );
    }

}
