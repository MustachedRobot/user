<?php

namespace User;
use Mustached\Message;

class Controller_Admin extends \Controller_Admin
{

	public function action_index()
	{
		$this->data['users'] = \DB::select('id', 'firstname', 'email', 'lastname', 'group', 'twitter')->from('users')->order_by('created_at', 'desc')->execute();
		return $this->_render('admin');
	}

	public function action_upgrade($id)
	{
		$u = Model_User::find($id);
		$u->group = 100;
		$u->save();

		Message::flash_success(\Lang::get('mustached.admin.user_upgraded', array('firstname' => $u->firstname, 'lastname' => $u->lastname)));
		\Response::redirect('admin/user');

	}

	public function action_downgrade($id)
	{
		$u = Model_User::find($id);
		$u->group = 1;
		$u->save();

		Message::flash_success(\Lang::get('mustached.admin.user_downgraded', array('firstname' => $u->firstname, 'lastname' => $u->lastname)));
		\Response::redirect('admin/user');
	}

}
