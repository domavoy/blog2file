<?php
require_once('session.php');
require_once("tmpl/header.php");
?>
<div class="pageContent root">
  <div class="createForm" style = "padding-left: 50px">

<h1><?=Lang::get(Lang::about_title)?></h1>
<p><?=Lang::get(Lang::about_message)?></p>

<h3><?=Lang::get(Lang::about_uses)?></h3>
<ol style="font-weight: bold;">
  <li><?=Lang::get(Lang::about_use1)?></li>
  <li><?=Lang::get(Lang::about_use2)?></li>
  <li><?=Lang::get(Lang::about_use3)?></li>
</ol>

<p>
<?=Lang::get(Lang::about_idea)?></p>

<?php
require_once("tmpl/footer.php");
?>