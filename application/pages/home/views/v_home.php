<?php
/**
 * Home main view file
 *
 * @author Pierre HUBERT
 */

?><div class="content-wrapper">
    <!-- Section header -->
    <section class="content-header">
        <h1>Home</h1>
    </section>

    <!-- Section content -->
    <section class="content">
        <p>Welcome to the Automated Mail Sending System.</p>

        <!-- Quick stats -->
        <div class="row">
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="info-box">
						<span class="info-box-icon bg-aqua"><i class="fa fa-inbox"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">MESSAGES IN OUTBOX</span>
							<span class="info-box-number" id="messagesInOutbox">%</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="info-box">
						<span class="info-box-icon bg-red"><i class="fa fa-calendar-times-o"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">NOT PLANNED</span>
							<span class="info-box-number" id="notPlannedMessages">%</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->

				<!-- fix for small devices only -->
				<div class="clearfix visible-sm-block"></div>

				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="info-box">
						<span class="info-box-icon bg-green"><i class="fa fa-calendar-check-o"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">PLANNED</span>
							<span class="info-box-number" id="plannedMessages">%</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="info-box">
						<span class="info-box-icon bg-yellow"><i class="fa fa-clock-o"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">IN QUEUE</span>
							<span class="info-box-number" id="messagesInQueue">%</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
			</div>
    </section>
</div>