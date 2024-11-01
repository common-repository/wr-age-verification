<?php

	include_once( 'country-listing.php' );
	$countryListing = new Country_Listing();
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.webriderz.com/
 * @since      1.0.0
 *
 * @package    Age_Verification
 * @subpackage Age_Verification/public/partials
 */
?>
<div class="av_section">
	<div class="container">
		<div class="row">
			<div class="col-xl-12">
				<div class="av_area">
					<ul class="nav av_tabs">
					    <li class="nav-item">
					        <a class="nav-link" href="<?php echo admin_url('admin.php?page=age-verification')?>">Age Verification Settings</a>
					    </li>
					    <li class="nav-item">
					        <a class="nav-link active" href="<?php echo admin_url('admin.php?page=add-country')?>">Add Country</a>
					    </li>
					</ul>
					<div class="row">
						<div class="col-xl-12">
							<div class="card">
								<?php
									$countryListing->prepare_items();
								?>
								<div class="card-header">
									<h4>Country Listing</h4>
									<?php
									echo "<form method='post' autocomplete='off' name='frm_search_post' action='" .esc_url( $_SERVER['PHP_SELF'] ). "?page=add-country'>";
									$countryListing->search_box("Search", "search_post_id");
									echo "</form>"; 
									?>
								</div>
							  	<div class="card-body">
					  		    	<?php
					  			    	$countryListing->display(); 
					  		    	?>	
							    </div>
							</div>
					    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Country</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			</div>
		</div>
	</div>
</div>