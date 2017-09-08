<div class="row">
	<div class="col-md-8">
		<?php echo form_open_multipart('clients/profile',array('autocomplete'=>'off')); ?>
		<?php echo form_hidden('profile',true); ?>
		<div class="panel_s">
			<div class="panel-body">
				<h4 class="no-margin"><?php echo _l('clients_profile_heading'); ?></h4>
			</div>
		</div>
		<div class="panel_s">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<?php if($contact->profile_image == NULL){ ?>
							<div class="form-group">
								<label for="profile_image" class="profile-image"><?php echo _l('client_profile_image'); ?></label>
								<input type="file" name="profile_image" class="form-control" id="profile_image">
							</div>
							<?php } ?>
							<?php if($contact->profile_image != NULL){ ?>
							<div class="form-group">
								<div class="row">
									<div class="col-md-9">
										<img src="<?php echo contact_profile_image_url($contact->id,'thumb'); ?>" class="client-profile-image-thumb">
									</div>
									<div class="col-md-3 text-right">
										<a href="<?php echo site_url('clients/remove_profile_image'); ?>"><i class="fa fa-remove text-danger"></i></a>
									</div>
								</div>
							</div>
							<?php } ?>
							<label for="firstname"><?php echo _l('clients_firstname'); ?></label>
							<input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo set_value('firstname',$contact->firstname); ?>">
							<?php echo form_error('firstname'); ?>
						</div>
						<div class="form-group">
							<label for="lastname"><?php echo _l('clients_lastname'); ?></label>
							<input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo set_value('lastname',$contact->lastname); ?>">
							<?php echo form_error('lastname'); ?>
						</div>
						<div class="form-group">
							<label for="title"><?php echo _l('contact_position'); ?></label>
							<input type="text" class="form-control" name="title" id="title" value="<?php echo $contact->title; ?>">
						</div>
						<div class="form-group">
							<label for="email"><?php echo _l('clients_email'); ?></label>
							<input type="text" class="form-control" disabled="true" id="email" value="<?php echo $contact->email; ?>">
						</div>
						<div class="form-group">
							<label for="phonenumber"><?php echo _l('clients_phone'); ?></label>
							<input type="text" class="form-control" name="phonenumber" id="phonenumber" value="<?php echo $contact->phonenumber; ?>">
						</div>
						<div class="form-group">
							<label for="direction"><?php echo _l('document_direction'); ?></label>
							<select class="form-control" name="direction" id="direction">
								<option value="" <?php if(empty($contact->direction)){echo 'selected';} ?>><?php echo _l('system_default_string'); ?></option>
								<option value="ltr" <?php if($contact->direction == 'ltr'){echo 'selected';} ?>>LTR</option>
								<option value="rtl" <?php if($contact->direction == 'rtl'){echo 'selected';} ?>>RTL</option>
							</select>
						</div>
						<?php echo render_custom_fields( 'contacts',get_contact_user_id(),array('show_on_client_portal'=>1)); ?>
					</div>
					<div class="row p15">
						<div class="col-md-12 text-right mtop20">
							<div class="form-group">
								<button type="submit" class="btn btn-info"><?php echo _l('clients_edit_profile_update_btn'); ?></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
	<div class="col-md-4">
		<div class="panel_s">
			<div class="panel-body">
				<h4 class="no-margin">	<?php echo _l('clients_edit_profile_change_password_heading'); ?></h4>
			</div>
		</div>
		<div class="panel_s">
			<div class="panel-body">
				<?php echo form_open('clients/profile'); ?>
				<?php echo form_hidden('change_password',true); ?>
				<div class="form-group">
					<label for="oldpassword"><?php echo _l('clients_edit_profile_old_password'); ?></label>
					<input type="password" class="form-control" name="oldpassword" id="oldpassword">
					<?php echo form_error('oldpassword'); ?>
				</div>
				<div class="form-group">
					<label for="newpassword"><?php echo _l('clients_edit_profile_new_password'); ?></label>
					<input type="password" class="form-control" name="newpassword" id="newpassword">
					<?php echo form_error('newpassword'); ?>
				</div>
				<div class="form-group">
					<label for="newpasswordr"><?php echo _l('clients_edit_profile_new_password_repeat'); ?></label>
					<input type="password" class="form-control" name="newpasswordr" id="newpasswordr">
					<?php echo form_error('newpasswordr'); ?>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-info btn-block"><?php echo _l('clients_edit_profile_change_password_btn'); ?></button>
				</div>
				<?php echo form_close(); ?>
			</div>
			<?php if($contact->last_password_change !== NULL){ ?>
			<div class="panel-footer">
				<?php echo _l('clients_profile_last_changed_password',time_ago($contact->last_password_change)); ?>
			</div>
			<?php } ?>
		</div>
	</div>

</div>
