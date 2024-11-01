<?php
    include_once( 'country-listing.php' );
    $countryListing = new Country_Listing();
    $upload_dir = wp_upload_dir();
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.webriderz.com/
 * @since      1.0.0
 *
 * @package    Age_Verification
 * @subpackage Age_Verification/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="av_section">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="av_area">
                    <?php 
                        if (!empty($msg)) {
                    ?>
                        <div class="alert alert-success alert-dismissible mt-2">
                          <button type="button" class="close" data-dismiss="alert">&times;</button> 
                          <strong>Success!</strong> <?php echo esc_html($msg['msg']);?>
                        </div>
                    <?php   
                        }
                    ?>
                    <ul class="nav av_tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="<?php echo admin_url('admin.php?page=age-verification')?>">Age Verification Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo admin_url('admin.php?page=add-country')?>">Add Country</a>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <?php echo esc_html(get_admin_page_title()); ?>
                                    <?php 
                                        if ($error) {
                                            echo '<p style="color:red;">'.$error.'</p>';
                                        }
                                    ?>
                                </div>
                                <?php
                                    if (!empty($settings)) {
                                        $form = 'update_settings';
                                        $action = esc_url($_SERVER['PHP_SELF']).'?page=age-verification&action=edit&id='.$settings->id;
                                    }/*else{
                                        $form = 'add_settings';
                                        $action =esc_url( $_SERVER['PHP_SELF']).'?page=age-verification';
                                    }*/
                                ?>
                                <div class="card-body">
                                    <?php if (!empty($settings)): ?>
                                    Status:
                                    <label class="switch">
                                      <input type="checkbox" id="status" data-id="<?php echo esc_html($settings->id)?>" value="<?php echo esc_html($settings->status)?>" <?php echo esc_html(($settings->status == 1) ? "checked" : "")?>>
                                      <span class="slider"></span>
                                    </label>
                                    <?php endif ?>

                                    <form id="<?php echo esc_attr($form); ?>" method="post" autocomplete="off" action="<?php echo esc_attr($action) ?>" enctype="multipart/form-data">
                                        <?php if (!empty($settings)): ?>
                                            <input type="hidden" name="av_id" value="<?php echo $settings->id; ?>">
                                        <?php endif ?>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2">Upload Your Logo:</label>
                                            <div class="col-sm-6">
                                            <p id="logo_error"></p>
                                              <input type="file" id="logo" class="form-control" name="logo_file" onchange="return fileValidation('logo')" >
                                            </div>
                                            <div class="col-sm-4">
                                                <?php
                                                    if (!empty($settings->logo)) {
                                                ?>
                                                    <img src="<?php echo $upload_dir['url'].'/'.$settings->logo?>" alt="..." style="height: 50px; width: 100px; margin-top: -8px;">
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2">Background Image:</label>
                                            <div class="col-sm-6">
                                            <p id="bg_error"></p>
                                              <input type="file" id="bg" class="form-control" name="bg_file" onchange="return fileValidation('bg')" >
                                            </div>
                                            <div class="col-sm-4">
                                                <?php
                                                    if (!empty($settings->image)) {
                                                ?>
                                                    <img src="<?php echo $upload_dir['url'].'/'.$settings->image?>" alt="..." style="height: 50px; width: 100px; margin-top: -8px;">
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2">Default Age</label>
                                            <div class="col-sm-6">
                                              <input type="text" id="age" name="age" class="form-control" placeholder="Age" value="<?php echo (!empty($settings) ? $settings->age : '')
                                                  ?>" onkeypress="javascript:return isNumber(event)" maxlength="2" required>
                                            </div>   
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2">Short Description</label>
                                            <div class="col-sm-6">
                                                <p id="d_error"></p>
                                                <textarea name="description" id="desc" cols="10" rows="5" placeholder="Enter Short Description" class="form-control"><?php 
                                                        echo (!empty($settings) ? $settings->description : '')
                                                    ?></textarea>
                                            </div>   
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="form-check-inline">
                                                      <label class="form-check-label">
                                                        <input type="radio" name="template" class="form-check-input" value="template_1"
                                                        <?php
                                                            if (isset($settings)) {
                                                                if($settings->template=="template_1"){
                                                                    echo 'checked';
                                                                }
                                                            }else{
                                                                echo 'checked';
                                                            }
                                                        ?>
                                                        >Template 1
                                                      </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                      <label class="form-check-label">
                                                        <input type="radio" name="template" class="form-check-input" value="template_2"
                                                        <?php
                                                            if (isset($settings)) {
                                                                if($settings->template=="template_2"){
                                                                    echo 'checked';
                                                                }
                                                            }
                                                        ?>
                                                        >Template 2
                                                      </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                      <label class="form-check-label">
                                                        <input type="radio" name="template" class="form-check-input" value="template_3"
                                                        <?php
                                                            if (isset($settings)) {
                                                                if($settings->template=="template_3"){
                                                                    echo 'checked';
                                                                }
                                                            }
                                                        ?>
                                                        >Template 3
                                                      </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                      <label class="form-check-label">
                                                        <input type="radio" name="template" class="form-check-input" value="template_4"
                                                        <?php
                                                            if (isset($settings)) {
                                                                if($settings->template=="template_4"){
                                                                    echo 'checked';
                                                                }
                                                            }
                                                        ?>
                                                        >Template 4
                                                      </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <img src="<?php echo plugin_dir_url(__DIR__).'/images/template.png'?>" id="display_template" alt="..." style="height: 100px; width: 200px;">
                                                </div>
                                                <div class="form-group">
                                                    <?php if (!empty($settings)): ?>
                                                        <input type="submit" name="update" value="save changes" class="btn btn-info btn-sm">
                                                    <?php else: ?>
                                                        <input type="submit" name="submit" value="Submit" class="btn btn-info btn-sm">
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
