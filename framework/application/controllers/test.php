<?php

class Test extends MY_Controller
{
	public function __construct(){
		parent::__construct();
		$this->view_dir = 'test'; 
		$this->setLayout('layout1');
		$this->view_as_data = true;

		$layoutVars['html_title'] = "HTML TITLE HERE!";
		
		$this->setVars($layoutVars);
		
	}
	
	public function view()
	{
		$u = new User;
		$u->where('id',2);
		$u->include_related('group','name');
		$u->get();

		$userdata['name'] = $u->fullname;
		$userdata['password'] = $u->password;
		$template_data['header'] = "WELCOME";
		$template_data['userdata'] = $userdata;
		
		$layoutVars['footer'] = "THIS IS A FOOTER for VIEW";		
		$this->setVars($layoutVars);
		
		$layout_data['main'] = $this->render(__FUNCTION__,$template_data);
			
		$this->load->view($this->getLayout(),$layout_data);		
	}

	public function view2()
	{
		$template_data['header'] = "VIEW 2";

		$layoutVars['footer'] = "THIS IS A FOOTER FOR VIEW 2";		
		$this->setVars($layoutVars);

		$layout_data['main'] = $this->render(__FUNCTION__,$template_data);

		$this->load->view($this->getLayout(),$layout_data);		
	}
	
	public function index()
	{
		/*
		$u = new User;

		$u->group_id = 2;
		$u->username = "alfred";
		$u->password = "123";
		$u->fullname = "alred tan";
		$u->save();
		*/

		$u = new User;
		$u->where('group_id',2);
		$u->include_related('group','name');
		$u->get();
		
		foreach ($u as $user)
		{
			$user->group->get();
			firephp("password: {$user->id}" . $user->password);
			echo $user->id . " " . $user->group->name  . " " . $user->username . '<br/>';
		}
	}
}