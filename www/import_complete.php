<html>
<body>
<?php if (isset($_GET['revenue'])): ?>
	<h1>Import Successful!</h1>
	<p>Revenue: $<?php echo htmlspecialchars($_GET['revenue']) ?></p>
<?php elseif (isset($_GET['error'])): ?>
	<h1>Import Failed!</h1>
	<p><?php echo htmlspecialchars($_GET['error']) ?></p>
<?php endif; ?>
<p><a href="index.html">Import another file</a></p>
</body>
</html>