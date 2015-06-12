<html>
<head>
    <meta charset="UTF-8">
    <title>{$site.title}</title>
</head>
<body>
<h1>{$site.title}</h1>

<p>{$site.description}</p>

<ul>
    {foreach $list as $item}
        <li>{$item}</li>
    {/foreach}
</ul>
</body>
</html>