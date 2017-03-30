<?php
    /**
     * @file
     * Contains \Drupal\bulk_email\Form\EmailForm.
     */

    namespace Drupal\depenedenddropdown\Form;
    use Drupal\Core\Form\FormBase;
    use Drupal\Core\Form\FormStateInterface;
    //use Drupal\Component\Utility\UrlHelper;

    class AjaxAddMore extends FormBase {
        public function getFormId() {
            return "bulk_email_form";
        }

        public function buildForm(array $form, FormStateInterface $form_state) {
            $form['#tree'] = TRUE;

            $form['users'] = array(
              '#type' => 'fieldset',
              '#title' => t('Users'),
              '#prefix' => '<div id="users-wrapper">',
              '#suffix' => '</div>',
            );

            $num_users = $form_state->getValue('num_users');
            if (empty($num_users)) {
                $num_users = 1;
            }
            for ($i = 0; $i < $num_users; $i++) {
                $form['users'][$i] = array(
                    '#type'  => 'textfield',
                    '#description' => t('Select a user.'),
                );
            }

            $form['users']['users_more'] = array(
                '#type' => 'submit',
                '#value' => t('Add one'),
                '#submit' => array($this, 'bulk_email_addfieldsubmit'),
                '#ajax' => array(
                     'callback' => array($this, 'bulk_email_add_more_callback'),
                     'wrapper' => 'users-wrapper',
                ),
            );

            $form['actions'] = array('#type' => 'actions');
            $form['submit'] = array(
                '#type' => 'submit',
                '#value' => t('Send'),
            );
            return $form;
        }

        public function submitForm(array &$form, FormStateInterface $form_state) {
            // submit code
        }

        public function bulk_email_addfieldsubmit(array &$form, FormStateInterface $form_state) {
            $num_users = $form_state->get('num_users') + 1;
            $form_state->set('num_users', $num_users);
            $form_state->setRebuild(TRUE);
        }

        public function bulk_email_add_more_callback(array &$form, FormStateInterface $form_state) {
            return $form['users'];
        }
    }
?>
