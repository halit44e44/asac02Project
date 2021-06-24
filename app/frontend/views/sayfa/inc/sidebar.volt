<div class="syf_sidebar">

    {% if cats is defined %}
        {% for cat in cats %}
        <h3>{{ cat.name }}</h3>
        <ul>
            {% for cont in contentbycatid(cat.id) %}
            <li><a class="{% if cont.sef is sef %}fw700{% endif %}" href="{{ url('sayfa/' ~ cont.sef) }}">{{ cont.name }}</a></li>
            {% endfor %}
        </ul>
        {% endfor %}
    {% endif %}

</div>