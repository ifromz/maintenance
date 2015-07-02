<script type="text/template" data-grid="users" data-template="results">

    <% _.each(results, function(r){ %>

    <tr>
        <td><%= r.id %></td>
        <td><a href="<%= r.view_url %>"> <%= r.first_name %> </a></td>
        <td><%= r.last_name %></td>
        <td><%= r.email %></td>
        <td><%= r.created_at %></td>
    </tr>

    <% }); %>

</script>
