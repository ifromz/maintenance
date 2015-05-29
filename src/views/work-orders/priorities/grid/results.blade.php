<script type="text/template" data-grid="main" data-template="results">

    <% _.each(results, function(r){ %>

    <tr>
        <td>
            <input data-grid-checkbox type="checkbox" name="entries[]" value="<%= r.id %>">
        </td>
        <td><a href="<%= r.view_url %>"> <%= r.name %> </a></td>
        <td><%= r.color %></td>
        <td><%= r.created_at %></td>
        <td><%= r.created_by %></td>
    </tr>

    <% }); %>

</script>
