<!DOCTYPE html>
<html>
<?= $this->flexi->getHead() ?>
<body>

<h1>Template Page Example</h1>
<p>This is an example of the template file.</p>

<header>
<?= $this->flexi->getPartial('header') ?>
</header>


<div class="breadcrumbs">
<h1>Breadcrumbs</h1>
<?= $this->flexi->getBreadcrumbs(false) ?>
</div>

<aside>
<?= $this->flexi->getPartial('sidebar') ?>
</aside>

<div class="content">
<?= $this->flexi->getContent() ?>
</div>

<footer>
<?= $this->flexi->getPartial('footer') ?>
</footer>

</body>
</html>