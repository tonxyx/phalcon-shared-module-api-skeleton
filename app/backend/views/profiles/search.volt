{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("admin/profiles/index", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ link_to("admin/profiles/create", "Create profiles", "class": "btn btn-primary") }}
    </li>
</ul>

{% for profile in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Active?</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ profile.id }}</td>
            <td>{{ profile.name }}</td>
            <td>{{ profile.active == true ? 'Yes' : 'No' }}</td>
            <td width="12%">{{ link_to("admin/profiles/edit/" ~ profile.id, '<i class="icon-pencil"></i> Edit', "class": "btn") }}</td>
            <td width="12%">{{ link_to("admin/profiles/delete/" ~ profile.id, '<i class="icon-remove"></i> Delete', "class": "btn") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("admin/profiles/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("admin/profiles/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                    {{ link_to("admin/profiles/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("admin/profiles/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No profiles are recorded
{% endfor %}