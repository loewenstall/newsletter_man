<?php

class MailerTask extends tx_scheduler_Task {
	public function execute() {
		if(1 == 2) {
			return false;
		} else return true;
	}
}
