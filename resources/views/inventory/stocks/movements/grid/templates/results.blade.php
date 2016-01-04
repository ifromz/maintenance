<script type="text/template" data-grid="inventory-stocks-movements" data-template="results">

    <% _.each(results, function(r){ %>

    <tr>
        <td><a href="<%= r.view_url %>"> <%= r.change %></a></td>
        <td><%= r.before %></td>
        <td><%= r.after %></td>
        <td><%= r.cost %></td>
        <td><%= r.reason %></td>
        <td><%= r.user %></td>
        <td><%= r.created_at %></td>
    </tr>

    <% }); %>

</script>
