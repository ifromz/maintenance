<script type="text/template" data-grid="inventory" data-template="results">

    <% _.each(results, function(r){ %>

    <tr>
        <td><%= r.id %></td>
        <td><%= r.sku %></td>
        <td><a href="<%= r.view_url %>"> <%= r.name %> </a></td>
        <td><%= r.category %></td>
        <td><%= r.current_stock %></td>
        <td><%= r.created_at %></td>
    </tr>

    <% }); %>

</script>
