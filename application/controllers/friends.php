<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friends extends CI_Controller {

	function __construct() {

		parent::__construct();
		$this->load->model('User');

	}

	function index() {

		$current_user_id = $this->session->userdata['user_info']['id'];

		$data['current_user'] = $this->session->userdata('user_info');
		$data['users_list'] = $this->User->get_all_users($current_user_id);
		$data['friends_list'] = $this->User->get_friends($current_user_id);
		$data['count_friends'] = $this->User->count_friends($current_user_id);

		$this->load->view('friends/friends', $data);

	}

	function add($user_id) {

		$this->User->create_friend($user_id);
		redirect('friends');

	}

	function remove($friend_id) {

		$this->User->remove_friend($friend_id);
		redirect('friends');

	}

	function show($friend_id) {

		$data['friend_info'] = $this->User->get_friend_info($friend_id);

		$this->load->view("friends/profile", $data);

	}

}

?>