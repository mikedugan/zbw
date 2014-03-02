<?php

class ForumController extends BaseController {

	public function getIndex()
	{
		$data = [
			'title' => 'vZBW Forums'
		];
		return View::make('forum.index', $data);
	}

}
