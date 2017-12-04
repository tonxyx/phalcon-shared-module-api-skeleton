
{{ content() }}

<form method="post">

<h2>Manage Permissions</h2>

<div class="well" align="center">

	<table class="perms">
		<tr>
			<td><label for="profileId">Profile</label></td>
			<td>{{ select('profileId', profiles, 'using': ['id', 'name'], 'useEmpty': true, 'emptyText': '...', 'emptyValue': '') }}</td>
			<td>{{ submit_button('Search', 'class': 'btn btn-primary', 'name' : 'search') }}</td>
		</tr>
	</table>

</div>

{% if request.isPost() and profile %}

{% for module, actionsCollection in acl.getResources() %}

	<h3>{{ module }}</h3>

	<table class="table table-bordered table-striped" align="center">
		<thead>
			<tr>
				<th width="5%"></th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
			{% for controller, actions in actionsCollection %}
  			{% if actions is type('array') %}
          {% for action in actions %}
            <tr>
              <td align="center">
                <input type="checkbox" name="permissions[]"
                value="{{ module ~ '_' ~ controller ~ '.' ~ action }}"
                {% if permissions[module ~ '_' ~ controller ~ '.' ~ action] is defined %}
                  checked="checked"
                {% endif %}>
              </td>
              <td>
                {{ module ~ ' -> ' ~ controller ~ ' -> ' ~ action }}
              </td>
            </tr>
          {% endfor %}
        {% endif %}
			{% endfor %}
		</tbody>
	</table>

{% endfor %}

{{ submit_button('Submit', 'class': 'btn btn-primary', 'name':'submit') }}

{% endif %}

</form>
