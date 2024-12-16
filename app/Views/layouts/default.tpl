<!doctype html>
<html>

<head>
    <title> {block name="title"}{$title}{/block}</title>
    <!-- <link rel="stylesheet" href="..\..\styles.css"> -->
    {block name="styles"}{/block}
</head>

<body>

{if !isset($login)}
    {include file="templates/header.tpl"}
    {include file="templates/menu.tpl"}
    {/if}
    
    <main>
       
        {block name="content"}
            content
        {/block}
    </main>

    {include file="templates/footer.tpl"}

    {block name="js"} {/block}
</body>

</html>