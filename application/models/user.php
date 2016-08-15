<?php

// date_default_timezone_set('America/Los_Angeles');

class User extends CI_Model {

	function create_user($user_params) {

		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('alias', 'Alias', 'trim|required|min_length[3]|is_unique[users.alias]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'trim|required');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'required');

		if ($this->form_validation->run() === false) {
			
			$this->session->set_flashdata('errors', validation_errors());

			return false;

		} else {
			
			$query = "INSERT INTO users (name, alias, email, password, password_confirm, dob, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
			$values = array($user_params['name'], $user_params['alias'], $user_params['email'], $user_params['password'], $user_params['password_confirm'], $user_params['dob'], date("Y-m-d, H:i:s"), date("Y-m-d, H:i:s"));
			$this->db->query($query, $values);

			$this->session->set_flashdata('success', 'You have successfully registered!');

		}
		

	}

	function get_user($user) {

		$query = "SELECT *
				  FROM users
				  WHERE email = ? AND password = ?";
		$values = array($user['email'], $user['password']);

		return $this->db->query($query, $values)->row_array();

	}

	function get_all_users($user_id) {

		$query = "SELECT *
				  FROM users
				  WHERE users.id != ?
				  AND users.id
				  NOT IN (SELECT friends.friend_id FROM friends WHERE friends.user_id = ?)";
		$value = array($user_id, $user_id);

		return $this->db->query($query, $value)->result_array();

	}

	function get_user_info($user_id) {

		$query = "SELECT *
				  FROM users
				  WHERE users.id = ?";
		$value = array($user_id);

		return $this->db->query($query, $value)->row_array();

	}

	function get_friends($user_id) {

		$query = "SELECT friend.id as friend_id, friend.alias as friend_alias, friend.email as friend_email
				  FROM users
				  LEFT JOIN friends
					ON friends.user_id = users.id
				  LEFT JOIN users as friend
					ON friends.friend_id = friend.id
				  WHERE users.id = ?";
		$value = array($user_id);

		return $this->db->query($query, $value)->result_array();

	}

	function count_friends($current_user) {

		$query = "SELECT count(*) as count
				  FROM friends
				  WHERE user_id = ?";
		$value = array($current_user);
		
		return $this->db->query($query, $value)->row_array();

	}

	function create_friend($friend_id) {

		$current_user = $this->session->userdata['user_info']['id'];
		$query = "INSERT INTO friends (user_id, friend_id)
				  VALUES (?, ?)";
		$values = array($current_user, $friend_id);

		return $this->db->query($query, $values);

	}

	function remove_friend($friend_id) {

		$current_user = $this->session->userdata['user_info']['id'];
		$query = "DELETE FROM friends
				  WHERE user_id = ? AND friend_id = ?";
		$values = array($current_user, $friend_id);

		return $this->db->query($query, $values);

	}

	function get_friend_info($friend_id) {

		$query = "SELECT friend.name as name, friend.alias as alias, friend.email as email
				  FROM users
				  LEFT JOIN friends
					ON friends.user_id = users.id
				  LEFT JOIN users as friend
					ON friends.friend_id = friend.id
				  WHERE friend.id = ?";
		$value = array($friend_id);

		return $this->db->query($query, $value)->row_array();

	}

}

?>