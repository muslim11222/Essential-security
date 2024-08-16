<?php 


/**
 * Plugin name: essential security
 * Description: This is a essential security feature
 * Author: Muslim khan
 * 
 */

 class  es_essential_security {

     private $errors;
     public function __construct() {
          add_action('admin_menu', array($this, 'admin_menu'));
     }

     public function admin_menu() {
          add_menu_page( 
               'essential security',
               'security',
               'manage_options',
               'wp_security',
               array($this, 'this_is_essential_security')
          );
     }




     public function this_is_essential_security() {

               if ( isset( $_POST['ac_submit'], $_POST['ac_none']) ) {
                    $this->validate();

                    if ( wp_verify_nonce( $_POST['ac_none'], 'my_action') ) {
                         if ( empty( $this->errors ) ) {        // sanitize email ar akta part 
                              $this->save_data();
                         }
                    } else {
                         echo 'your are robot';
                         return;
                    }

               }


          ?>
               <h1> Wordpress Essential Security</h1>

               <form action="<?php echo admin_url('admin.php?page=wp_security') ?>" method="post">

                    
                    <input type="hidden" name="ac_none" value="<?php echo wp_create_nonce('my_action') ?>">


                    <table class="form-table">

                         <tbody>

                              <tr>
                                   <td>Name</td>

                                   <td> 
                                        
                                        <input type="text" name="ac_name" value="<?php echo isset($_POST['ac_name']) ? esc_html($_POST['ac_name']) : '' ?>">
                                             <?php if (isset( $this->errors['ac_name'])): ?>
                                             <p><?php echo  $this->errors['ac_name']; ?></p>
                                        <?php endif; ?>
                                   </td>
                              </tr>



                              <tr>
                                   <td>Email</td>

                                   <td> 
                                        <input type="text" name="ac_email" value="<?php echo isset($_POST['ac_email']) ? $_POST['ac_email'] : '' ?>">
                                             <?php if (isset( $this->errors['ac_email'])): ?>
                                             <p><?php echo  $this->errors['ac_email']; ?></p>
                                        <?php endif; ?>
                                   </td>
                              </tr>




                              <tr>
                                   <td>URL</td>

                                   <td> 
                                        <input type="text" name="ac_url" value="<?php echo isset($_POST['ac_url']) ? esc_url($_POST['ac_url']) : '' ?>">
                                             <?php if (isset( $this->errors['ac_url'])): ?>
                                             <p><?php echo  $this->errors['ac_url']; ?></p>
                                        <?php endif; ?>
                                   </td>
                              </tr>



                         </tbody>

                    </table>

                    <button class="button button-primary" name="ac_submit" type="submit">Submit</button>
               </form>
          <?php
     } 


     private function validate() {
          $this->errors = array();

          if ( empty( $_POST['ac_email'] ) ) {
               $this->errors['ac_email'] = 'pleace enter you email address';
          } else {
               if ( ! filter_var( $_POST['ac_email'], FILTER_VALIDATE_EMAIL) ) {
                    $this->errors['ac_email'] = 'Pleace Enter a Valid Email Address';
               }
          }

     }


     private function save_data() {
          echo ($_POST['ac_name']);                             // html sob bad kore dibe 
          $ac_name = sanitize_text_field($_POST['ac_name'] );
          echo "--" . $ac_name;
          
          
          // sanitize email dekhano holo 
          $email = sanitize_email($_POST['ac_email'] );      // sanitize email dekhano holo 
          // echo $email;
     }
 }


 new es_essential_security();