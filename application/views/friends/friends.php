<h2>Welcome, <?= $current_user['name'] ?>! (<a href="/users/logout">Logout</a>)</h2>

<h3>Here Is the List of Your Friends:</h3>

<table>
	<thead>
		<th>Alias</th>
		<th>Action</th>
	</thead>
	<tbody>
		<? if ($count_friends['count'] === 0) { ?>
				
			<?= "You don't have friends yet." ?>

		<? } else { ?>
			
			<? foreach ($friends_list as $friend) { ?>
			<tr>
				<td><?= $friend['friend_alias'] ?></td>
				<td><a href="/friends/show/<?= $friend['friend_id'] ?>">View Profile</a> | <a href="/friends/remove/<?= $friend['friend_id'] ?>">Remove as Friend</a></td>
			</tr>
			<? } ?>

		<? } ?>
	</tbody>
</table>

<h3>Other Users Not on Your Friends List:</h3>

<table>
	<thead>
		<tr>
			<th>Alias</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($users_list as $user) { ?>
		<tr>
			<td><a href="/users/show/<?= $user['id'] ?>"><?= $user['alias'] ?></a></td>
			<td><a href="/friends/add/<?= $user['id'] ?>"><button>Add as Friend</button></a></td>
		</tr>
		<? } ?>
	</tbody>
</table>