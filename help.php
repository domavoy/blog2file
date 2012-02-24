<?php
require_once('session.php');
require_once("tmpl/header.php");
?>
<div class="pageContent root">
  <div class="createForm" style = "padding-left: 50px">
  
<h1><?=Lang::get(Lang::help_header)?></h1>
<ul style="list-style-type: none; list-style-image: none; list-style-position: outside; padding-left: 0px;">
	<li><a href="#q1"><?=Lang::get(Lang::help_about_link)?></a></li>
	<li><a href="#q2"><?=Lang::get(Lang::help_principes_link)?></a></li>
	<li><a href="#q4"><?=Lang::get(Lang::help_files_link)?></a></li>
	<li><a href="#q5"><?=Lang::get(Lang::help_invite_link)?></a></li>
	<li><a href="#q6"><?=Lang::get(Lang::help_support_link)?></a></li>
</ul>

<h3 id="q1"><?=Lang::get(Lang::help_about_link)?></h3>
<?=Lang::get(Lang::help_about_text)?>

<h3 id="q3"><?=Lang::get(Lang::help_blogs_link)?></h3>
<?=Lang::get(Lang::help_blogs_text)?>

<h3 id="q4"><?=Lang::get(Lang::help_files_link)?></h3>
<?=Lang::get(Lang::help_files_text)?>

<h3 id="q5"><?=Lang::get(Lang::help_invite_link)?></h3>
<?=Lang::get(Lang::help_invite_text)?>

<h3 id="q6"><?=Lang::get(Lang::help_support_link)?></h3>
<?=Lang::get(Lang::help_support_text)?>

<?php
require_once("tmpl/footer.php");
?>