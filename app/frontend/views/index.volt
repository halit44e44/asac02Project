<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    
    <meta http-equiv="X-UA-Compatible" content="IE-edge,chrome=1">
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <base href="{{ url('') }}">
    {% if page is defined %}
        {% if page is 'index' %}
            {{ title(0, "index") }}
            {{ keyword(0, 'index') }}
            {{ description(0, 'index') }}
        {% elseif page is 'cats' %}
            {% if cat_id is defined %}
                {{ title(cat_id, page) }}
                {{ keyword(cat_id, page) }}
                {{ description(cat_id, page) }}
            {% endif %}
        {% elseif page is 'brand' %}
            {% if brand_id is defined %}
                {{ title(brand_id, page) }}
                {{ keyword(brand_id, page) }}
                {{ description(brand_id, page) }}
            {% endif %}
        {% elseif page is 'user' %}
            {{ title(0, page) }}
            {{ keyword(0, page) }}
            {{ description(0, page) }}
        {% elseif page is 'basket' %}
            {{ title(0, page) }}
            {{ keyword(0, page) }}
            {{ description(0, page) }}
        {% elseif page is 'campaign' %}
            {{ title(0, page) }}
            {{ keyword(0, page) }}
            {{ description(0, page) }}
        {% elseif page is 'tumurunler' %}
            {{ title(0, page) }}
            {{ keyword(0, page) }}
            {{ description(0, page) }}
        {% elseif page is 'tags' %}
            {% if tags is defined %}
                {{ title(tags.id, page) }}
                {{ keyword(tags.id, page) }}
                {{ description(tags.id, page) }}
            {% endif %}
        {% elseif page is 'product' %}
            {% if pro_id is defined %}
                {{ title(pro_id, page) }}
                {{ keyword(pro_id, page) }}
                {{ description(pro_id, page) }}
            {% endif %}
        {% elseif page is 'search' %}
            {{ title(0, page) }}
            {{ keyword(0, page) }}
            {{ description(0, page) }}
        {% elseif page is 'content' %}
            {{ title(content_id, page) }}
            {{ keyword(content_id, page) }}
            {{ description(content_id, page) }}
        {% elseif page is 'contentcat' %}
        {% endif %}
    {% endif %}
    {{ partial('inc/head') }}
</head>
<body>

{{ partial('inc/header') }}

{{ content() }}

{{ partial('inc/footer') }}

</body>
</html>