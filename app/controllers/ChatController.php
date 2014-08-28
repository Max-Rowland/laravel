<?php

class ChatController extends BaseController {

	public function index() {
		return View::make('chat/chat', array(
			'messages' => "I'M A MESSAGE"
		));
	}
}

?>