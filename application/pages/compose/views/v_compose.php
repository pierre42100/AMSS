<?php
/**
 * Compose a message main view file
 *
 * @author Pierre HUBERT
 */
?><div class="content-wrapper">
	<!-- Section header -->
	<section class="content-header">
		<h1><?=$pageTitle?></h1>
	</section>

	<!-- Section content -->
	<section class="content">
		<div class="box box-success">
			<div class="box-header with-border">
			  <h3 class="box-title"><?=$pageDescription?></h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">

				<!-- Messages target -->
				<div id="composeMessageTarget"></div>

				<!-- Mail ID -->
				<input type="hidden" id="mailID" name="mailID" value="<?=$mail_id?>" />

				<!-- Sender -->
				<div class="form-group fromField">
					<label id="label_from">From</label><br />
					<input class="form-control" placeholder="From: name" id="from_name" type="text" value="<?=$from_name?>" disabled />
					<input class="form-control" placeholder="From: mail" id="from_mail" type="email" value="<?=$from_mail?>" disabled />
			  	</div>
				
				<!-- Destination -->
				<div class="form-group">
					<label>To</label>
					<input class="form-control" placeholder="To: someone@example.com" id="destination" type="email" value="<?=$destination_mail?>" />
			  	</div>

				<!-- Subject of the mail -->
			  	<div class="form-group">
				  	<label>Subject</label>
					<input class="form-control" placeholder="Subject:" id="subject" type="text" value="<?=$subject?>" />
			  	</div>

				<!-- Mail content -->
			  	<div class="form-group">
					<textarea id="compose-textarea" class="form-control" style="height: 300px"><?=$message?></textarea>
			 	</div>
				
				<!-- Sending date & time -->
				<!-- Datepicker -->
			 	<div class="form-group">
					<label>Send on date &amp; time :</label>
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input class="form-control pull-right" id="datepicker" type="text" name="dateToSend" value="<?=$send_date?>" />
					</div>
				</div>

				<!-- Time picker -->
				<div class="bootstrap-timepicker">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-clock-o"></i>
							</div>

							<input type="text" class="form-control timepicker" id="timepicker" name="timeToSend" value="<?=$send_time?>" />
						</div>
						<!-- /.input group -->
					</div>
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<div class="pull-left">
					<!-- Save & Exit (go back to outbox) -->
					<button type="button" class="btn btn-default" onclick="AMSS.compose.saveAndExit();"><i class="fa fa-arrow-left"></i> Save &amp; Exit</button>
				</div>

				<div class="pull-right">
					
					<!-- Check form (debug only) -->
					<?php if(AMSS::getInstance()->config->get('site_mode') == "debug")
						echo '<button type="button" class="btn btn-default" onclick="AMSS.compose.notify_checkComposedMessage();"><i class="fa fa-check"></i> Check</button>';
					?>
					
					<!-- Save work -->
					<button type="button" class="btn btn-success" onclick="AMSS.compose.saveComposedMessage();"><i class="fa fa-save"></i> Save</button>

					<!-- Plan mail -->
					<button type="submit" class="btn btn-primary" onclick="AMSS.compose.planMail();"><i class="fa fa-clock-o"></i> Plan mail</button>
			 	</div>
			</div>
			<!-- /.box-footer -->
		  </div>
	</section>
</div>