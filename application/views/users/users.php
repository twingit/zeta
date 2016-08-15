<h1>Welcome!</h1>

<h2>Registration</h2>

<?php 

	if ($this->session->flashdata('errors')) {
		echo $this->session->flashdata('errors');
	}

	if ($this->session->flashdata('success')) {
		echo $this->session->flashdata('success');
	}

?>

<form action="/users/register" method="post">
	<p>Name: <input type="text" name="name"></p>
	<p>Alias: <input type="text" name="alias"></p>
	<p>Email: <input type="text" name="email"></p>
	<p>Password: <input type="password" name="password"></p>
	<p>*Password should be at least 8 characters</p>
	<p>Confirm Password: <input type="password" name="password_confirm"></p>
	<p>Date of Birth: <input type="date" name="dob"></p>
	<p><input type="submit" value="Register"></p>
</form>

<h2>Login</h2>

<?php 

	if ($this->session->flashdata('login_error')) {
		echo $this->session->flashdata('login_error');
	}

?>

<form action="/users/login" method="post">
	<p>Email: <input type="text" name="email"></p>
	<p>Password: <input type="password" name="password"></p>
	<p><input type="submit" name="Login"></p>
</form>

