<?php
/**
 * Outbox main view file
 *
 * @author Pierre HUBERT
 */

?><div class="content-wrapper">
	<!-- Section header -->
	<section class="content-header">
		<h1>Outbox</h1>
	</section>

	<!-- Section content -->
	<section class="content">
		<div class="box box-purple">
			<div class="box-header with-border">
				<!-- Box title -->
				<h3 class="box-title">Messages in outbox</h3>

				<!-- Reload button -->
				<div class="box-tools pull-right">
					<button class="btn btn-default btn-sm" onclick="AMSS.outbox.reloadContent();">
						<i class="fa fa-fw fa-refresh"></i>
					</button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive">

				<!-- Messages target -->
				<div id="messagesTarget"></div>

				<!-- Show a table with all the content -->
				<table id="outboxContent" class="table table-hover ">
					<!-- Table header -->
					<thead>
						<tr>
							<th>Number</th>
							<th>ID</th>
							<th>From</th>
							<th>To</th>
							<th>Subject</th>
							<th>Send on</th>
							<th>Planned</th>
							<th>Actions</th>
						</tr>
					</thead>

					<!-- Table body -->
					<tbody id="outboxContentTarget">
						<tr><td style="text-align: center;" colspan="8">Please wait, loading messages...</td></tr>
					</tbody>

					<!-- Table footer -->
					<tfoot>
						<tr>
							<th>Number</th>
							<th>ID</th>
							<th>From</th>
							<th>To</th>
							<th>Subject</th>
							<th>Send on</th>
							<th>Planned</th>
							<th>Actions</th>
						</tr>
					</tfoot>
				</table>
			</div>
		  </div>
	</section>
</div>