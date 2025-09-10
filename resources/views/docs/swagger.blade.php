<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>HanindyaMom API Docs</title>
	<link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist/swagger-ui.css">
	<style>
		html, body { margin:0; padding:0; height:100%; }
		#swagger-ui { height: 100%; }
	</style>
</head>
<body>
	<div id="swagger-ui"></div>
	<script src="https://unpkg.com/swagger-ui-dist/swagger-ui-bundle.js"></script>
	<script>
		window.ui = SwaggerUIBundle({
			url: '/docs/openapi.yaml',
			dom_id: '#swagger-ui',
			deepLinking: true,
			presets: [SwaggerUIBundle.presets.apis],
			layout: 'BaseLayout'
		});
	</script>
</body>
</html>


